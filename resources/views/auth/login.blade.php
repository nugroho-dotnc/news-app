<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | News App Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .login-bg {
            background: linear-gradient(135deg, #111827 0%, #1f2937 50%, #111827 100%);
            min-height: 100vh;
        }
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.97);
        }
        .news-accent { border-left: 4px solid #ef4444; }
    </style>
</head>
<body class="login-bg flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <!-- Logo Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-red-600 rounded-2xl mb-4 shadow-lg">
            <i class="fas fa-newspaper text-white text-3xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-white">News App</h1>
        <p class="text-gray-400 text-sm mt-1">Portal Berita Admin Panel</p>
    </div>

    <!-- Card Login -->
    <div class="login-card rounded-2xl shadow-2xl p-8">
        <div class="news-accent pl-4 mb-6">
            <h2 class="text-xl font-bold text-gray-800">Masuk ke Dashboard</h2>
            <p class="text-sm text-gray-500">Gunakan akun admin atau editor Anda</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-sm mb-5 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-envelope text-gray-400 mr-1"></i>Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="admin@newsapp.com"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 text-sm transition @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock text-gray-400 mr-1"></i>Password
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        placeholder="••••••••"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 text-sm transition pr-10">
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-red-500 focus:ring-red-400">
                    Ingat saya
                </label>
            </div>

            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-gray-900 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition text-sm">
                <i class="fas fa-sign-in-alt"></i>
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-gray-100 text-center">
            <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-red-600 transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <p class="text-center text-gray-500 text-xs mt-6">© {{ date('Y') }} News App. Semua hak dilindungi.</p>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>

</body>
</html>
