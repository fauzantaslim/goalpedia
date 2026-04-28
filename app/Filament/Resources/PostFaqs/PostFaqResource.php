<?php

namespace App\Filament\Resources\PostFaqs;

use App\Filament\Resources\PostFaqs\Pages\CreatePostFaq;
use App\Filament\Resources\PostFaqs\Pages\EditPostFaq;
use App\Filament\Resources\PostFaqs\Pages\ListPostFaqs;
use App\Filament\Resources\PostFaqs\Schemas\PostFaqForm;
use App\Filament\Resources\PostFaqs\Tables\PostFaqsTable;
use App\Models\PostFaq;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PostFaqResource extends Resource
{
    protected static ?string $model = PostFaq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'question';

    public static function form(Schema $schema): Schema
    {
        return PostFaqForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostFaqsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPostFaqs::route('/'),
            'create' => CreatePostFaq::route('/create'),
            'edit' => EditPostFaq::route('/{record}/edit'),
        ];
    }
}
