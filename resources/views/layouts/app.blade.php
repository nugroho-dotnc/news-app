<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>@yield('title', 'Beranda') | News App</title>
    <meta name="description" content="@yield('description', 'Portal berita terkini dan terpercaya')">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailnews CSS -->
    <link rel="stylesheet" href="{{ asset('tailnews.css') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @stack('styles')
</head>
<body class="text-gray-700 pt-9 sm:pt-10">

    <!-- ========== { HEADER } ========== -->
    <header class="fixed top-0 left-0 right-0 z-50">
        <nav class="bg-black">
            <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
                <div class="flex justify-between">
                    <div class="mx-w-10 text-2xl font-bold capitalize text-white flex items-center">
                        <a href="{{ route('home') }}" class="text-white hover:text-red-500 transition-colors">
                            <i class="fas fa-newspaper mr-2 text-red-500"></i>News App
                        </a>
                    </div>

                    <div class="flex flex-row">
                        <!-- nav menu -->
                        <ul class="navbar hidden lg:flex lg:flex-row text-gray-400 text-sm items-center font-bold">
                            <li class="active relative border-l border-gray-800 hover:bg-gray-900">
                                <a class="block py-3 px-6 border-b-2 border-transparent" href="{{ route('home') }}">Beranda</a>
                            </li>
                            @php
                                $navCategories = \App\Models\Category::take(6)->get();
                            @endphp
                            @foreach($navCategories as $navCat)
                            <li class="relative border-l border-gray-800 hover:bg-gray-900">
                                <a class="block py-3 px-6 border-b-2 border-transparent" href="{{ route('category.show', $navCat->slug) }}">{{ $navCat->name }}</a>
                            </li>
                            @endforeach
                        </ul>

                        <!-- search form & mobile nav -->
                        <div class="flex flex-row items-center text-gray-300">
                            <div class="search-dropdown relative border-r lg:border-l border-gray-800 hover:bg-gray-900">
                                <button class="block py-3 px-6 border-b-2 border-transparent">
                                    <i class="fas fa-search open"></i>
                                    <i class="fas fa-times close" style="display:none;"></i>
                                </button>
                                <div class="dropdown-menu absolute left-auto right-0 top-full z-50 text-left bg-white text-gray-700 border border-gray-100 mt-1 p-3" style="min-width: 18rem;">
                                    <form action="{{ route('search') }}" method="GET">
                                        <div class="flex flex-wrap items-stretch w-full relative">
                                            <input type="text" name="q" value="{{ request('q') }}"
                                                class="flex-shrink flex-grow max-w-full leading-5 w-px flex-1 relative py-2 px-5 text-gray-800 bg-white border border-gray-300 overflow-x-auto focus:outline-none focus:border-gray-400 focus:ring-0"
                                                placeholder="Cari artikel..." aria-label="search">
                                            <div class="flex -mr-px">
                                                <button class="flex items-center py-2 px-5 -ml-1 leading-5 text-gray-100 bg-black hover:text-white hover:bg-gray-900 focus:outline-none focus:ring-0" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @auth
                            <div class="relative border-l border-gray-800 hover:bg-gray-900">
                                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 border-b-2 border-transparent text-sm font-bold text-red-400 hover:text-red-300">
                                    <i class="fas fa-cog mr-1"></i> Admin
                                </a>
                            </div>
                            @endauth

                            <div class="relative hover:bg-gray-800 block lg:hidden">
                                <button type="button" class="menu-mobile block py-3 px-6 border-b-2 border-transparent">
                                    <span class="sr-only">Mobile menu</span>
                                    <i class="fas fa-bars inline-block mr-1"></i> Menu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header><!-- end header -->

    <!-- Mobile menu -->
    <div class="side-area fixed w-full h-full inset-0 z-50">
        <!-- bg open -->
        <div class="back-menu fixed bg-gray-900 bg-opacity-70 w-full h-full inset-x-0 top-0">
            <div class="cursor-pointer text-white absolute right-64 p-2">
                <i class="fas fa-times text-2xl"></i>
            </div>
        </div>

        <!-- Mobile navbar -->
        <nav id="mobile-nav" class="side-menu flex flex-col right-0 w-64 fixed top-0 bg-white dark:bg-gray-800 h-full overflow-auto z-40">
            <div class="mb-auto">
                <nav class="relative flex flex-wrap">
                    <div class="text-center py-4 w-full font-bold border-b border-gray-100">
                        <i class="fas fa-newspaper text-red-600 mr-2"></i>NEWS APP
                    </div>
                    <ul id="side-menu" class="w-full float-none flex flex-col">
                        <li class="relative">
                            <a href="{{ route('home') }}" class="block py-2 px-5 border-b border-gray-100 hover:bg-gray-50">
                                <i class="fas fa-home mr-2 text-gray-400"></i>Beranda
                            </a>
                        </li>
                        @foreach($navCategories as $navCat)
                        <li class="relative">
                            <a href="{{ route('category.show', $navCat->slug) }}" class="block py-2 px-5 border-b border-gray-100 hover:bg-gray-50">
                                <i class="fas fa-folder mr-2 text-gray-400"></i>{{ $navCat->name }}
                            </a>
                        </li>
                        @endforeach
                        @auth
                        <li class="relative">
                            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-5 border-b border-gray-100 hover:bg-gray-50 text-red-600">
                                <i class="fas fa-cog mr-2"></i>Panel Admin
                            </a>
                        </li>
                        @endauth
                    </ul>
                </nav>
            </div>
            <!-- copyright -->
            <div class="py-4 px-6 text-sm mt-6 text-center">
                <p>© {{ date('Y') }} <a href="{{ route('home') }}" class="text-red-600">News App</a> - Semua hak dilindungi</p>
            </div>
        </nav>
    </div><!-- End Mobile menu -->

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2 mt-4">
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded text-sm flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-500"></i> {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2 mt-4">
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded text-sm flex items-center">
                <i class="fas fa-exclamation-circle mr-2 text-red-500"></i> {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- =========={ MAIN } ========== -->
    <main id="content">
        @yield('content')
    </main><!-- end main -->

    <!-- =========={ FOOTER } ========== -->
    <footer class="bg-black text-gray-400">
        <div id="footer-content" class="relative pt-8 xl:pt-16 pb-6 xl:pb-12">
            <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2 overflow-hidden">
                <div class="flex flex-wrap flex-row lg:justify-between -mx-3">
                    <div class="flex-shrink max-w-full w-full lg:w-2/5 px-3 lg:pr-16">
                        <div class="flex items-center mb-4">
                            <span class="text-3xl font-bold text-gray-100">
                                <i class="fas fa-newspaper text-red-500 mr-2"></i>News App
                            </span>
                        </div>
                        <p class="mb-4">Portal berita terkini, terpercaya, dan selalu menghadirkan informasi terbaru untuk Anda.</p>
                        <ul class="space-x-3 mt-6 mb-6">
                            <li class="inline-block">
                                <a target="_blank" class="hover:text-gray-100" href="#" title="Facebook">
                                    <i class="fab fa-facebook fa-2x"></i>
                                </a>
                            </li>
                            <li class="inline-block">
                                <a target="_blank" class="hover:text-gray-100" href="#" title="Twitter/X">
                                    <i class="fab fa-x-twitter fa-2x"></i>
                                </a>
                            </li>
                            <li class="inline-block">
                                <a target="_blank" class="hover:text-gray-100" href="#" title="Instagram">
                                    <i class="fab fa-instagram fa-2x"></i>
                                </a>
                            </li>
                            <li class="inline-block">
                                <a target="_blank" class="hover:text-gray-100" href="#" title="Youtube">
                                    <i class="fab fa-youtube fa-2x"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-shrink max-w-full w-full lg:w-3/5 px-3">
                        <div class="flex flex-wrap flex-row">
                            <div class="flex-shrink max-w-full w-1/2 md:w-1/3 mb-6 lg:mb-0">
                                <h4 class="text-base leading-normal mb-3 uppercase text-gray-100">Kategori</h4>
                                <ul>
                                    @php $footerCategories = \App\Models\Category::take(5)->get(); @endphp
                                    @foreach($footerCategories as $fCat)
                                    <li class="py-1 hover:text-white">
                                        <a href="{{ route('category.show', $fCat->slug) }}">{{ $fCat->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="flex-shrink max-w-full w-1/2 md:w-1/3 mb-6 lg:mb-0">
                                <h4 class="text-base leading-normal mb-3 uppercase text-gray-100">Navigasi</h4>
                                <ul>
                                    <li class="py-1 hover:text-white"><a href="{{ route('home') }}">Beranda</a></li>
                                    <li class="py-1 hover:text-white"><a href="{{ route('search') }}">Pencarian</a></li>
                                    @auth
                                    <li class="py-1 hover:text-white"><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                                    @endauth
                                </ul>
                            </div>
                            <div class="flex-shrink max-w-full w-1/2 md:w-1/3 mb-6 lg:mb-0">
                                <h4 class="text-base leading-normal mb-3 uppercase text-gray-100">Info</h4>
                                <ul>
                                    <li class="py-1 hover:text-white"><a href="#">Tentang Kami</a></li>
                                    <li class="py-1 hover:text-white"><a href="#">Kebijakan Privasi</a></li>
                                    <li class="py-1 hover:text-white"><a href="#">Kontak</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer copyright -->
        <div class="border-t border-gray-800 py-4">
            <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2 text-center">
                <p>© {{ date('Y') }} News App. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer><!-- end footer -->

    <!-- Scroll To Top -->
    <a href="#" class="back-top fixed p-4 rounded bg-gray-100 border border-gray-100 text-gray-500 dark:bg-gray-900 dark:border-gray-800 right-4 bottom-4 hidden" aria-label="Scroll To Top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Vendor JS -->
    <script src="{{ asset('vendors/hc-sticky/dist/hc-sticky.js') }}"></script>
    <script src="{{ asset('vendors/glightbox/dist/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendors/@splidejs/splide/dist/js/splide.min.js') }}"></script>

    <!-- Tailnews Theme JS -->
    <script src="{{ asset('tailnews.js') }}"></script>

    @stack('scripts')
</body>
</html>
