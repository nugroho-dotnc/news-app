@extends('layouts.admin')
@section('title', 'Manajemen Media')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-images text-red-500 mr-2"></i>Media Library
        </h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola gambar dan file media</p>
    </div>
    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
        class="flex items-center gap-2 bg-gray-900 text-white px-4 py-2.5 rounded hover:bg-red-700 transition text-sm font-semibold">
        <i class="fas fa-cloud-upload-alt"></i> Upload Gambar
    </button>
</div>

<!-- Media Grid -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
    @forelse($media as $item)
    <div class="relative group bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="relative overflow-hidden" style="padding-top: 75%;">
            <img src="{{ Storage::url($item->path) }}" alt="media"
                class="absolute inset-0 w-full h-full object-cover">
        </div>
        <!-- Overlay Actions -->
        <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
            <a href="{{ Storage::url($item->path) }}" target="_blank"
               class="bg-white text-gray-800 text-xs px-3 py-1.5 rounded font-semibold hover:bg-gray-100 transition">
                <i class="fas fa-eye mr-1"></i>Lihat
            </a>
            <form method="POST" action="{{ route('admin.media.destroy', $item) }}"
                onsubmit="return confirm('Hapus media ini?')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="bg-red-600 text-white text-xs px-3 py-1.5 rounded font-semibold hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-1"></i>Hapus
                </button>
            </form>
        </div>
        <!-- Filename -->
        <div class="p-2 border-t border-gray-50">
            <p class="text-xs text-gray-400 truncate" title="{{ basename($item->path) }}">
                {{ basename($item->path) }}
            </p>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 text-center text-gray-400">
        <i class="fas fa-images text-6xl mb-4"></i>
        <p class="text-lg mb-2">Belum ada media.</p>
        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
            class="mt-2 inline-flex items-center gap-2 text-red-600 hover:underline text-sm">
            <i class="fas fa-cloud-upload-alt"></i>Upload gambar pertama
        </button>
    </div>
    @endforelse
</div>

<div class="mt-5">{{ $media->links() }}</div>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-800">
                <i class="fas fa-cloud-upload-alt text-red-500 mr-2"></i>Upload Gambar
            </h3>
            <button onclick="document.getElementById('uploadModal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="border-2 border-dashed border-gray-200 hover:border-red-300 rounded-lg p-6 text-center transition-colors">
                <i class="fas fa-image text-4xl text-gray-300 mb-3"></i>
                <p class="text-sm text-gray-500 mb-3">JPG, PNG, WebP — Maks. 2MB</p>
                <input type="file" name="file" accept=".jpg,.jpeg,.png,.webp" required
                    class="w-full text-sm text-gray-500 file:mr-2 file:text-red-600 file:border-0 file:bg-red-50 file:hover:bg-red-100 file:px-3 file:py-1.5 file:rounded file:text-sm file:cursor-pointer file:font-semibold">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 flex items-center justify-center gap-2 bg-gray-900 text-white py-2.5 rounded hover:bg-red-700 transition text-sm font-semibold">
                    <i class="fas fa-cloud-upload-alt"></i>Upload
                </button>
                <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')"
                    class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded hover:bg-gray-200 transition text-sm">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
