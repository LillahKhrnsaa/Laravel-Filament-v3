<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Posts;
use Carbon\Carbon;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Publish scheduled posts when publish_at time is reached';

    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d H:i'); // format sama dengan input

        Posts::where('is_published', false)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', $now)
            ->update(['is_published' => true]);

        $this->info('Scheduled posts published successfully.');
    }
}

