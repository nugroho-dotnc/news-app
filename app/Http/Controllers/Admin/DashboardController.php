<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles'   => Article::count(),
            'published'        => Article::where('status', 'published')->count(),
            'drafts'           => Article::where('status', 'draft')->count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'total_categories' => Category::count(),
            'total_users'      => User::count(),
        ];

        $recentArticles = Article::with('user', 'category')
            ->latest('created_at')
            ->take(5)
            ->get();

        $pendingComments = Comment::with('article')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'pendingComments'));
    }
}
