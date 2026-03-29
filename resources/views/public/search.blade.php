@extends('layouts.app')
@section('title', $keyword ? 'Hasil Pencarian: ' . $keyword : 'Pencarian')
@section('content')

<!-- ===== SEARCH PAGE ===== -->
<div class="bg-gray-50 py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">

        <!-- Search Header -->
        <div class="w-full py-3 mb-6">
            <h1 class="text-gray-800 text-2xl font-bold">
                <span class="inline-block h-5 border-l-3 border-red-600 mr-2"></span>
                <i class="fas fa-search text-red-600 mr-2"></i>Pencarian
            </h1>
            @if($keyword)
                <p class="text-gray-500 text-sm mt-2 ml-7">
                    {{ $articles->total() }} hasil untuk "<strong class="text-gray-700">{{ $keyword }}</strong>"
                </p>
            @endif
        </div>

        <!-- Search Form -->
        <form action="{{ route('search') }}" method="GET" class="mb-8">
            <div class="flex flex-wrap items-stretch w-full relative max-w-2xl">
                <input type="text" name="q" value="{{ $keyword }}"
                    class="flex-shrink flex-grow leading-5 w-px flex-1 relative py-3 px-5 text-gray-800 bg-white border border-gray-200 overflow-x-auto focus:outline-none focus:border-gray-400 focus:ring-0 text-base"
                    placeholder="Cari artikel, topik, atau kata kunci..." aria-label="search">
                <div class="flex -mr-px">
                    <button class="flex items-center py-3 px-6 -ml-1 leading-5 text-gray-100 bg-black hover:bg-red-700 hover:text-white transition focus:outline-none focus:ring-0 font-semibold" type="submit">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                </div>
            </div>
        </form>

        <!-- Results -->
        <div class="flex flex-row flex-wrap">
            <div class="flex-shrink max-w-full w-full lg:w-2/3 overflow-hidden">
                @forelse($articles as $article)
                <div class="flex flex-row mb-5 pb-5 border-b border-gray-100 hover-img">
                    <a href="{{ route('article.show', $article->slug) }}" class="flex-shrink-0 mr-4">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                                class="object-cover rounded" style="width: 130px; height: 90px;">
                        @else
                            <div class="rounded bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center"
                                style="width: 130px; height: 90px;">
                                <i class="fas fa-newspaper text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                    </a>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('category.show', $article->category->slug) }}"
                           class="text-xs text-red-600 font-semibold uppercase tracking-wide">
                            <i class="fas fa-folder mr-1"></i>{{ $article->category->name }}
                        </a>
                        <h2 class="text-base font-bold text-gray-800 mt-1 mb-1 leading-tight">
                            <a href="{{ route('article.show', $article->slug) }}" class="hover:text-red-600 transition-colors">
                                {{ $article->title }}
                            </a>
                        </h2>
                        <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                        <div class="text-xs text-gray-400">
                            <i class="fas fa-user mr-1"></i>{{ $article->user->name }}
                            <span class="mx-2">·</span>
                            <i class="fas fa-clock mr-1"></i>{{ optional($article->published_at)->format('d M Y') }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-16 text-center text-gray-400">
                    <i class="fas fa-search text-6xl mb-4"></i>
                    <p class="text-xl mb-2">
                        {{ $keyword ? 'Artikel tidak ditemukan.' : 'Masukkan kata kunci untuk mencari.' }}
                    </p>
                    @if($keyword)
                        <p class="text-sm">Coba gunakan kata kunci yang berbeda atau lebih umum.</p>
                    @endif
                    <a href="{{ route('home') }}" class="mt-4 inline-block text-red-600 hover:underline">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Beranda
                    </a>
                </div>
                @endforelse

                <div class="mt-6">{{ $articles->links() }}</div>
            </div>

            <!-- Sidebar -->
            <div class="flex-shrink max-w-full w-full lg:w-1/3 lg:pl-8 lg:pt-2 order-first lg:order-last">
                <div class="mb-6">
                    <div class="p-4 bg-gray-100">
                        <h2 class="text-lg font-bold">
                            <span class="inline-block h-4 border-l-3 border-red-600 mr-2"></span>Semua Kategori
                        </h2>
                    </div>
                    <ul>
                        @php $allCats = \App\Models\Category::withCount(['articles' => fn($q) => $q->where('status', 'published')])->get(); @endphp
                        @foreach($allCats as $cat)
                        <li class="border-b border-gray-100 hover:bg-gray-50">
                            <a class="text-sm font-semibold px-6 py-3 flex flex-row items-center justify-between" href="{{ route('category.show', $cat->slug) }}">
                                <span><i class="fas fa-chevron-right text-red-500 mr-2 text-xs"></i>{{ $cat->name }}</span>
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->articles_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
