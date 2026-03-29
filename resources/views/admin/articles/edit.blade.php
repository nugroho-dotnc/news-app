@extends('layouts.admin')
@section('title', 'Edit Artikel')
@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.articles.index') }}" class="text-gray-400 hover:text-gray-600">
        <i class="fas fa-arrow-left text-lg"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-pencil-alt text-red-500 mr-2"></i>Edit Artikel
        </h2>
        <p class="text-sm text-gray-400">Perbarui informasi artikel</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <!-- Title -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading text-gray-400 mr-1"></i>Judul Artikel <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $article->title) }}" required
                        class="w-full px-4 py-3 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 transition text-gray-800 font-medium text-lg">
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-gray-400 mr-1"></i>Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" rows="20" required
                        class="w-full px-4 py-3 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 transition resize-y text-gray-700 leading-relaxed">{{ old('content', $article->content) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-5">

            {{-- Publish Box --}}
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-paper-plane text-red-500"></i>Publikasi
                </h3>
                <p class="text-xs text-gray-400 mb-3">
                    <i class="fas fa-link mr-1"></i>Slug: <code class="bg-gray-100 px-1.5 py-0.5 rounded text-gray-600">{{ $article->slug }}</code>
                </p>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400">
                        <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>
                            📝 Draft
                        </option>
                        <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>
                            ✅ Published
                        </option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 bg-gray-900 text-white py-2.5 rounded text-sm hover:bg-red-700 transition font-semibold">
                        <i class="fas fa-save"></i> Perbarui
                    </button>
                    <a href="{{ route('admin.articles.index') }}"
                       class="flex-1 text-center py-2.5 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('article.show', $article->slug) }}" target="_blank"
                       class="text-xs text-gray-500 hover:text-red-600 transition flex items-center gap-1">
                        <i class="fas fa-external-link-alt"></i>Lihat artikel di website
                    </a>
                </div>
            </div>

            {{-- Category --}}
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-folder text-blue-500"></i>Kategori <span class="text-red-500">*</span>
                </h3>
                <select name="category_id" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tags --}}
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-tags text-yellow-500"></i>Tag
                </h3>
                @php $selectedTags = old('tags', $article->tags->pluck('id')->toArray()); @endphp
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-1.5 text-xs text-gray-600 cursor-pointer hover:text-gray-800 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded transition">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-red-500 focus:ring-red-400">
                            #{{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Thumbnail --}}
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-image text-green-500"></i>Thumbnail
                </h3>
                @if($article->thumbnail)
                    <div class="mb-3 relative">
                        <img src="{{ Storage::url($article->thumbnail) }}" alt="Thumbnail"
                            class="w-full h-32 object-cover rounded border border-gray-200">
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-0.5 rounded">
                            <i class="fas fa-check mr-1"></i>Ada
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mb-3">Upload file baru untuk mengganti thumbnail saat ini</p>
                @else
                    <div class="text-center py-4 mb-3 border-2 border-dashed border-gray-200 rounded">
                        <i class="fas fa-image text-3xl text-gray-300 mb-1"></i>
                        <p class="text-xs text-gray-400">Belum ada thumbnail</p>
                    </div>
                @endif
                <input type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp"
                    class="w-full text-xs text-gray-500 file:mr-2 file:text-red-600 file:border-0 file:bg-red-50 file:hover:bg-red-100 file:px-3 file:py-1.5 file:rounded file:text-xs file:cursor-pointer file:font-semibold">
                <p class="text-xs text-gray-400 mt-2">JPG, PNG, WebP — Maks. 2MB</p>
            </div>

        </div>
    </div>
</form>
@endsection
