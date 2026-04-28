<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    /**
     * After the record is created, move the uploaded cover image
     * from the tmp disk into Spatie Media Library.
     */
    protected function afterCreate(): void
    {
        $this->attachCoverImage($this->record);
    }

    private function attachCoverImage(\App\Models\Post $post): void
    {
        $value = $this->data['cover_image'] ?? null;

        // FileUpload returns an array of paths even for a single file
        $path = is_array($value) ? (array_values($value)[0] ?? null) : $value;

        if ($path && Storage::disk('public')->exists($path)) {
            $post->addMediaFromDisk($path, 'public')
                ->toMediaCollection('post_covers');

            Storage::disk('public')->delete($path);
        }
    }
}
