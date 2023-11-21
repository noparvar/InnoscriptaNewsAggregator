<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ArticleResource;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ArticleController
 * @package App\Http\Controllers\Api\V1
 */
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        // Retrieve the last 10 articles with pagination
        $articles = Article::latest()->paginate(10);

        return ArticleResource::collection($articles);

    }
    /**
     * Search and filter articles based on user input.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        // Implement search and filter logic based on user input
        $query = $request->input('query');
        $date = $request->input('date');
        $category = $request->input('category');
        $source = $request->input('source');

        $convertedDate = Carbon::parse($date)->format('Y-m-d');

        // Use Eloquent queries and Scout for search
        $articles = Article::search($query)
            ->when($date, function ($query) use ($convertedDate) {
                return $query->where('publish_date', $convertedDate);
            })
            ->when($category, function ($query) use ($category) {
                return $query->where('category', $category);
            })
            ->when($source, function ($query) use ($source) {
                return $query->where('source', $source);
            })
            ->paginate(10);

        return ArticleResource::collection($articles);

    }

}
