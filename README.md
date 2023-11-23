# Innoscripta News Aggregator

This Laravel-based application serves as a news aggregator, fetching and storing articles from various sources and providing API endpoints for retrieving and searching articles.

## Features

- **Data Aggregation and Storage:** Regularly fetches articles from selected data sources and stores them locally in a database.

- **API Endpoints:** Provides API endpoints for the frontend application to interact with the backend. Endpoints include fetching articles, searching with filtering criteria, and user preferences.

- **Integration with Scout and Eloquent API Resources:** Uses Laravel Scout for full-text searching and Eloquent API Resources to transform data into a structured JSON response.

- **Queue-based Article Fetching:** Fetches articles in the background using Laravel Jobs and queues, ensuring efficient handling of data retrieval tasks.

- **Feature Test:** Includes feature test to ensure the functionality of the application.

## Technologies Used

- Laravel
- Laravel Scout
- Laravel Eloquent
- Laravel Jobs and Queues
- PHPUnit for Testing

## Setup

1. Clone the repository.
2. Run `composer update` to install dependencies.
3. Set up your database configuration in the `.env` file.
4. Run migrations: `php artisan migrate`.
5. Set up your preferred queue driver in the `.env` file.
6. Configure your preferred data sources in `config/services.php`.
7. Set up API keys and URLs for each data source in the `.env` file.
8. Fetch articles with `php artisan fetch:articles`.
9. Explore the API endpoints for article retrieval and search.

## API Endpoints

### 1. Fetch Last 10 Articles

```http
GET /api/v1/articles
```

### 2. Search and Filter Articles

```http
GET /api/v1/articles/search?query={search_term}&date={yyyy-mm-dd}&category={category}&source={source}

```


## Running Tests

```
php artisan test
```
