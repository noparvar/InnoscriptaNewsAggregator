<?php

namespace App\Console\Commands;

use App\Jobs\FetchArticlesJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update articles from the selected data source';

    protected Array $newsServices;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the list of news services from the configuration
        $newsServices = Config::get('services.news_services');

        // Display an informational message
        $this->info('Initiating the process to fetch and update articles...');

        foreach ($newsServices as $serviceName => $serviceClass) {
            // Display a message for each news service being processed
            $this->info("Adding {$serviceName} to Queues");

            // Dispatch a job for each news service
            FetchArticlesJob::dispatch($serviceClass)
                ->onQueue('fetch-' . $serviceName . '-articles'); // We can customize the queue name if needed
        }

        // Display a success message
        $this->info('Articles fetching jobs successfully dispatched!');

    }
}
