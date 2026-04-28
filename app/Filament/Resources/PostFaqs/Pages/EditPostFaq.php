<?php

namespace App\Filament\Resources\PostFaqs\Pages;

use App\Filament\Resources\PostFaqs\PostFaqResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPostFaq extends EditRecord
{
    protected static string $resource = PostFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
