<!DOCTYPE html>
<html>
<head>
    <title>News - FIYA NEWS</title>
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

        /* Fallback default kalau tema belum terpilih */
        :root {
            --dynamic-main: #dc2626;
            --dynamic-hover: #b91c1c;
            --dynamic-bg-light: #fef2f2;
        }

        /* Suntik CSS dinamis ke class hover & transisi bawaan agar mulus */
        .theme-bind-text { color: var(--dynamic-main) !important; }
        .theme-bind-bg { background-color: var(--dynamic-main) !important; }
        .theme-bind-bg-light { background-color: var(--dynamic-bg-light) !important; }
        
        .theme-bind-hover:hover { color: var(--dynamic-hover) !important; }
        .group:hover .theme-bind-group-hover { color: var(--dynamic-hover) !important; }

        /* ==========================================================================
           ✨ PREMIUM TRANSITION GLOBALS (Sihir Luntur Halus)
           ========================================================================== */
        .card-animate, img, h1, h2, h3, h4, a, span {
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* Efek Hover Mengangkat Kartu & Shadow Lembut */
        .card-hover-effect:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.08), 0 4px 12px -5px rgba(0, 0, 0, 0.03);
        }

        /* ==========================================================================
           🎬 ANIMASI FADE-IN STAGGERED (Satu per satu saat load)
           ========================================================================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            opacity: 0;
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Mengatur jeda muncul antar kartu (Staggered Delay) */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-950">
    @include('layouts.navbar')

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- === AREA KIRI: MAIN CONTENT === --}}
            <div class="flex-1 space-y-8">

                {{-- HERO ARTICLE (Artikel Pertama) --}}
                @if($articles->count())
                    @php
                        $hero = $articles->first();
                    @endphp

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col md:flex-row md:h-72 card-animate card-hover-effect animate-fade-up group">
                        @if($hero->image)
                            <div class="w-full md:w-5/12 h-64 md:h-full overflow-hidden bg-gray-100 flex-shrink-0 relative">
                                <img src="{{ asset('storage/'.$hero->image) }}"
                                     class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                            </div>
                        @endif

                        <div class="p-6 flex flex-col justify-between flex-1 min-w-0">
                            <div>
                                <span class="inline-block theme-bind-bg-light theme-bind-text text-[11px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wide mb-2.5 group-hover:scale-105 transition-transform">
                                    {{ $hero->category ?? 'Featured' }}
                                </span>

                                <h1 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight mb-2 theme-bind-hover transition line-clamp-2">
                                    <a href="{{ route('articles.show', $hero->id) }}">{{ $hero->title }}</a>
                                </h1>

                                <p class="text-xs sm:text-sm text-gray-600 line-clamp-3 group-hover:text-gray-700">
                                    {{ $hero->excerpt }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 mt-3">
                                <p class="text-xs text-gray-500 font-medium">
                                    Source: <span class="text-gray-700 font-semibold">{{ $hero->source }}</span>
                                </p>
                                <a href="{{ route('articles.show', $hero->id) }}"
                                   class="theme-bind-text font-bold text-xs theme-bind-hover flex items-center gap-1 transition group-hover:translate-x-1">
                                    Read Full Article <span class="text-xs transition-transform group-hover:translate-x-0.5">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif


                {{-- SMALLER ARTICLES --}}
                <div class="space-y-4">
                    {{-- Loop data dengan index untuk memicu efek staggered delay otomatis --}}
                    @foreach($articles->skip(1) as $index => $article)
                        @php
                            // Batasi delay sampai urutan ke-5 saja agar artikel bawahnya yang di-scroll langsung instant
                            $delayClass = $index < 5 ? 'delay-' . ($index + 1) : '';
                        @endphp

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col sm:flex-row h-auto sm:h-40 card-animate card-hover-effect animate-fade-up {{ $delayClass }} group">
                            
                            @if($article->image)
                                <div class="w-full sm:w-44 md:w-48 h-40 sm:h-full flex-shrink-0 bg-gray-50 relative overflow-hidden">
                                    <img src="{{ asset('storage/'.$article->image) }}"
                                         class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                                    <span class="absolute top-3 left-3 bg-gray-900/80 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-0.5 rounded-md uppercase transition-transform group-hover:scale-95">
                                        {{ $article->category ?? 'News' }}
                                    </span>
                                </div>
                            @endif

                            <div class="p-4 flex flex-col justify-between flex-1 min-w-0">
                                <div>
                                    <p class="text-[11px] theme-bind-text font-bold uppercase tracking-wider mb-0.5">
                                        {{ $article->source }}
                                    </p>

                                    <h2 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 theme-bind-hover transition mb-1">
                                        <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                                    </h2>

                                    <p class="text-xs text-gray-600 line-clamp-2">
                                        {{ $article->excerpt }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between pt-1.5 border-t border-gray-100">
                                    <span class="text-[11px] text-gray-500">{{ $article->created_at ? $article->created_at->diffForHumans() : '' }}</span>
                                    <a href="{{ route('articles.show', $article->id) }}"
                                       class="theme-bind-text font-bold text-xs theme-bind-hover flex items-center gap-0.5 group-hover:translate-x-0.5">
                                        Read More <span class="transition-transform group-hover:translate-x-0.5">→</span>
                                    </a>
                                </div>
                            </div>

                        </div>

                    @endforeach
                </div>

            </div>


            {{-- LATEST ARTICLE (SIDEBAR KANAN) --}}
            <div class="w-full lg:w-[340px] flex-shrink-0">
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm sticky top-24 animate-fade-up delay-3">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-3.5 theme-bind-bg rounded-xs"></span>
                        Latest Article
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($articles->skip(1)->take(5) as $item)
                            <a href="{{ route('articles.show', $item->id) }}" class="flex gap-3 group items-start">
                                <div class="w-20 h-14 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100 relative">
                                    @if($item->image)
                                        <img src="{{ asset('storage/'.$item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" alt="thumb">
                                    @else
                                        <div class="w-full h-full theme-bind-bg flex items-center justify-center text-[9px] text-white font-bold p-1 text-center line-clamp-2 transition-transform group-hover:scale-105">
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
</body>
</html>