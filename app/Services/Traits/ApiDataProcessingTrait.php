<?php

namespace App\Services\Traits;

use GuzzleHttp\Exception\GuzzleException;
use jcobhams\NewsApi\NewsApiException;

trait ApiDataProcessingTrait
{
    /**
     * Fetch and process data from the API.
     *
     * @return array An array of arrays with specific keys.
     * @throws NewsApiException
     * @throws GuzzleException
     */
    public function fetchAndProcessData(): array
    {
        // Implementation to fetch and standardize data
        $rawData = $this->fetchDataFromApi();
        $standardizedData = $this->processAndStandardizeData($rawData);

        // Ensure each item in the array has specific keys
        return array_map(function ($item) {
            return [
                'title'    => $item['title'] ?? '',
                'content'  => $item['content'] ?? null,
                'author'   => $item['author'] ?? null,
                'source'   => $item['source'] ?? null,
                'category' => $item['category'] ?? null,
            ];
        }, $standardizedData);
    }

    abstract public function getName(): string;

    /**
     * Fetch data from the API.
     *
     * @return array|object Raw data from the API.
     */
    abstract protected function fetchDataFromApi(): array | object;

    /**
     * Process and standardize data.
     *
     * @param array $rawData Raw data from the API.
     *
     * @return array Standardized data.
     */
    abstract protected function processAndStandardizeData(array $rawData): array;
}
