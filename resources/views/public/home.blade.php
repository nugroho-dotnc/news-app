@extends('layouts.app')
@section('title', 'Beranda')
@section('content')

{{-- ===== HERO BIG GRID ===== --}}
@if($featuredArticles->count() >= 2)
<div class="bg-white py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
        <!-- big grid -->
        <div class="flex flex-row flex-wrap">
            {{-- Left Cover (1st featured article) --}}
            <div class="flex-shrink max-w-full w-full lg:w-1/2 pb-1 lg:pb-0 lg:pr-1">
                <div class="relative hover-img max-h-98 overflow-hidden">
                    <a href="{{ route('article.show', $featuredArticles[0]->slug) }}">
                        @if($featuredArticles[0]->thumbnail)
                            <img class="max-w-full w-full mx-auto h-auto object-cover" style="height: 400px;"
                                src="{{ Storage::url($featuredArticles[0]->thumbnail) }}"
                                alt="{{ $featuredArticles[0]->title }}">
                        @else
                            <div class="w-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center" style="height: 400px;">
                                <i class="fas fa-newspaper text-white text-6xl opacity-30"></i>
                            </div>
                        @endif
                    </a>
                    <div class="absolute px-5 pt-8 pb-5 bottom-0 w-full bg-gradient-cover">
                        <a href="{{ route('category.show', $featuredArticles[0]->category->slug) }}">
                            <span class="text-xs text-white font-semibold px-2 py-1 bg-red-600 rounded mb-2 inline-block">
                                {{ $featuredArticles[0]->category->name }}
                            </span>
                        </a>
                        <a href="{{ route('article.show', $featuredArticles[0]->slug) }}">
                            <h2 class="text-3xl font-bold capitalize text-white mb-3">{{ $featuredArticles[0]->title }}</h2>
                        </a>
                        <p class="text-gray-100 hidden sm:inline-block">{{ Str::limit(strip_tags($featuredArticles[0]->content), 120) }}</p>
                        <div class="pt-2 text-gray-200 text-sm">
                            <i class="fas fa-user mr-1"></i> {{ $featuredArticles[0]->user->name }}
                            <span class="mx-2">·</span>
                            <i class="fas fa-calendar mr-1"></i> {{ optional($featuredArticles[0]->published_at)->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Grid (remaining featured articles) --}}
            <div class="flex-shrink max-w-full w-full lg:w-1/2">
                <div class="box-one flex flex-row flex-wrap">
                    @foreach($featuredArticles->slice(1, 4) as $feat)
                    <article class="flex-shrink max-w-full w-full sm:w-1/2">
                        <div class="relative hover-img max-h-48 overflow-hidden">
                            <a href="{{ route('article.show', $feat->slug) }}">
                                @if($feat->thumbnail)
                                    <img class="max-w-full w-full mx-auto object-cover" style="height: 190px;"
                                        src="{{ Storage::url($feat->thumbnail) }}"
                                        alt="{{ $feat->title }}">
                                @else
                                    <div class="w-full bg-gradient-to-br from-gray-600 to-gray-800 flex items-center justify-center" style="height: 190px;">
                                        <i class="fas fa-newspaper text-white text-4xl opacity-30"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="absolute px-4 pt-7 pb-4 bottom-0 w-full bg-gradient-cover">
                                <a href="{{ route('article.show', $feat->slug) }}">
                                    <h2 class="text-lg font-bold capitalize leading-tight text-white mb-1">{{ Str::limit($feat->title, 65) }}</h2>
                                </a>
                                <div class="pt-1">
                                    <a href="{{ route('category.show', $feat->category->slug) }}" class="text-gray-100 text-sm">
                                        <span class="inline-block h-3 border-l-2 border-red-600 mr-2"></span>{{ $feat->category->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@elseif($featuredArticles->count() >= 1)
<div class="bg-white py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
        <div class="relative hover-img overflow-hidden">
            <a href="{{ route('article.show', $featuredArticles[0]->slug) }}">
                @if($featuredArticles[0]->thumbnail)
                    <img class="max-w-full w-full mx-auto object-cover" style="height: 450px;"
                        src="{{ Storage::url($featuredArticles[0]->thumbnail) }}"
                        alt="{{ $featuredArticles[0]->title }}">
                @else
                    <div class="w-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center" style="height: 450px;">
                        <i class="fas fa-newspaper text-white text-6xl opacity-30"></i>
                    </div>
                @endif
            </a>
            <div class="absolute px-8 pt-8 pb-8 bottom-0 w-full bg-gradient-cover">
                <a href="{{ route('article.show', $featuredArticles[0]->slug) }}">
                    <h2 class="text-4xl font-bold capitalize text-white mb-3">{{ $featuredArticles[0]->title }}</h2>
                </a>
                <div class="text-gray-200 text-sm">
                    <span class="inline-block h-3 border-l-2 border-red-600 mr-2"></span>
                    {{ $featuredArticles[0]->category->name }}
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== LATEST ARTICLES + SIDEBAR ===== --}}
<div class="bg-white py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
        <div class="flex flex-row flex-wrap">

            {{-- Left: Latest Articles --}}
            <div class="flex-shrink max-w-full w-full lg:w-2/3 overflow-hidden">
                <div class="w-full py-3">
                    <h2 class="text-gray-800 text-2xl font-bold">
                        <span class="inline-block h-5 border-l-3 border-red-600 mr-2"></span>Artikel Terbaru
                    </h2>
                </div>
                <div class="flex flex-row flex-wrap -mx-3">
                    @forelse($latestArticles as $article)
                    <div class="flex-shrink max-w-full w-full sm:w-1/2 px-3 pb-5 pt-3">
                        <div class="flex flex-row sm:block hover-img">
                            <a href="{{ route('article.show', $article->slug) }}">
                                @if($article->thumbnail)
                                    <img class="max-w-full w-full mx-auto object-cover" style="height: 180px;"
                                        src="{{ Storage::url($article->thumbnail) }}"
                                        alt="{{ $article->title }}">
                                @else
                                    <div class="max-w-full w-full mx-auto bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center" style="height: 180px;">
                                        <i class="fas fa-newspaper text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="py-0 sm:py-3 pl-3 sm:pl-0">
                                <a href="{{ route('category.show', $article->category->slug) }}" class="text-red-600 text-xs font-semibold uppercase tracking-wide">
                                    {{ $article->category->name }}
                                </a>
                                <h3 class="text-base font-bold leading-tight mb-2 mt-1">
                                    <a href="{{ route('article.show', $article->slug) }}" class="hover:text-red-600 transition-colors">
                                        {{ Str::limit($article->title, 70) }}
                                    </a>
                                </h3>
                                <p class="hidden md:block text-gray-600 text-sm leading-tight mb-2">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-user mr-1"></i> {{ $article->user->name }}
                                    <span class="mx-1">·</span>
                                    <i class="fas fa-clock mr-1"></i> {{ optional($article->published_at)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="w-full px-3 py-10 text-center text-gray-400">
                            <i class="fas fa-newspaper text-5xl mb-3"></i>
                            <p>Belum ada artikel tersedia.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4 pb-4">
                    {{ $latestArticles->links() }}
                </div>
            </div>

            {{-- Right: Sidebar --}}
            <div class="flex-shrink max-w-full w-full lg:w-1/3 lg:pl-8 lg:pt-14 lg:pb-8 order-first lg:order-last">
                <div class="w-full">

                    {{-- Most Popular / Categories --}}
                    <div class="mb-6">
                        <div class="p-4 bg-gray-100">
                            <h2 class="text-lg font-bold">
                                <span class="inline-block h-4 border-l-3 border-red-600 mr-2"></span>Kategori
                            </h2>
                        </div>
                        <ul class="post-number">
                            @forelse($categories as $cat)
                            <li class="border-b border-gray-100 hover:bg-gray-50">
                                <a class="text-sm font-semibold px-6 py-3 flex flex-row items-center justify-between" href="{{ route('category.show', $cat->slug) }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->articles_count }}</span>
                                </a>
                            </li>
                            @empty
                            <li class="px-6 py-3 text-sm text-gray-400">Belum ada kategori.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
