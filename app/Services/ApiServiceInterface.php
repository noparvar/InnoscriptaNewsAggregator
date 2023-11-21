<?php

namespace App\Services;

interface ApiServiceInterface
{
    /**
     * Fetch and process data from the API.
     *
     * @return array An array of associative arrays with specific keys:
     *     - 'title'        : The title of the article.
     *     - 'content'      : The content/body of the article.
     *     - 'author'       : The author of the article.
     *     - 'source'       : The source of the article.
     *     - 'category'     : The category of the article.
     *     - 'publish_date' : The publishing date of the article.
     *     - 'publish_time' : The publishing time of the article.
     */
    public function fetchAndProcessData(): array;
}
