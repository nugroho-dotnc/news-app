@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-600">
        <i class="fas fa-arrow-left text-lg"></i>
    </a>
    <h2 class="text-xl font-bold text-gray-800">
        <i class="fas fa-user-plus text-red-500 mr-2"></i>Tambah Pengguna Baru
    </h2>
</div>

<div class="max-w-lg">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user text-gray-400 mr-1"></i>Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Masukkan nama lengkap..."
                    class="w-full px-4 py-2.5 border border-gray-200 rounded focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 text-sm transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-envelope text-gray-400 mr-1"></i>Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    placeholder="email@example.com"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 text-sm transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-shield-alt text-gray-400 mr-1"></i>Role <span class="text-red-500">*</span>
                </label>
                <select name="role" class="w-full px-4 py-2.5 border border-gray-200 rounded focus:outline-none focus:border-red-400 text-sm">
                    <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>
                        ✍️ Editor
                    </option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                        👑 Administrator
                    </option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock text-gray-400 mr-1"></i>Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" required minlength="8"
                    placeholder="Minimal 8 karakter"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 text-sm transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock text-gray-400 mr-1"></i>Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation" required
                    placeholder="Ulangi password"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200 text-sm transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded hover:bg-red-700 transition text-sm font-semibold">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-2 bg-gray-100 text-gray-700 px-5 py-2.5 rounded hover:bg-gray-200 transition text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
