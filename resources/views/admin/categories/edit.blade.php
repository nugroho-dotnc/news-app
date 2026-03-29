@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-gray-600">
        <i class="fas fa-arrow-left text-lg"></i>
    </a>
    <h2 class="text-xl font-bold text-gray-800">
        <i class="fas fa-folder-open text-red-500 mr-2"></i>Edit Kategori
    </h2>
</div>

<div class="max-w-lg">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-folder text-gray-400 mr-1"></i>Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 text-sm transition">
                <p class="text-xs text-gray-400 mt-1">
                    Slug saat ini: <code class="bg-gray-100 px-1.5 py-0.5 rounded text-gray-600">{{ $category->slug }}</code>
                </p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded hover:bg-red-700 transition text-sm font-semibold">
                    <i class="fas fa-save"></i> Perbarui
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-2 bg-gray-100 text-gray-700 px-5 py-2.5 rounded hover:bg-gray-200 transition text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
