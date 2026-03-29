@extends('layouts.admin')
@section('title', 'Manajemen Artikel')
@section('content')

<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-file-alt text-red-500 mr-2"></i>Daftar Artikel
        </h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola semua artikel yang ada di sistem</p>
    </div>
    <a href="{{ route('admin.articles.create') }}"
        class="flex items-center gap-2 bg-gray-900 text-white px-4 py-2.5 rounded hover:bg-red-700 transition text-sm font-semibold">
        <i class="fas fa-plus"></i> Buat Artikel
    </a>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-lg shadow-sm p-4 mb-5">
    <form method="GET" class="flex gap-3 flex-wrap items-center">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..."
                class="pl-9 pr-4 py-2 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400 w-64">
        </div>
        <div class="relative">
            <i class="fas fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <select name="status" class="pl-9 pr-4 py-2 border border-gray-200 rounded text-sm focus:outline-none focus:border-red-400 appearance-none">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <button type="submit" class="flex items-center gap-2 bg-gray-800 text-white px-4 py-2 rounded text-sm hover:bg-gray-900 transition">
            <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-500 hover:text-gray-700 border border-gray-200 rounded hover:border-gray-300 transition">
            <i class="fas fa-rotate-left"></i> Reset
        </a>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100 admin-table">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Judul</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Penulis</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-50">
            @forelse($articles as $article)
            <tr class="{{ $article->trashed() ? 'bg-red-50 opacity-70' : '' }}">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" alt=""
                                class="w-10 h-10 object-cover rounded flex-shrink-0">
                        @else
                            <div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-newspaper text-gray-400 text-sm"></i>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-800 max-w-xs line-clamp-1">{{ $article->title }}</p>
                            @if($article->trashed())
                                <span class="text-xs text-red-500 font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Terhapus
                                </span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <span class="text-sm text-gray-600">
                        <i class="fas fa-folder text-gray-400 mr-1"></i>{{ $article->category->name }}
                    </span>
                </td>
                <td class="px-4 py-4">
                    <span class="text-sm text-gray-600">{{ $article->user->name }}</span>
                </td>
                <td class="px-4 py-4">
                    <span class="px-2.5 py-1 text-xs rounded-full font-semibold
                        {{ $article->status === 'published' ? 'badge-published' : 'badge-draft' }}">
                        @if($article->status === 'published')
                            <i class="fas fa-check-circle mr-1"></i>Published
                        @else
                            <i class="fas fa-edit mr-1"></i>Draft
                        @endif
                    </span>
                </td>
                <td class="px-4 py-4 text-sm text-gray-400">
                    {{ optional($article->published_at ?? $article->created_at)->format('d M Y') }}
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center justify-end gap-2 flex-wrap">
                        @if(!$article->trashed())
                            {{-- View --}}
                            <a href="{{ route('article.show', $article->slug) }}" target="_blank"
                               class="text-xs text-gray-500 hover:text-gray-700 border border-gray-200 px-2 py-1 rounded transition" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            {{-- Toggle Status --}}
                            <form method="POST" action="{{ route('admin.articles.toggleStatus', $article) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="text-xs {{ $article->status === 'published' ? 'text-yellow-600 hover:text-yellow-800 border-yellow-200' : 'text-green-600 hover:text-green-800 border-green-200' }} border px-2 py-1 rounded transition"
                                    title="{{ $article->status === 'published' ? 'Jadikan Draft' : 'Publish' }}">
                                    <i class="fas {{ $article->status === 'published' ? 'fa-eye-slash' : 'fa-check' }}"></i>
                                </button>
                            </form>
                            {{-- Edit --}}
                            <a href="{{ route('admin.articles.edit', $article) }}"
                               class="text-xs text-blue-600 hover:text-blue-800 border border-blue-200 px-2 py-1 rounded transition" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            {{-- Delete --}}
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}"
                                onsubmit="return confirm('Pindahkan artikel ini ke tempat sampah?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-red-600 hover:text-red-800 border border-red-200 px-2 py-1 rounded transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @else
                            {{-- Restore --}}
                            <form method="POST" action="{{ route('admin.articles.restore', $article->id) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="text-xs text-green-600 hover:text-green-800 border border-green-200 px-2 py-1 rounded transition" title="Pulihkan">
                                    <i class="fas fa-undo"></i> Pulihkan
                                </button>
                            </form>
                            {{-- Force Delete --}}
                            <form method="POST" action="{{ route('admin.articles.forceDelete', $article->id) }}"
                                onsubmit="return confirm('Hapus permanen? Tindakan ini tidak dapat dibatalkan!')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-red-800 hover:text-red-900 border border-red-300 px-2 py-1 rounded transition font-bold" title="Hapus Permanen">
                                    <i class="fas fa-skull"></i> Hapus Permanen
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-file-alt text-5xl mb-3"></i>
                    <p class="text-sm">Belum ada artikel yang ditemukan.</p>
                    <a href="{{ route('admin.articles.create') }}" class="mt-2 inline-block text-red-600 hover:underline text-sm">
                        <i class="fas fa-plus mr-1"></i>Buat artikel pertama
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-5">{{ $articles->appends(request()->query())->links() }}</div>

@endsection
