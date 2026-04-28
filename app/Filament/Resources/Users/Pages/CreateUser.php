<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    private ?string $avatarPath = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->avatarPath = $data['avatar'] ?? null;
        unset($data['avatar']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if (! $this->avatarPath || ! Storage::disk('public')->exists($this->avatarPath)) {
            return;
        }

        $this->record
            ->addMediaFromDisk($this->avatarPath, 'public')
            ->toMediaCollection('avatars');

        Storage::disk('public')->delete($this->avatarPath);
    }
}
