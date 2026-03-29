@extends('layouts.app')
@section('title', $article->title)
@section('content')

<!-- ===== ARTICLE SINGLE PAGE ===== -->
<div class="bg-gray-50 py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
        <div class="flex flex-row flex-wrap">

            <!-- Left: Article Content -->
            <div class="flex-shrink max-w-full w-full lg:w-2/3 overflow-hidden">
                <div class="w-full py-3 mb-3">
                    <!-- Breadcrumb -->
                    <nav class="text-sm text-gray-500 mb-4">
                        <a href="{{ route('home') }}" class="hover:text-red-600">Beranda</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('category.show', $article->category->slug) }}" class="hover:text-red-600">{{ $article->category->name }}</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-700">{{ Str::limit($article->title, 50) }}</span>
                    </nav>
                    <h1 class="text-gray-800 text-3xl font-bold">
                        <span class="inline-block h-5 border-l-3 border-red-600 mr-2"></span>{{ $article->title }}
                    </h1>
                </div>

                <div class="flex flex-row flex-wrap -mx-3">
                    <div class="max-w-full w-full px-4">

                        {{-- Article Thumbnail --}}
                        @if($article->thumbnail)
                            <figure class="text-center mb-6">
                                <img class="max-w-full w-full h-auto rounded" src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}">
                            </figure>
                        @endif

                        <!-- Metadata Bar -->
                        <div class="relative flex flex-row items-center justify-between overflow-hidden bg-gray-100 dark:bg-gray-900 dark:bg-opacity-20 mb-6 px-6 py-2">
                            <div class="my-4 text-sm">
                                <!-- Author -->
                                <span class="mr-2 md:mr-4">
                                    <i class="fas fa-user mr-2 text-gray-500"></i>
                                    oleh <a class="font-semibold hover:text-red-600" href="#">{{ $article->user->name }}</a>
                                </span>
                                <!-- Date -->
                                <time class="mr-2 md:mr-4" datetime="{{ $article->published_at }}">
                                    <i class="fas fa-calendar mr-2 text-gray-500"></i>
                                    {{ optional($article->published_at)->format('d M Y') }}
                                </time>
                                <!-- Category -->
                                <span class="mr-2 md:mr-4">
                                    <i class="fas fa-folder mr-2 text-gray-500"></i>
                                    <a href="{{ route('category.show', $article->category->slug) }}" class="hover:text-red-600">{{ $article->category->name }}</a>
                                </span>
                                <!-- Comments -->
                                <span>
                                    <i class="fas fa-comment mr-2 text-gray-500"></i>
                                    {{ $article->approvedComments->count() }} komentar
                                </span>
                            </div>
                            <!-- Share -->
                            <div class="hidden lg:block">
                                <ul class="space-x-3">
                                    <li class="inline-block">
                                        <a target="_blank" class="hover:text-red-700" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" title="Share to Facebook">
                                            <i class="fab fa-facebook fa-2x"></i>
                                        </a>
                                    </li>
                                    <li class="inline-block">
                                        <a target="_blank" class="hover:text-red-700" href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" title="Share to Twitter">
                                            <i class="fab fa-x-twitter fa-2x"></i>
                                        </a>
                                    </li>
                                    <li class="inline-block">
                                        <a target="_blank" class="hover:text-red-700" href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" title="Share to WhatsApp">
                                            <i class="fab fa-whatsapp fa-2x"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="leading-relaxed pb-4 prose max-w-none">
                            {!! nl2br(e($article->content)) !!}
                        </div>

                        <!-- Tags -->
                        @if($article->tags->count())
                            <div class="mt-6 mb-4">
                                <span class="text-sm font-semibold text-gray-600 mr-2">
                                    <i class="fas fa-tags mr-1"></i>Tag:
                                </span>
                                @foreach($article->tags as $tag)
                                    <span class="inline-block text-xs bg-gray-100 text-gray-600 hover:bg-red-600 hover:text-white px-3 py-1 rounded-full mr-1 mb-1 transition-colors cursor-pointer">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Author Box -->
                        <div class="flex flex-wrap flex-row -mx-4 justify-center py-6 border-t border-dashed border-gray-200 mt-6">
                            <div class="flex-shrink max-w-full px-4 w-1/4 sm:w-1/6">
                                <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-3xl font-bold border-2 border-red-200">
                                    {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-shrink max-w-full px-4 w-3/4 sm:w-5/6">
                                <p class="text-lg leading-normal mb-1 font-semibold text-gray-800">
                                    {{ $article->user->name }}
                                </p>
                                <p class="text-sm text-red-600 capitalize mb-1">{{ $article->user->role }}</p>
                                <p class="text-sm text-gray-500">Penulis di News App</p>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div id="comments" class="pt-8 border-t border-gray-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                                <i class="fas fa-comments mr-2 text-red-600"></i>
                                {{ $article->approvedComments->count() }} Komentar
                            </h3>

                            @if(session('success'))
                                <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded text-sm mb-4 flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                </div>
                            @endif

                            <!-- Comment List -->
                            <ol class="mb-8">
                                @forelse($article->approvedComments as $comment)
                                <li class="py-2 mt-6">
                                    <div class="pb-4 border-b border-gray-200 border-dashed">
                                        <footer class="mb-2">
                                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600 float-left mr-4 text-lg">
                                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <a class="text-base font-semibold text-gray-800" href="#"> {{ $comment->name }}</a>
                                                <span class="float-right text-sm text-gray-400">
                                                    <i class="fas fa-clock mr-1"></i>{{ $comment->created_at->format('d M Y, H:i') }}
                                                </span>
                                            </div>
                                        </footer>
                                        <div class="clear-both pt-2">
                                            <p class="text-gray-600">{{ $comment->body }}</p>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                    <li class="py-4 text-center text-gray-400">
                                        <i class="fas fa-comment-slash text-2xl mb-2"></i>
                                        <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                                    </li>
                                @endforelse
                            </ol>

                            <!-- Comment Form -->
                            <div id="comment-form" class="mt-8">
                                <h4 class="text-2xl font-bold text-gray-800 mb-2">
                                    <i class="fas fa-pencil-alt mr-2 text-red-600"></i>TULIS KOMENTAR
                                </h4>
                                <p class="mb-5 text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>Komentar akan ditampilkan setelah dimoderasi.
                                </p>
                                <form action="{{ route('article.comment', $article->slug) }}" method="POST" novalidate>
                                    @csrf
                                    <div class="mb-6">
                                        <textarea
                                            class="w-full leading-5 relative py-3 px-5 text-gray-800 bg-white border border-gray-100 overflow-x-auto focus:outline-none focus:border-gray-400 focus:ring-0"
                                            placeholder="Tulis komentar Anda..." aria-label="masukkan komentar"
                                            name="body" rows="4" required minlength="5">{{ old('body') }}</textarea>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full sm:w-1/2 px-3 mb-6">
                                            <input class="w-full leading-5 relative py-3 px-5 text-gray-800 bg-white border border-gray-100 overflow-x-auto focus:outline-none focus:border-gray-400 focus:ring-0"
                                                placeholder="Nama Anda *" aria-label="nama" type="text" name="name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="w-full sm:w-1/2 px-3 mb-6">
                                            <input class="w-full leading-5 relative py-3 px-5 text-gray-800 bg-white border border-gray-100 overflow-x-auto focus:outline-none focus:border-gray-400 focus:ring-0"
                                                placeholder="Email Anda *" aria-label="email" type="email" name="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    @if($errors->any())
                                        <div class="text-red-500 text-xs mb-4 space-y-1">
                                            @foreach($errors->all() as $err)
                                                <p><i class="fas fa-exclamation-circle mr-1"></i>{{ $err }}</p>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="mb-6">
                                        <button type="submit"
                                            class="flex items-center py-3 px-6 leading-5 text-gray-100 bg-black hover:text-white hover:bg-red-700 transition focus:outline-none focus:ring-0">
                                            <i class="fas fa-paper-plane mr-2"></i>Kirim Komentar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right: Sidebar -->
            <div class="flex-shrink max-w-full w-full lg:w-1/3 lg:pl-8 lg:pt-14 lg:pb-8 order-first lg:order-last">
                <div class="w-full bg-white">

                    {{-- Related Articles --}}
                    @if($related->count())
                    <div class="mb-6">
                        <div class="p-4 bg-gray-100">
                            <h2 class="text-lg font-bold">
                                <span class="inline-block h-4 border-l-3 border-red-600 mr-2"></span>Artikel Terkait
                            </h2>
                        </div>
                        <ul>
                            @foreach($related as $rel)
                            <li class="border-b border-gray-100 hover:bg-gray-50">
                                <a class="flex gap-3 px-4 py-3" href="{{ route('article.show', $rel->slug) }}">
                                    @if($rel->thumbnail)
                                        <img src="{{ Storage::url($rel->thumbnail) }}" alt="{{ $rel->title }}"
                                            class="w-16 h-12 object-cover flex-shrink-0 rounded">
                                    @else
                                        <div class="w-16 h-12 bg-gray-100 flex-shrink-0 rounded flex items-center justify-center">
                                            <i class="fas fa-newspaper text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800 hover:text-red-600 leading-tight line-clamp-2">{{ $rel->title }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ optional($rel->published_at)->format('d M Y') }}</p>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
