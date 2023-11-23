<?php

namespace Tests\Feature;

use App\Jobs\FetchArticlesJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class FetchArticlesCommandTest extends TestCase
{
    /** @test */
    public function it_dispatches_jobs_for_each_news_service()
    {
        // Mock the configuration for news services
        Config::set('services.news_services', [
            'TheGuardian' => ['class' => 'App\Services\TheGuardianService', 'api_key' => 'your_api_key', 'api_url' => 'https://content.guardianapis.com/search'],
            // We can add other news services as needed
        ]);

        // Mock the queue facade
        Queue::fake();

        // Run the command
        Artisan::call('articles:fetch');

        // Assert that jobs were dispatched for each news service
        Queue::assertPushedOn('fetch-TheGuardian-articles', FetchArticlesJob::class);
        // We can add assertions for other news services if needed
    }
}
