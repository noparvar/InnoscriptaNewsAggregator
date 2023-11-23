<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'news_services' => [

/*        'NewsApi' => [
            'class'   => App\Services\NewsApiService::class,
            'api_key' => env('NEWSAPI_API_KEY'),
            'api_url' => env('NEWSAPI_URL', 'https://newsapi.org/v2/'),
        ],
        'TheGuardian' => [
            'class'   => App\Services\TheGuardianService::class,
            'api_key' => env('THEGUARDIAN_API_KEY'),
            'api_url' => env('THEGUARDIAN_URL', 'https://content.guardianapis.com/search'),
        ],*/
        'NewYorkTimes' => [
            'class' => App\Services\NewYorkTimesService::class,
            'api_key' => env('NYTIMES_API_KEY'),
            'api_url' => env('NYTIMES_URL', 'https://api.nytimes.com'),
        ],

        // We can add more services as needed

    ],

];
