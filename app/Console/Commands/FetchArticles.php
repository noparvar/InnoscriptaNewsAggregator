<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Config;

class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update articles from the selected data source';

    protected Array $newsServices;

    /**
     * Execute the console command.
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $this->newsServices = Config::get('services.news_services');

        $this->info('Fetching and updating articles...');

        foreach ($this->newsServices as $key => $serviceClass) {
            // Instantiate the service and call the fetch method
            $serviceInstance = app()->make($serviceClass);
            $this->info("Fetching news from {$key}");

            $articles = $serviceInstance->fetchAndProcessData();

            $this->info(print_r($articles, true));
        }

        $this->info('Articles fetched and updated successfully!');
    }
}
