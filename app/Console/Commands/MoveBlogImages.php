<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MoveBlogImages extends Command
{
    protected $signature = 'blog:migrate-images';
    protected $description = 'Move blog images from public/images into storage/app/public/blog-images';

    public function handle(): int
    {
        $blogs = Blog::whereNotNull('image')->get();

        if ($blogs->isEmpty()) {
            $this->info('No blog records with images found.');
            return self::SUCCESS;
        }

        $moved = 0;
        $missing = 0;

        foreach ($blogs as $blog) {
            $filename = $blog->image;
            $source = public_path('images/' . $filename);
            $destination = 'blog-images/' . $filename;

            // Already moved to storage
            if (Storage::disk('public')->exists($destination)) {
                continue;
            }

            if (!file_exists($source)) {
                $this->warn("Source not found, skipping: {$filename}");
                $missing++;
                continue;
            }

            Storage::disk('public')->put(
                $destination,
                file_get_contents($source)
            );

            unlink($source);
            $moved++;
            $this->line("Moved: {$filename}");
        }

        $this->info("Done. Moved: {$moved}, Missing: {$missing}.");
        return self::SUCCESS;
    }
}
