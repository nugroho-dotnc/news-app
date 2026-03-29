<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('articles')->orderBy('name')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:tags,name'],
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => $this->generateSlug($request->name),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil ditambahkan.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:tags,name,' . $tag->id],
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => $this->generateSlug($request->name, $tag->id),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroy(Tag $tag)
    {
        $tag->articles()->detach();
        $tag->delete();
        return back()->with('success', 'Tag berhasil dihapus.');
    }

    private function generateSlug(string $name, ?int $exceptId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;
        while (Tag::where('slug', $slug)->where('id', '!=', $exceptId)->exists()) {
            $slug = $original . '-' . $count++;
        }
        return $slug;
    }
}
