<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

class StatsController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'total_books' => Book::count(),
            'total_authors' => Author::count(),
            'total_categories' => Category::count(),
            'low_stock_books' => Book::where('stock', '<', 5)->count(),
        ]);
    }
}