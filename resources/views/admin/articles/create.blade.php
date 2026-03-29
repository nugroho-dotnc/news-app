@extends('layouts.admin')
@section('title', 'Buat Artikel Baru')
@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.articles.index') }}" class="text-gray-400 hover:text-gray-600">
        <i class="fas fa-arrow-left text-lg"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-plus-circle text-red-500 mr-2"></i>Buat Artikel Baru
        </h2>
        <p class="text-sm text-gray-400">Isi semua field yang diperlukan untuk mempublikasikan artikel</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <!-- Title -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading text-gray-400 mr-1"></i>Judul Artikel <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        placeholder="Masukkan judul artikel yang menarik..."
                        class="w-full px-4 py-3 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 transition text-gray-800 font-medium text-lg">
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-gray-400 mr-1"></i>Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" rows="20" required
                        placeholder="Tulis konten artikel di sini..."
                        class="w-full px-4 py-3 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 transition resize-y text-gray-700 leading-relaxed">{{ old('content') }}</textarea>
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
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                            📝 Draft
                        </option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                            ✅ Published
                        </option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 bg-gray-900 text-white py-2.5 rounded text-sm hover:bg-red-700 transition font-semibold">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.articles.index') }}"
                       class="flex-1 text-center py-2.5 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200 transition">
                        Batal
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
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tags --}}
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-tags text-yellow-500"></i>Tag <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-1.5 text-sm text-gray-600 cursor-pointer hover:text-gray-800 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded transition">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-red-500 focus:ring-red-400">
                            <span class="text-xs">#{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Thumbnail --}}
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-image text-green-500"></i>Thumbnail
                </h3>
                <div class="border-2 border-dashed border-gray-200 rounded p-4 text-center hover:border-red-300 transition">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400 mb-3">JPG, PNG, WebP — Maks. 2MB</p>
                    <input type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp"
                        class="w-full text-xs text-gray-500 file:mr-2 file:text-red-600 file:border-0 file:bg-red-50 file:hover:bg-red-100 file:px-3 file:py-1.5 file:rounded file:text-xs file:cursor-pointer file:font-semibold">
                </div>
            </div>

        </div>
    </div>
</form>
@endsection
