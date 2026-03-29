<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Admin News App</title>

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Roboto', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background-color: rgba(239, 68, 68, 0.1); border-left: 3px solid #ef4444; }
        .sidebar-link.active { background-color: rgba(239, 68, 68, 0.15); border-left: 3px solid #ef4444; color: #fca5a5; }
        .stat-card { transition: all 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
        /* Custom scrollbar for sidebar */
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: #1f2937; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #374151; border-radius: 2px; }
        .admin-table tr:hover td { background-color: #f9fafb; }
        .badge-published { background-color: #d1fae5; color: #065f46; }
        .badge-draft { background-color: #fef3c7; color: #92400e; }
        .badge-pending { background-color: #fee2e2; color: #991b1b; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100" style="font-family: 'Roboto', sans-serif;">

<div class="flex h-screen overflow-hidden">

    {{-- ========== SIDEBAR ========== --}}
    <aside class="w-64 flex-col flex-shrink-0 hidden lg:flex" style="background: linear-gradient(180deg, #111827 0%, #1f2937 100%);">

        {{-- Logo --}}
        <div class="h-16 flex items-center px-6 border-b border-gray-700 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                <div class="w-8 h-8 bg-red-600 rounded flex items-center justify-center">
                    <i class="fas fa-newspaper text-white text-sm"></i>
                </div>
                <span class="text-white font-bold text-lg">News Admin</span>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto sidebar-nav py-4">

            <div class="px-6 mb-3 text-xs text-gray-500 uppercase font-semibold tracking-widest">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line w-5 text-center text-gray-400"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.articles.index') }}"
               class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300 {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt w-5 text-center text-gray-400"></i>
                <span>Artikel</span>
                @php $draftCount = \App\Models\Article::where('status','draft')->count(); @endphp
                @if($draftCount > 0)
                    <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full">{{ $draftCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder w-5 text-center text-gray-400"></i>
                <span>Kategori</span>
            </a>

            <a href="{{ route('admin.tags.index') }}"
               class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300 {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <i class="fas fa-tags w-5 text-center text-gray-400"></i>
                <span>Tag</span>
            </a>

            <a href="{{ route('admin.comments.index') }}"
               class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300 {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                <i class="fas fa-comments w-5 text-center text-gray-400"></i>
                <span>Komentar</span>
                @php $pendingCount = \App\Models\Comment::where('status','pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto text-xs bg-red-500 text-white px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.media.index') }}"
               class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300 {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <i class="fas fa-images w-5 text-center text-gray-400"></i>
                <span>Media</span>
            </a>

            @if(auth()->user()->isAdmin())
                <div class="px-6 mt-5 mb-3 text-xs text-gray-500 uppercase font-semibold tracking-widest">Administrasi</div>

                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-5 text-center text-gray-400"></i>
                    <span>Pengguna</span>
                </a>
            @endif

        </nav>

        {{-- User Profile at Bottom --}}
        <div class="border-t border-gray-700 p-5 flex-shrink-0">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-gray-100 font-semibold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-red-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" target="_blank"
                   class="flex-1 text-xs text-center py-1.5 px-3 bg-gray-700 text-gray-300 hover:bg-gray-600 rounded transition">
                    <i class="fas fa-external-link-alt mr-1"></i>Lihat Situs
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full text-xs py-1.5 px-3 bg-red-700 bg-opacity-30 text-red-400 hover:bg-red-700 hover:text-white rounded transition">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Mobile Sidebar Overlay --}}
    <div id="mobile-sidebar-overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden" onclick="toggleMobileSidebar()"></div>

    {{-- Mobile Sidebar --}}
    <aside id="mobile-sidebar" class="fixed left-0 top-0 bottom-0 w-64 z-50 flex-col lg:hidden hidden overflow-y-auto"
           style="background: linear-gradient(180deg, #111827 0%, #1f2937 100%);">
        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-700 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-red-600 rounded flex items-center justify-center">
                    <i class="fas fa-newspaper text-white text-sm"></i>
                </div>
                <span class="text-white font-bold text-lg">News Admin</span>
            </a>
            <button onclick="toggleMobileSidebar()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <nav class="flex-1 py-4">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300">
                <i class="fas fa-chart-line w-5 text-center text-gray-400"></i> Dashboard
            </a>
            <a href="{{ route('admin.articles.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300">
                <i class="fas fa-file-alt w-5 text-center text-gray-400"></i> Artikel
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300">
                <i class="fas fa-folder w-5 text-center text-gray-400"></i> Kategori
            </a>
            <a href="{{ route('admin.tags.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300">
                <i class="fas fa-tags w-5 text-center text-gray-400"></i> Tag
            </a>
            <a href="{{ route('admin.comments.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300">
                <i class="fas fa-comments w-5 text-center text-gray-400"></i> Komentar
            </a>
            <a href="{{ route('admin.media.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300">
                <i class="fas fa-images w-5 text-center text-gray-400"></i> Media
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm text-gray-300">
                <i class="fas fa-users w-5 text-center text-gray-400"></i> Pengguna
            </a>
            @endif
        </nav>
    </aside>

    {{-- ========== MAIN CONTENT ========== --}}
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-4">
                {{-- Mobile menu toggle --}}
                <button onclick="toggleMobileSidebar()"
                    class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                {{-- Page Title --}}
                <div>
                    <h1 class="text-lg font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                    <div class="text-xs text-gray-400">
                        <a href="{{ route('home') }}" class="hover:text-red-600">News App</a>
                        <span class="mx-1">/</span>
                        <span>@yield('title', 'Dashboard')</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                {{-- Quick actions --}}
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.articles.create') }}"
                   class="hidden sm:flex items-center gap-2 text-sm bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    <i class="fas fa-plus"></i> <span>Artikel Baru</span>
                </a>
                @elseif(auth()->user()->role === 'editor')
                <a href="{{ route('admin.articles.create') }}"
                   class="hidden sm:flex items-center gap-2 text-sm bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    <i class="fas fa-plus"></i> <span>Artikel Baru</span>
                </a>
                @endif
                <a href="{{ route('home') }}" target="_blank"
                   class="text-sm text-gray-500 hover:text-red-600 transition hidden sm:block">
                    <i class="fas fa-external-link-alt mr-1"></i>Lihat Situs
                </a>
                {{-- Avatar --}}
                <div class="w-9 h-9 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-sm cursor-pointer">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success') || session('error') || $errors->any())
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded text-sm mb-3 flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500 flex-shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded text-sm mb-3 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-red-500 flex-shrink-0"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded text-sm mb-3">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                        <strong>Terjadi kesalahan:</strong>
                    </div>
                    <ul class="list-disc list-inside space-y-1 ml-6">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>
</div>

<script>
function toggleMobileSidebar() {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-sidebar-overlay');
    sidebar.classList.toggle('hidden');
    overlay.classList.toggle('hidden');
}
</script>

@stack('scripts')

</body>
</html>
