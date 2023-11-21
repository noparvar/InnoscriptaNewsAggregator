<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TheGuardianService extends ApiServiceAbstract implements ApiServiceInterface
{

    private Client $httpClient;
    private string $apiKey;

    public function __construct()
    {

        // Retrieve The Guardian API key from the environment
        $this->apiKey = env('THEGUARDIAN_API_KEY');

        // Initialize Guzzle HTTP client with the base URI from the environment
        $this->httpClient = new Client([
            'base_uri' => env('THEGUARDIAN_URL')
        ]);
    }

    public function getName(): string
    {
        // Get the name of the service (The Guardian)
        return 'TheGuardian';
    }

    /**
     * Fetch data from The Guardian API.
     *
     * @throws GuzzleException
     *
     * @return array Fetched data from The Guardian API.
     */
    protected function fetchDataFromApi(): array
    {
        try {
            // Make a GET request to The Guardian API
            $response = $this->httpClient->get('search', [
                'query' => [
                    'api-key' => $this->apiKey,
                    'type' => 'article'
                ]
            ]);

            // Parse the JSON response
            $data = json_decode($response->getBody(), true);

            // Extract the relevant data from the response
            return $data['response']['results'] ?? [];

        } catch (GuzzleException $exception) {
            // Log the exception and rethrow it for higher-level handling
            Log::error('The Guardian Exception: ' . $exception->getMessage());

            // Handle the exception (e.g., rethrow it for higher-level handling)
            throw $exception;
        }
    }

    /**
     * Process and standardize raw data from The Guardian API.
     *
     * @param array $rawData Raw data from The Guardian API.
     *
     * @return array Standardized data.
     */
    protected function processAndStandardizeData(array $rawData) : array
    {
        // Implementation to process and standardize data
        $standardizedData = [];

        foreach ($rawData as $article) {
            $standardizedData[] = array(
                'title'    => htmlspecialchars($article['webTitle']), // Sanitize title by encoding special characters to prevent XSS vulnerabilities
                'category' => $article['sectionName'],
                'source'   => $this->getName(),
            );
        }

        return $standardizedData;

    }
}
