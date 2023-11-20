<?php

namespace App\Services;

use App\Services\Traits\ApiDataProcessingTrait;
use jcobhams\NewsApi\NewsApi;
use jcobhams\NewsApi\NewsApiException;
use Illuminate\Support\Facades\Log;

class NewsApiService implements ApiServiceInterface
{
    use ApiDataProcessingTrait;

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
    private function fetchDataFromApi() : object
    {
        // Implementation to fetch data from NewsAPI

        try {

            // Create a new instance of the NewsAPI client
            $newsApi = new NewsApi(env('NEWSAPI_API_KEY'));

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
    private function processAndStandardizeData($rawData) : array
    {
        // Implementation to process and standardize data
        $standardizedData = [];

        foreach ($rawData->articles as $article) {
            $standardizedData[] = array(
                'title'    => htmlspecialchars($article->title), // Sanitize title by encoding special characters to prevent XSS vulnerabilities
                'content'  => strip_tags($article->content), // Sanitize content by removing any potentially harmful HTML tags
                'author'   => $article->author,
                'source'   => $this->getName(),
            );
        }

        return $standardizedData;
    }
}
