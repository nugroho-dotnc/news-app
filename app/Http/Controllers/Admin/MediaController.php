<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::with('article')->latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file'       => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'article_id' => ['nullable', 'exists:articles,id'],
        ]);

        $path = $request->file('file')->store('media', 'public');

        $media = Media::create([
            'path'       => $path,
            'type'       => 'image',
            'article_id' => $request->article_id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'url'     => Storage::disk('public')->url($path),
                'id'      => $media->id,
            ]);
        }

        return back()->with('success', 'Media berhasil diupload.');
    }

    public function destroy(Media $media)
    {
        Storage::disk('public')->delete($media->path);
        $media->delete();

        return back()->with('success', 'Media berhasil dihapus.');
    }
}
