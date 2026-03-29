@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<!-- ===== STAT CARDS ===== -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    <!-- Total Artikel -->
    <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500 flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-file-alt text-2xl text-red-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Total Artikel</p>
            <p class="text-3xl font-bold text-gray-800 mt-0.5">{{ $stats['total_articles'] }}</p>
            <p class="text-xs mt-1">
                <span class="text-green-600 font-medium">{{ $stats['published'] }} published</span>
                <span class="text-gray-300 mx-1">·</span>
                <span class="text-yellow-600 font-medium">{{ $stats['drafts'] }} draft</span>
            </p>
        </div>
    </div>

    <!-- Komentar Pending -->
    <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500 flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-yellow-50 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-comments text-2xl text-yellow-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Komentar Pending</p>
            <p class="text-3xl font-bold text-gray-800 mt-0.5">{{ $stats['pending_comments'] }}</p>
            <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="text-xs text-red-600 hover:underline">
                Moderasi sekarang <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Kategori -->
    <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500 flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-folder text-2xl text-blue-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Kategori</p>
            <p class="text-3xl font-bold text-gray-800 mt-0.5">{{ $stats['total_categories'] }}</p>
            <a href="{{ route('admin.categories.index') }}" class="text-xs text-red-600 hover:underline">
                Kelola kategori <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    @if(auth()->user()->isAdmin())
    <!-- Total Pengguna -->
    <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500 flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-purple-50 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-users text-2xl text-purple-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Total Pengguna</p>
            <p class="text-3xl font-bold text-gray-800 mt-0.5">{{ $stats['total_users'] }}</p>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-red-600 hover:underline">
                Kelola pengguna <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    @endif
</div>

<!-- ===== QUICK ACTIONS ===== -->
<div class="flex flex-wrap gap-3 mb-8">
    <a href="{{ route('admin.articles.create') }}"
       class="flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded hover:bg-red-700 transition text-sm font-semibold">
        <i class="fas fa-plus-circle"></i> Artikel Baru
    </a>
    <a href="{{ route('admin.categories.create') }}"
       class="flex items-center gap-2 bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded hover:border-red-500 hover:text-red-600 transition text-sm font-semibold">
        <i class="fas fa-folder-plus"></i> Kategori Baru
    </a>
    <a href="{{ route('admin.tags.create') }}"
       class="flex items-center gap-2 bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded hover:border-red-500 hover:text-red-600 transition text-sm font-semibold">
        <i class="fas fa-tag"></i> Tag Baru
    </a>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.users.create') }}"
       class="flex items-center gap-2 bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded hover:border-red-500 hover:text-red-600 transition text-sm font-semibold">
        <i class="fas fa-user-plus"></i> Pengguna Baru
    </a>
    @endif
    <a href="{{ route('admin.media.index') }}"
       class="flex items-center gap-2 bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded hover:border-red-500 hover:text-red-600 transition text-sm font-semibold">
        <i class="fas fa-photo-video"></i> Upload Media
    </a>
</div>

<!-- ===== TABLE SECTION ===== -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Recent Articles -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-800">
                <i class="fas fa-clock text-red-500 mr-2"></i>Artikel Terbaru
            </h2>
            <a href="{{ route('admin.articles.index') }}"
               class="text-xs text-red-600 hover:underline font-semibold">
                Lihat semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full admin-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-6 py-3">Judul</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentArticles as $article)
                    <tr>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.articles.edit', $article) }}"
                               class="text-sm font-medium text-gray-800 hover:text-red-600 transition line-clamp-1">
                                {{ $article->title }}
                            </a>
                            <p class="text-xs text-gray-400 mt-0.5">
                                <i class="fas fa-user mr-1"></i>{{ $article->user->name }}
                                <span class="mx-1">·</span>
                                <i class="fas fa-folder mr-1"></i>{{ $article->category->name }}
                            </p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 text-xs rounded-full font-semibold
                                {{ $article->status === 'published' ? 'badge-published' : 'badge-draft' }}">
                                {{ $article->status === 'published' ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center text-gray-400">
                            <i class="fas fa-file-alt text-3xl mb-2"></i>
                            <p class="text-sm">Belum ada artikel.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pending Comments -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-800">
                <i class="fas fa-hourglass-half text-yellow-500 mr-2"></i>Komentar Pending
            </h2>
            <a href="{{ route('admin.comments.index') }}"
               class="text-xs text-red-600 hover:underline font-semibold">
                Lihat semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($pendingComments as $comment)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600 flex-shrink-0 text-sm">
                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-800">{{ $comment->name }}</p>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $comment->body }}</p>
                        <p class="text-xs text-red-500 mt-1">
                            <i class="fas fa-file-alt mr-1"></i>{{ Str::limit($comment->article->title, 50) }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400">
                <i class="fas fa-check-circle text-3xl text-green-400 mb-2"></i>
                <p class="text-sm">Tidak ada komentar yang menunggu moderasi.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
