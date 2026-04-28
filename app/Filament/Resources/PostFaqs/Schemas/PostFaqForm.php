<?php

namespace App\Filament\Resources\PostFaqs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostFaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi FAQ')
                    ->schema([
                        Select::make('post_id')
                            ->label('Artikel')
                            ->relationship('post', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('question')
                            ->label('Pertanyaan')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('answer')
                            ->label('Jawaban')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
