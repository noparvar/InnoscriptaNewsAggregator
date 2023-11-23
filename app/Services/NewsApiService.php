<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use jcobhams\NewsApi\NewsApi;
use jcobhams\NewsApi\NewsApiException;

class NewsApiService extends ApiServiceAbstract implements ApiServiceInterface
{

    private string $apiKey;
    public function __construct()
    {
        $newsServices = Config::get('services.news_services');

        // Retrieve The NewsApi API key from the environment
        $this->apiKey = $newsServices[$this->getName()]['api_key'];
    }

    public function getName(): string
    {
        return 'NewsApi';
    }

    /**
     * Fetch data from the NewsAPI.
     *
     * @throws NewsApiException
     *
     * @return object Fetched data from the NewsAPI.
     */
    protected function fetchDataFromApi() : object
    {
        // Implementation to fetch data from NewsAPI

        try {

            // Create a new instance of the NewsAPI client
            $newsApi = new NewsApi($this->apiKey);

            // Make a request to get the top headlines
            return $newsApi->getTopHeadLines(null, null, 'us', null, 10, 1);

        } catch (NewsApiException $exception) {

            // Log the exception and rethrow it for higher-level handling
            Log::error('NewsAPI Exception: ' . $exception->getMessage());

            // Handle the exception (e.g., rethrow it for higher-level handling)
            throw $exception;
        }
    }

    /**
     * Process and standardize raw data from the NewsAPI.
     *
     * @param object $rawData Raw data from the NewsAPI.
     *
     * @return array Standardized data.
     */
    protected function processAndStandardizeData($rawData) : array
    {
        // Implementation to process and standardize data
        $standardizedData = [];

        foreach ($rawData->articles as $article) {

            // Parse the raw publish date with Carbon
            $carbonDate = Carbon::parse($article->publishedAt);

            $standardizedData[] = array(
                'title'        => htmlspecialchars($article->title), // Sanitize title by encoding special characters to prevent XSS vulnerabilities
                'content'      => strip_tags($article->content), // Sanitize content by removing any potentially harmful HTML tags
                'author'       => $article->author,
                'source'       => $this->getName(),
                'publish_date' => $carbonDate->toDateString(),
                'publish_time' => $carbonDate->toTimeString(),
            );
        }

        return $standardizedData;
    }
}
