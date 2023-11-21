<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FetchArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $serviceClass;

    /**
     * Create a new job instance.
     *
     * @param string $serviceClass
     */
    public function __construct(string $serviceClass)
    {
        $this->serviceClass = $serviceClass;
    }

    /**
     * Execute the job.
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $serviceInstance = app()->make($this->serviceClass);

        try {
            // Fetch and process articles using the specified service
            $articles = $serviceInstance->fetchAndProcessData();

            foreach ($articles as $article) {
                // Check if an article with the same title was created within the last 24 hours
                $existingArticle = Article::where('title', $article['title'])
                    ->where('created_at', '>', Carbon::now()->subDay()) // Check if created within the last 24 hours
                    ->first();

                if ($existingArticle) {
                    // If the article with the same title created within the last 24 hours exists, update it
                    $existingArticle->update($article);
                } else {
                    // If no recent article with the same title exists, create a new one
                    Article::create($article);
                }
            }


        } catch (\Exception $exception) {
            // Log any exceptions that occur during the fetching or creating process
            Log::error("Error fetching or creating articles from {$this->serviceClass}: " . $exception->getMessage());
        }
    }
}
