<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Illuminate\Console\Command;

class CleanBlogContent extends Command
{
    protected $signature = 'blog:clean-content';
    protected $description = 'Replace literal \\r\\n escape sequences in blog content with real newlines';

    public function handle(): int
    {
        $blogs = Blog::all();
        $fixed = 0;

        foreach ($blogs as $blog) {
            $cleaned = str_replace(['\r\n', '\r'], "\n", $blog->content);

            if ($cleaned !== $blog->content) {
                $blog->update(['content' => $cleaned]);
                $fixed++;
                $this->line("Fixed: [{$blog->id}] {$blog->title}");
            }
        }

        $this->info("Done. Fixed {$fixed} blog post(s).");
        return self::SUCCESS;
    }
}
