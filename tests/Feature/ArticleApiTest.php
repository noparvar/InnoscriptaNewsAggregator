<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_can_get_articles()
    {
        // Act
        $response = $this->json('GET', 'api/v1/articles');

        // Assert
        $response->assertStatus(200);
    }

    public function test_can_get_articles_with_correct_structure()
    {
        // Act
        $response = $this->json('GET', '/api/v1/articles');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'response' => [
                    'status',
                    'total',
                    'pageSize',
                    'currentPage',
                    'pages',
                    'results' => [
                        '*' => [
                            'title',
                            'content',
                            'author',
                            'source',
                            'category',
                            'publish_date',
                            'publish_time',
                        ],
                    ],
                ],
            ]);
    }
}
