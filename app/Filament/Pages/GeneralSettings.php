<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Settings\GeneralSettings as GeneralSettingsStore;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class GeneralSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected string $view = 'filament.pages.general-settings';

    protected static ?string $navigationLabel = 'General Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'General Settings';

    public function mount(GeneralSettingsStore $settings): void
    {
        $siteSetting = SiteSetting::query()->firstOrCreate();

        $this->form->fill([
            'site_name' => $settings->site_name,
            'site_description' => $settings->site_description,
            'logo_small_file' => null,
            'logo_small_url' => $siteSetting->getFirstMediaUrl('site_logo_small', 'optimized') ?: ($siteSetting->getFirstMediaUrl('site_logo_small') ?: $settings->logo_small_url),
            'logo_large_file' => null,
            'logo_large_url' => $siteSetting->getFirstMediaUrl('site_logo_large', 'optimized') ?: ($siteSetting->getFirstMediaUrl('site_logo_large') ?: $settings->logo_large_url),
            'facebook_url' => $settings->facebook_url,
            'instagram_url' => $settings->instagram_url,
            'x_url' => $settings->x_url,
            'default_meta_title' => $settings->default_meta_title,
            'default_meta_description' => $settings->default_meta_description,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->schema([
                Section::make('General')
                    ->schema([
                        TextInput::make('site_name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('site_description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Branding / Logos')
                    ->description('Setiap logo memiliki peruntukan berbeda di tata letak halaman.')
                    ->schema([
                        Section::make('Small Logo')
                            ->description('Digunakan pada baris navigasi (sticky bar). Ukuran kecil/simpel.')
                            ->schema([
                                FileUpload::make('logo_small_file')
                                    ->label('Upload Small Logo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('tmp/site-settings'),
                                Placeholder::make('current_logo_small')
                                    ->label('Current Small Logo')
                                    ->content(fn ($get) => $get('logo_small_url') ? new HtmlString("<img src='{$get('logo_small_url')}' class='h-12 w-auto bg-white p-1 shadow-sm rounded border' />") : 'No logo uploaded'),
                            ])->columnSpan(1),

                        Section::make('Large Logo')
                            ->description('Digunakan pada masthead atas (tengah). Biasanya berisi teks brand.')
                            ->schema([
                                FileUpload::make('logo_large_file')
                                    ->label('Upload Large Logo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('tmp/site-settings'),
                                Placeholder::make('current_logo_large')
                                    ->label('Current Large Logo')
                                    ->content(fn ($get) => $get('logo_large_url') ? new HtmlString("<img src='{$get('logo_large_url')}' class='h-12 w-auto bg-white p-1 shadow-sm rounded border' />") : 'No logo uploaded'),
                            ])->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Social Media')
                    ->schema([
                        TextInput::make('facebook_url')->url()->maxLength(255),
                        TextInput::make('instagram_url')->url()->maxLength(255),
                        TextInput::make('x_url')->label('X / Twitter URL')->url()->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Default SEO')
                    ->schema([
                        TextInput::make('default_meta_title')
                            ->maxLength(255),
                        Textarea::make('default_meta_description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action('save'),
        ];
    }

    public function save(GeneralSettingsStore $settings): void
    {
        $state = $this->form->getState();
        $siteSetting = SiteSetting::query()->firstOrCreate();

        // Handle Small Logo
        if (! empty($state['logo_small_file']) && Storage::disk('public')->exists($state['logo_small_file'])) {
            $siteSetting
                ->addMediaFromDisk($state['logo_small_file'], 'public')
                ->toMediaCollection('site_logo_small');

            Storage::disk('public')->delete($state['logo_small_file']);
        }

        // Handle Large Logo
        if (! empty($state['logo_large_file']) && Storage::disk('public')->exists($state['logo_large_file'])) {
            $siteSetting
                ->addMediaFromDisk($state['logo_large_file'], 'public')
                ->toMediaCollection('site_logo_large');

            Storage::disk('public')->delete($state['logo_large_file']);
        }

        // Update Settings
        $settings->site_name = $state['site_name'];
        $settings->site_description = $state['site_description'];
        $settings->logo_small_url = $siteSetting->getFirstMediaUrl('site_logo_small', 'optimized') ?: ($siteSetting->getFirstMediaUrl('site_logo_small') ?: null);
        $settings->logo_large_url = $siteSetting->getFirstMediaUrl('site_logo_large', 'optimized') ?: ($siteSetting->getFirstMediaUrl('site_logo_large') ?: null);
        $settings->facebook_url = $state['facebook_url'] ?? null;
        $settings->instagram_url = $state['instagram_url'] ?? null;
        $settings->x_url = $state['x_url'] ?? null;
        $settings->default_meta_title = $state['default_meta_title'] ?? null;
        $settings->default_meta_description = $state['default_meta_description'] ?? null;
        $settings->save();

        // Refresh form state
        $this->data['logo_small_url'] = $settings->logo_small_url;
        $this->data['logo_small_file'] = null;
        $this->data['logo_large_url'] = $settings->logo_large_url;
        $this->data['logo_large_file'] = null;

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
