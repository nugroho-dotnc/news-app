@extends('layouts.app')
@section('title', 'Kategori: ' . $category->name)
@section('content')

<!-- ===== CATEGORY PAGE ===== -->
<div class="bg-gray-50 py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">

        <!-- Category Header -->
        <div class="w-full py-3 mb-6">
            <nav class="text-sm text-gray-500 mb-2">
                <a href="{{ route('home') }}" class="hover:text-red-600">Beranda</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700">{{ $category->name }}</span>
            </nav>
            <h1 class="text-gray-800 text-3xl font-bold">
                <span class="inline-block h-6 border-l-4 border-red-600 mr-3"></span>
                <i class="fas fa-folder-open text-red-600 mr-2"></i>{{ $category->name }}
            </h1>
            <p class="text-gray-500 text-sm mt-2 ml-7">{{ $articles->total() }} artikel ditemukan</p>
        </div>

        <!-- Article Grid -->
        <div class="flex flex-row flex-wrap -mx-3">
            @forelse($articles as $article)
            <div class="flex-shrink max-w-full w-full sm:w-1/2 lg:w-1/3 px-3 pb-6">
                <div class="block hover-img bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <a href="{{ route('article.show', $article->slug) }}">
                        @if($article->thumbnail)
                            <img class="max-w-full w-full mx-auto object-cover" style="height: 200px;"
                                src="{{ Storage::url($article->thumbnail) }}"
                                alt="{{ $article->title }}">
                        @else
                            <div class="max-w-full w-full mx-auto bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center" style="height: 200px;">
                                <i class="fas fa-newspaper text-gray-400 text-5xl"></i>
                            </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <a href="{{ route('category.show', $article->category->slug) }}"
                           class="text-xs text-red-600 font-semibold uppercase tracking-wide">
                            <i class="fas fa-folder mr-1"></i>{{ $article->category->name }}
                        </a>
                        <h3 class="text-base font-bold leading-tight mt-2 mb-2">
                            <a href="{{ route('article.show', $article->slug) }}" class="hover:text-red-600 transition-colors">
                                {{ Str::limit($article->title, 75) }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-600 leading-tight mb-3">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span><i class="fas fa-user mr-1"></i>{{ $article->user->name }}</span>
                            <span><i class="fas fa-clock mr-1"></i>{{ optional($article->published_at)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="w-full py-16 text-center text-gray-400">
                <i class="fas fa-folder-open text-6xl mb-4"></i>
                <p class="text-xl">Belum ada artikel di kategori ini.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block text-red-600 hover:underline">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali ke Beranda
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">{{ $articles->links() }}</div>

    </div>
</div>

@endsection
