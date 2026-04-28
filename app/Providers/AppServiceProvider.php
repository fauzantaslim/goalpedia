<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
use App\Settings\GeneralSettings;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings and categories to all views globally
        View::share('settings', app(GeneralSettings::class));

        $cachedCategories = Cache::rememberForever('categories.global_nav', function () {
            return Category::query()->where('is_visible', true)->orderBy('name')->get()->toArray();
        });
        View::share('categories', Category::hydrate($cachedCategories));

        Category::observe(CategoryObserver::class);
        Post::observe(PostObserver::class);

        $this->backupGoogleDrive();
    }

    private function backupGoogleDrive()
    {
        try {
            \Storage::extend('google', function ($app, $config) {
                $options = [];

                if (! empty($config['folderId'] ?? null)) {
                    $options['folderId'] = $config['folderId'];
                }

                $client = new Client;
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);

                $service = new Drive($client);
                $adapter = new GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new Filesystem($adapter);

                return new FilesystemAdapter($driver, $adapter);
            });
        } catch (\Exception $e) {
            // your exception handling logic
            \Log::error($e->getMessage());
        }
    }
}
