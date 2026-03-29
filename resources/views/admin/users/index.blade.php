@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-users text-red-500 mr-2"></i>Daftar Pengguna
        </h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola admin dan editor</p>
    </div>
    <a href="{{ route('admin.users.create') }}"
        class="flex items-center gap-2 bg-gray-900 text-white px-4 py-2.5 rounded hover:bg-red-700 transition text-sm font-semibold">
        <i class="fas fa-user-plus"></i> Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100 admin-table">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Pengguna</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Bergabung</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-50">
            @forelse($users as $user)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-xs text-red-400 font-normal">(Anda)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-1 text-xs rounded-full font-semibold capitalize
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                        <i class="fas {{ $user->role === 'admin' ? 'fa-crown' : 'fa-pen-nib' }} mr-1"></i>
                        {{ $user->role }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-xs text-blue-600 hover:text-blue-800 border border-blue-200 px-2 py-1 rounded transition" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-red-600 hover:text-red-800 border border-red-200 px-2 py-1 rounded transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-users text-5xl mb-3"></i>
                    <p class="text-sm">Belum ada pengguna.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-5">{{ $users->links() }}</div>

@endsection
