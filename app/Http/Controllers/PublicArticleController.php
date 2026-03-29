<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PublicArticleController extends Controller
{
    public function show(string $slug)
    {
        $article = Article::with('category', 'tags', 'user', 'approvedComments')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Related articles (same category)
        $related = Article::with('category')
            ->published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('public.article', compact('article', 'related'));
    }

    public function storeComment(Request $request, string $slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'body'  => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        $article->comments()->create([
            'name'   => $request->name,
            'email'  => $request->email,
            'body'   => $request->body,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Komentar Anda berhasil dikirim dan menunggu moderasi.');
    }
}
