<?php

namespace App\Http\Controllers;

use App\Models\Category;

class PublicCategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->articles()
            ->with('user')
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('public.category', compact('category', 'articles'));
    }
}
