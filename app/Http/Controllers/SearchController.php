<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('q', '');

        $articles = Article::with('category', 'user')
            ->published()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', '%' . $keyword . '%')
                      ->orWhere('content', 'like', '%' . $keyword . '%');
                });
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('public.search', compact('articles', 'keyword'));
    }
}
