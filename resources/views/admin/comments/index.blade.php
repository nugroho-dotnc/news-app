@extends('layouts.admin')
@section('title', 'Moderasi Komentar')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-comments text-red-500 mr-2"></i>Moderasi Komentar
        </h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola komentar dari pembaca</p>
    </div>
    <!-- Filter Tabs -->
    <div class="flex gap-2">
        @foreach(['all' => 'Semua', 'pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $key => $label)
            <a href="{{ route('admin.comments.index', ['status' => $key]) }}"
               class="px-3 py-1.5 text-xs rounded font-semibold border transition
                      {{ $status === $key ? 'bg-gray-900 text-white border-gray-900' : 'border-gray-200 text-gray-600 hover:border-gray-400' }}">
                @if($key === 'pending')
                    <i class="fas fa-hourglass-half mr-1"></i>
                @elseif($key === 'approved')
                    <i class="fas fa-check-circle mr-1"></i>
                @elseif($key === 'rejected')
                    <i class="fas fa-times-circle mr-1"></i>
                @else
                    <i class="fas fa-list mr-1"></i>
                @endif
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm divide-y divide-gray-50">
    @forelse($comments as $comment)
    <div class="p-5 flex items-start gap-4 hover:bg-gray-50 transition-colors">
        <!-- Avatar -->
        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600 flex-shrink-0">
            {{ strtoupper(substr($comment->name, 0, 1)) }}
        </div>
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <p class="text-sm font-bold text-gray-800">{{ $comment->name }}</p>
                <span class="text-xs text-gray-400">{{ $comment->email }}</span>
                <span class="px-2 py-0.5 text-xs rounded-full font-semibold
                    {{ $comment->status === 'pending' ? 'bg-yellow-100 text-yellow-700'
                       : ($comment->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                    @if($comment->status === 'pending')
                        <i class="fas fa-hourglass-half mr-1"></i>Pending
                    @elseif($comment->status === 'approved')
                        <i class="fas fa-check-circle mr-1"></i>Disetujui
                    @else
                        <i class="fas fa-times-circle mr-1"></i>Ditolak
                    @endif
                </span>
            </div>
            <p class="text-sm text-gray-600 mb-2 leading-relaxed">{{ $comment->body }}</p>
            <p class="text-xs text-gray-400">
                <i class="fas fa-file-alt mr-1 text-red-400"></i>
                <a href="{{ route('article.show', $comment->article->slug) }}" target="_blank"
                   class="text-red-600 hover:underline">{{ Str::limit($comment->article->title, 60) }}</a>
                <span class="mx-2">·</span>
                <i class="fas fa-clock mr-1"></i>{{ $comment->created_at->format('d M Y, H:i') }}
            </p>
        </div>
        <!-- Actions -->
        <div class="flex items-center gap-2 flex-shrink-0">
            @if($comment->status !== 'approved')
                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit"
                        class="text-xs bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded font-semibold transition" title="Setujui">
                        <i class="fas fa-check mr-1"></i>Setuju
                    </button>
                </form>
            @endif
            @if($comment->status !== 'rejected')
                <form method="POST" action="{{ route('admin.comments.reject', $comment) }}" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit"
                        class="text-xs bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded font-semibold transition" title="Tolak">
                        <i class="fas fa-times mr-1"></i>Tolak
                    </button>
                </form>
            @endif
            <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                  onsubmit="return confirm('Hapus komentar ini permanen?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                    class="text-xs text-gray-400 hover:text-red-600 border border-gray-200 hover:border-red-300 px-2 py-1.5 rounded transition" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="p-12 text-center text-gray-400">
        <i class="fas fa-comment-slash text-5xl mb-3"></i>
        <p class="text-sm">Tidak ada komentar {{ $status !== 'all' ? 'dengan status "'.$status.'"' : '' }}.</p>
    </div>
    @endforelse
</div>

<div class="mt-5">{{ $comments->appends(request()->query())->links() }}</div>

@endsection
