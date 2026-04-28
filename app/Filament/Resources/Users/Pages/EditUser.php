<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    private ?string $avatarPath = null;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->avatarPath = $data['avatar'] ?? null;
        unset($data['avatar']);

        return $data;
    }

    protected function afterSave(): void
    {
        if (! $this->avatarPath || ! Storage::disk('public')->exists($this->avatarPath)) {
            return;
        }

        $this->record
            ->addMediaFromDisk($this->avatarPath, 'public')
            ->toMediaCollection('avatars');

        Storage::disk('public')->delete($this->avatarPath);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
