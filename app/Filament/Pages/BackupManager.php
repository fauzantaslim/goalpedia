<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

class BackupManager extends Page
{
    protected string $view = 'filament.pages.backup-manager';

    protected static ?string $navigationLabel = 'Backups';

    protected static string|\UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Backups';

    public string $lastRunOutput = 'Belum ada backup yang dijalankan dari panel admin.';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('runDatabaseBackup')
                ->label('Backup Database')
                ->action(fn () => $this->runBackup(['--only-db' => true]))
                ->requiresConfirmation(),
            Action::make('runFullBackup')
                ->label('Backup Full Project')
                ->action(fn () => $this->runBackup([]))
                ->requiresConfirmation(),
        ];
    }

    private function runBackup(array $options): void
    {
        Artisan::call('backup:run', array_merge($options, ['--disable-notifications' => true]));

        $this->lastRunOutput = trim(Artisan::output()) ?: 'Backup selesai tanpa output tambahan.';

        Notification::make()
            ->title('Backup selesai dijalankan')
            ->success()
            ->send();
    }
}
