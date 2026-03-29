<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $latestArticles = Article::with('category', 'user')
            ->published()
            ->latest('published_at')
            ->paginate(10);

        $featuredArticles = Article::with('category')
            ->published()
            ->latest('published_at')
            ->take(4)
            ->get();

        $categories = Category::withCount(['articles' => fn($q) => $q->published()])
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->take(8)
            ->get();

        return view('public.home', compact('latestArticles', 'featuredArticles', 'categories'));
    }
}
