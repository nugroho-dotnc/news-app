@extends('layouts.admin')
@section('title', 'Manajemen Tag')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-tags text-red-500 mr-2"></i>Daftar Tag
        </h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola tag untuk artikel</p>
    </div>
    <a href="{{ route('admin.tags.create') }}"
        class="flex items-center gap-2 bg-gray-900 text-white px-4 py-2.5 rounded hover:bg-red-700 transition text-sm font-semibold">
        <i class="fas fa-plus"></i> Tambah Tag
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100 admin-table">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Artikel</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-50">
            @forelse($tags as $tag)
            <tr>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-2">
                        <span class="text-xs text-yellow-600 font-semibold bg-yellow-50 px-2 py-0.5 rounded">
                            <i class="fas fa-hashtag mr-0.5"></i>{{ $tag->name }}
                        </span>
                    </span>
                </td>
                <td class="px-6 py-4">
                    <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $tag->slug }}</code>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $tag->articles_count }} artikel</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.tags.edit', $tag) }}"
                           class="text-xs text-blue-600 hover:text-blue-800 border border-blue-200 px-2 py-1 rounded transition" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                              onsubmit="return confirm('Hapus tag ini?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="text-xs text-red-600 hover:text-red-800 border border-red-200 px-2 py-1 rounded transition" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-tags text-5xl mb-3"></i>
                    <p class="text-sm">Belum ada tag.</p>
                    <a href="{{ route('admin.tags.create') }}" class="mt-2 inline-block text-red-600 hover:underline text-sm">
                        <i class="fas fa-plus mr-1"></i>Tambah tag pertama
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-5">{{ $tags->links() }}</div>

@endsection
