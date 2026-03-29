<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('user', 'category')->withTrashed();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $articles = $query->latest('created_at')->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tags'        => ['nullable', 'array'],
            'tags.*'      => ['exists:tags,id'],
        ]);

        $data = $request->only(['title', 'content', 'category_id', 'status']);
        $data['slug']    = $this->generateSlug($request->title);
        $data['user_id'] = Auth::id();

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article = Article::create($data);
        $article->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function show(Article $article)
    {
        $article->load('category', 'tags', 'user', 'comments');
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tags'        => ['nullable', 'array'],
            'tags.*'      => ['exists:tags,id'],
        ]);

        $data = $request->only(['title', 'content', 'category_id', 'status']);

        // Set published_at when first published
        if ($request->status === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update($data);
        $article->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete(); // Soft delete
        return back()->with('success', 'Artikel dipindahkan ke tempat sampah.');
    }

    public function restore(int $id)
    {
        Article::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Artikel berhasil dipulihkan.');
    }

    public function forceDelete(int $id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->forceDelete();
        return back()->with('success', 'Artikel dihapus permanen.');
    }

    public function toggleStatus(Article $article)
    {
        if ($article->status === 'published') {
            $article->update(['status' => 'draft']);
            $message = 'Artikel dikembalikan ke draft.';
        } else {
            $article->update([
                'status'       => 'published',
                'published_at' => $article->published_at ?? now(),
            ]);
            $message = 'Artikel dipublikasikan.';
        }
        return back()->with('success', $message);
    }

    private function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;
        while (Article::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }
        return $slug;
    }
}
