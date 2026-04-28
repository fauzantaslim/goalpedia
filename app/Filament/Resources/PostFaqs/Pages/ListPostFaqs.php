<?php

namespace App\Filament\Resources\PostFaqs\Pages;

use App\Filament\Resources\PostFaqs\PostFaqResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPostFaqs extends ListRecords
{
    protected static string $resource = PostFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
