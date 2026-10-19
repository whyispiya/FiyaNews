<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} - FIYA NEWS</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite('resources/css/app.css')

    <style>
        /* ==========================================================================
           🌈 SIHIR CSS: Menangkap class tema dari #main-header dan menyebarkannya
           ========================================================================== */
        #main-header.theme-red ~ * { --dynamic-main: #dc2626; --dynamic-hover: #b91c1c; --dynamic-bg-light: #fef2f2; }
        #main-header.theme-dark ~ * { --dynamic-main: #111827; --dynamic-hover: #1f2937; --dynamic-bg-light: #f3f4f6; }
        #main-header.theme-emerald ~ * { --dynamic-main: #059669; --dynamic-hover: #047857; --dynamic-bg-light: #ecfdf5; }
        #main-header.theme-indigo ~ * { --dynamic-main: #4f46e5; --dynamic-hover: #4338ca; --dynamic-bg-light: #e0e7ff; }
        #main-header.theme-orange ~ * { --dynamic-main: #ea580c; --dynamic-hover: #ca8a04; --dynamic-bg-light: #fff7ed; }
        #main-header.theme-pink ~ * { --dynamic-main: #db2777; --dynamic-hover: #be185d; --dynamic-bg-light: #fdf2f8; }

        /* Fallback default */
        :root {
            --dynamic-main: #dc2626;
            --dynamic-hover: #b91c1c;
            --dynamic-bg-light: #fef2f2;
        }

        /* Suntik CSS dinamis */
        .theme-bind-text { color: var(--dynamic-main) !important; }
        .theme-bind-bg { background-color: var(--dynamic-main) !important; }
        .theme-bind-bg-light { background-color: var(--dynamic-bg-light) !important; }
        .theme-bind-border { border-color: var(--dynamic-main) !important; }
        
        .theme-bind-hover:hover { color: var(--dynamic-hover) !important; }
        .theme-bind-bg-hover:hover { background-color: var(--dynamic-hover) !important; }

        /* ==========================================================================
           ✨ PREMIUM TRANSITION GLOBALS & MICRO-INTERACTIONS
           ========================================================================== */
        img, h1, a, button, span, svg, input, textarea {
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* Animasi Lembut Pas Halaman Dibuka */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-show-content {
            opacity: 0;
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-article { animation-delay: 0.1s; }
        .delay-sidebar { animation-delay: 0.25s; }

        /* Interaksi bounce halus untuk form input saat fokus */
        textarea:focus, input:focus {
            box-shadow: 0 0 0 4px var(--dynamic-bg-light) !important;
            border-color: var(--dynamic-main) !important;
        }

        /* Tipografi isi artikel */
        .prose p { margin-bottom: 1.25rem; line-height: 1.75; }
        .prose h2, .prose h3 { font-weight: 700; color: #111827; margin-top: 1.5rem; margin-bottom: 0.5rem; }
        .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    </style>
</head>
<body class="bg-gray-50 antialiased font-sans text-gray-800">
    @include('layouts.navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Tombol Kembali Animatif --}}
        <div class="mb-6 animate-show-content">
            <a href="{{ route('articles.index') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-gray-600 hover:text-gray-900 transition">
                <span class="transition-transform group-hover:-translate-x-1.5">←</span> Back to News
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- === AREA KIRI: DETAIL ARTIKEL === --}}
            <div class="lg:col-span-8 flex-1 space-y-8 animate-show-content delay-article">
                
                <article class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden p-6 md:p-8 space-y-6">
                    
                    {{-- Judul Besar --}}
                    <h1 class="text-2xl md:text-4xl font-black text-gray-900 leading-tight tracking-tight">
                        {{ $article->title }}
                    </h1>

                    {{-- Kategori, Author, & Metadata (Keep Elemen Bawaan) --}}
                    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 border-b border-gray-100 pb-4">
                        <span class="font-semibold text-gray-700">
                            ✍️ {{ $article->author ?? 'Unknown Author' }}
                        </span>
                        <span>•</span>
                        <span>📅 {{ $article->created_at ? $article->created_at->format('F d, Y') : 'Unknown Date' }}</span>
                        <span>•</span>
                        <span class="bg-red-50 text-red-700 px-2 py-0.5 rounded text-xs font-medium">
                            Tahun: {{ $article->created_at ? $article->created_at->format('Y') : '-' }}
                        </span>
                    </div>

                    {{-- Gambar Utama Hero Section --}}
                    <div class="mb-6 overflow-hidden rounded-xl aspect-video bg-gray-100 shadow-inner group/hero relative">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Cover" class="w-full h-full object-cover scale-102 group-hover/hero:scale-100 duration-700">
                            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover/hero:opacity-100 transition-opacity pointer-events-none"></div>
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-red-500 to-emerald-600 flex flex-col items-center justify-center text-white p-6 text-center">
                                <span class="text-xs uppercase tracking-widest bg-white/20 px-3 py-1 rounded-full mb-2">Pojok Sekolah</span>
                                <h2 class="text-2xl md:text-3xl font-black tracking-wide uppercase">{{ $article->title }}</h2>
                            </div>
                        @endif
                    </div>

                    {{-- Isi Konten Artikel --}}
                    <div class="prose max-w-none text-gray-700 leading-relaxed break-words whitespace-pre-line mb-8">
                        {{ $article->content }}
                    </div>

                    {{-- Sesi Fitur Like Dinamis --}}
                    <div class="flex items-center gap-4 py-4 border-t border-b border-gray-100 my-6">
                        @auth
                            <form action="{{ route('articles.like', $article->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-4 py-2 rounded-full text-sm flex items-center gap-2 transition cursor-pointer hover:scale-105 active:scale-95">
                                    ❤️ {{ $article->likes ? $article->likes->count() : 0 }} Likes
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-500 font-medium px-4 py-2 rounded-full text-sm flex items-center gap-2 transition" onclick="alert('Login dulu wok')">
                                🤍 {{ $article->likes ? $article->likes->count() : 0 }} Likes
                            </a>
                        @endauth
                    </div>

                    {{-- Footer Detail Artikel + Tombol Manajemen (Edit & Delete) --}}
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 mt-8">
                        <p class="text-xs text-gray-400 order-3 sm:order-1">
                            ID Artikel: <span class="font-mono font-bold">#{{ $article->id }}</span>
                        </p>
                        
                        @auth
                            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto justify-end order-2">
                                {{-- 🎨 Tombol Edit --}}
                                <a href="{{ route('articles.edit', $article->id) }}" 
                                   class="theme-bind-bg theme-bind-bg-hover text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5 hover:scale-105 active:scale-95 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>

                                {{-- 🛑 Tombol Delete --}}
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus artikel ini? Data yang dihapus tidak bisa dikembalikan.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="background-color: #ef4444;" 
                                            class="text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5 hover:bg-[#dc2626] hover:scale-105 active:scale-95 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </article>

                {{-- SECTION KOMENTAR DENGAN LOGIC AUTH BAWAAN --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sm:p-8 space-y-6">
                    <h3 class="text-base font-black text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-4 theme-bind-bg rounded-xs"></span>
                        Comment
                    </h3>
                    
                    @auth
                        <form action="{{ route('articles.comment.store', $article->id) }}" method="POST" class="mb-6 space-y-3">
                            @csrf
                            <textarea name="body" placeholder="Write your comments here..." class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white transition duration-200" rows="3" required></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="theme-bind-bg theme-bind-bg-hover text-white px-5 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer shadow-xs">Send</button>
                            </div>
                        </form>
                    @else
                        <div class="bg-gray-50 border border-gray-200 text-gray-500 text-center py-4 rounded-xl text-xs font-semibold mb-6">
                            Wants to join? <a href="{{ route('login') }}" class="text-red-600 underline font-bold">Log In</a> or <a href="{{ route('register') }}" class="text-red-600 underline font-bold">Sign In</a> First.
                        </div>
                    @endauth

                    {{-- List Rendering Komentar --}}
                    <div class="space-y-4">
                        @if($article->comments && $article->comments->count() > 0)
                            @foreach($article->comments as $comment)
                                <div class="bg-gray-50/50 border border-gray-100 rounded-xl p-4 transition hover:bg-gray-50">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-bold text-gray-800">👤 {{ $comment->user->name }}</span>
                                        <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $comment->body }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="text-xs text-gray-400 italic text-center py-4 bg-gray-50/30 rounded-xl border border-dashed border-gray-200">No comment, be the first one to do so..</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- === AREA KANAN: SIDEBAR REKOMENDASI LATEST ARTICLE === --}}
            <div class="lg:col-span-4 space-y-6 animate-show-content delay-sidebar">
                <div class="w-full lg:w-[340px] flex-shrink-0">
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs sticky top-24">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-3.5 theme-bind-bg rounded-xs"></span>
                            Latest Article
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($articles->skip(1)->take(5) as $item)
                                <a href="{{ route('articles.show', $item->id) }}" class="flex gap-3 group items-start">
                                    <div class="w-20 h-14 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100 relative">
                                        @if($item->image)
                                            <img src="{{ asset('storage/'.$item->image) }}" class="w-full h-full object-cover group-hover:scale-110 duration-300" alt="thumb">
                                        @else
                                            <div class="w-full h-full theme-bind-bg flex items-center justify-center text-[9px] text-white font-bold p-1 text-center line-clamp-2">
                                                {{ Str::limit($item->title, 10) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] theme-bind-text font-bold uppercase tracking-wide mb-0.5">
                                            {{ $item->source ?? 'Fiya News' }}
                                        </p>
                                        <h4 class="text-xs font-bold text-gray-800 theme-bind-group-hover line-clamp-2 transition leading-tight group-hover:translate-x-1">
                                            {{ $item->title }}
                                        </h4>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>