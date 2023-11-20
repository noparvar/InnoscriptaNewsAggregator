<?php

namespace App\Services;

use App\Services\Traits\ApiDataProcessingTrait;

class NewsApiService implements ApiServiceInterface
{
    use ApiDataProcessingTrait;

    private function fetchDataFromApi() : array
    {
        // Implementation to fetch data from NewsAPI
    }

    private function processAndStandardizeData($rawData) : array
    {
        // Implementation to process and standardize data
    }
}
