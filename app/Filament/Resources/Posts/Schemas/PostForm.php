<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Artikel')
                    ->schema([
                        Hidden::make('user_id')
                            ->default(fn () => auth()->id())
                            ->required(),
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->label('Meta Description (SEO)')
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('Deskripsi singkat untuk hasil pencarian Google (Max 160 karakter).')
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Isi Artikel')
                            ->required()
                            ->columnSpanFull(),
                        SpatieTagsInput::make('tags')
                            ->label('Tag')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Cover Artikel')
                    ->schema([
                        FileUpload::make('cover_image')
                            ->label('Gambar Cover')
                            ->image()
                            ->disk('public')
                            ->directory('tmp/post-covers')
                            ->imagePreviewHeight('200')
                            ->columnSpanFull()
                            ->dehydrated(false),  // handled manually in Create/Edit pages
                    ]),

                Section::make('Publikasi')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'draft'     => 'Draft',
                                'published' => 'Published',
                                'archived'  => 'Archived',
                            ])
                            ->default('draft'),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Terbit')
                            ->seconds(false),
                    ])
                    ->columns(2),
            ]);
    }
}
