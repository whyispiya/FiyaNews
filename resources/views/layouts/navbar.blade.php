<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=300;400;500;600;700;800&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ==========================================================================
       🌈 DEFINE THEME VARIABLES (Smooth Transition Enabled)
       ========================================================================== */
    /* marah */
    :root, .theme-red, #main-header.theme-red {
        --nav-brand: #dc2626;
        --nav-brand-hover: #b91c1c;
        --nav-sub: #b91c1c;
        --nav-sub-hover: #991b1b;
        --nav-bg-light: #fef2f2;
    }
    
    /* negro */
    .theme-dark, #main-header.theme-dark {
        --nav-brand: #111827;
        --nav-brand-hover: #1f2937;
        --nav-sub: #1f2937;
        --nav-sub-hover: #374151;
        --nav-bg-light: #f3f4f6;
    }
    
    /* matcha */
    .theme-emerald, #main-header.theme-emerald {
        --nav-brand: #55a578;
        --nav-brand-hover: #38935e;
        --nav-sub: #5e9e67;
        --nav-sub-hover: #498953;
        --nav-bg-light: #ecfdf5;
    }

    /* blue */
    .theme-indigo, #main-header.theme-indigo {
        --nav-brand: #5469cf;
        --nav-brand-hover: #4338ca;
        --nav-sub: #736bd1;
        --nav-sub-hover: #514d83;
        --nav-bg-light: #e0e7ff;
    }

    /* orange */
    .theme-orange, #main-header.theme-orange {
        --nav-brand: #df9263;
        --nav-brand-hover: #ca8565;
        --nav-sub: #dfa175;
        --nav-sub-hover: #ca8565;
        --nav-bg-light: #fff7ed;
    }

    /* pink */
    .theme-pink, #main-header.theme-pink {
        --nav-brand: #e09cbb;
        --nav-brand-hover: #c47293;
        --nav-sub: #dc94b2;
        --nav-sub-hover: #c47293;
        --nav-bg-light: #fdf2f8;
    }

    /* ==========================================================================
       ✨ TRANSISI GLOBAL: Sihir Luntur Halus & Efek Fisik Membal
       ========================================================================== */
    html, body, header, nav, a, button, div, span, textarea, input {
        transition: background-color 0.5s cubic-bezier(0.4, 0, 0.2, 1), 
                    border-color 0.5s cubic-bezier(0.4, 0, 0.2, 1), 
                    color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                    box-shadow 0.3s ease;
    }

    /* Utilitas Class Dinamis */
    .dynamic-brand-text { color: var(--nav-brand) !important; }
    .dynamic-brand-bg { background-color: var(--nav-brand) !important; }
    .dynamic-brand-bg-hover:hover { background-color: var(--nav-brand-hover) !important; }
    .dynamic-brand-border { border-color: var(--nav-brand) !important; color: var(--nav-brand) !important; }
    .dynamic-brand-text-hover:hover { color: var(--nav-brand) !important; }
    .group:hover .dynamic-brand-text-link { color: var(--nav-brand) !important; }

    .dynamic-sub-bg { background-color: var(--nav-sub) !important; }
    .dynamic-sub-link-hover:hover { background-color: var(--nav-sub-hover) !important; }
    .dynamic-sub-link-active { background-color: var(--nav-sub-hover) !important; }

    /* ==========================================================================
       🎯 GLOBAL BINDING AUTOMATION
       ========================================================================== */
    .text-red-500, .text-red-600, .text-red-700, [class*="text-red-"], [class*="text-rose-"] {
        color: var(--nav-brand) !important;
    }
    
    .bg-red-500, .bg-red-600, [class*="bg-red-"] {
        background-color: var(--nav-brand) !important;
    }

    .hover\:text-red-500:hover, .hover\:text-red-600:hover, .group:hover .group-hover\:text-red-500 {
        color: var(--nav-brand-hover) !important;
    }

    .bg-red-50 {
        background-color: var(--nav-bg-light) !important;
    }
    
    .scrollbar-none::-webkit-scrollbar { display: none; }
    .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Sidebar Bindings */
    #sidebar .dynamic-brand-text,
    #sidebar .hover\:text-red-500:hover,
    #sidebar .hover\:text-red-600:hover {
        color: var(--nav-brand) !important;
    }

    #sidebar .group:hover span {
        color: var(--nav-brand) !important;
    }

    #sidebar .group:hover .group-hover\:bg-gray-200 {
        background-color: var(--nav-brand-hover) !important;
        opacity: 0.12; 
    }

    /* ==========================================================================
       🎉 MICRO-INTERACTIONS (Animasi Lucu & Interaktif)
       ========================================================================== */
    
    /* Animasi Pop-In saat tombol lingkaran tema diklik */
    @keyframes popIn {
        0% { transform: scale(0.8); opacity: 0.5; }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-pop { animation: popIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }

    /* Efek gemas klik & hover pada tombol utama dan submit */
    button[type="submit"]:hover, .dynamic-brand-bg-hover:hover, #sidebar button:not([onclick^="changeTheme"]):hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    button[type="submit"]:active, .dynamic-brand-bg-hover:active {
        transform: translateY(1px) scale(0.97);
    }

    /* Efek tombol lingkaran tema aktif */
    .theme-active {
        transform: scale(1.2);
        border-color: #111827 !important;
        box-shadow: 0 0 0 4px var(--nav-bg-light);
    }
</style>

<header id="main-header" class="w-full bg-white sticky top-0 z-50 shadow-xs theme-red" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-3 flex items-center justify-between gap-4">
        
        <button onclick="openSidebar()" class="flex items-center gap-2 text-gray-700 hover:text-red-600 transition group cursor-pointer border border-gray-200 px-3 py-1.5 rounded-lg bg-gray-50/50 hover:bg-gray-100">
            <span class="text-xl font-bold inline-block group-hover:rotate-12 transition-transform">☰</span>
        </button>

        <h1 class="text-xl md:text-2xl font-extrabold tracking-tight text-gray-900 flex-shrink-0">
            <a href="{{ route('articles.index') }}" class="flex items-center gap-1 group">
                <div class="flex items-center gap-2">
                    <span class="dynamic-brand-text font-black text-lg tracking-wider group-hover:scale-105 transition-transform">FIYANEWS</span>
                    <span class="text-gray-800 font-light text-lg tracking-wider"></span>
                </div>
            </a>
        </h1>

        <div class="hidden md:flex flex-1 max-w-2xl mx-4">
            @php
                $formAction = request()->routeIs('category') ? route('category', request()->route('category')) : route('articles.index');
            @endphp
            
            <form action="{{ $formAction }}" method="GET" class="w-full relative flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="{{ request()->routeIs('category') ? 'Cari di kategori ini...' : 'Search News or Article...' }}"
                    class="w-full pl-5 pr-14 py-2 bg-gray-50 border border-gray-200 rounded-full text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-500 focus:bg-white transition duration-200 shadow-inner">
                
                <button type="submit" class="absolute right-1 dynamic-brand-bg dynamic-brand-bg-hover text-white w-9 h-9 rounded-full flex items-center justify-center transition cursor-pointer">
                    🔎︎
                </button>
            </form>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <span class="text-xs font-bold text-gray-700 mr-2">haiii, {{ auth()->user()->name }}</span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="border dynamic-brand-border hover:bg-gray-50 px-5 py-2 rounded-full text-xs font-bold transition cursor-pointer">
                        Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('register') }}" class="dynamic-brand-bg dynamic-brand-bg-hover text-white px-5 py-2 rounded-full text-xs font-bold transition cursor-pointer shadow-xs text-center">
                    Sign In
                </a>
                <a href="{{ route('login') }}" class="border dynamic-brand-border hover:bg-gray-50 px-5 py-2 rounded-full text-xs font-bold transition cursor-pointer text-center">
                    Log In
                </a>
            @endauth
        </div>
    </div>

    <div class="dynamic-sub-bg text-white">
        <div class="max-w-7xl mx-auto px-4 flex gap-1 overflow-x-auto scrollbar-none whitespace-nowrap text-xs md:text-sm font-bold">
            <a href="{{ route('articles.index') }}"
               class="px-4 py-3 dynamic-sub-link-hover transition-colors duration-150
               {{ request()->routeIs('articles.index') && !request('category') && !request()->is('category/*') ? 'dynamic-sub-link-active' : '' }}">
                Home
            </a>

            @foreach(['Sport', 'Business', 'Technology', 'Health', 'Culture', 'Travel'] as $cat)
                <a href="{{ route('category', $cat) }}"
                   class="px-4 py-3 dynamic-sub-link-hover transition-colors duration-150
                   {{ request()->is('category/*') && request()->route('category') == $cat ? 'dynamic-sub-link-active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>
</header>

<div id="overlay" onclick="closeSidebar()"
     class="fixed inset-0 bg-black/40 backdrop-blur-xs hidden z-50 transition-opacity duration-300 opacity-0">
</div>

<div id="sidebar" style="font-family: 'Plus Jakarta Sans', sans-serif;"
     class="fixed top-0 left-[-400px] w-[340px] h-full bg-white z-50 shadow-2xl transition-all duration-300 overflow-y-auto flex flex-col">
    
    <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <div class="flex items-center gap-2">
            <span class="dynamic-brand-text font-black text-lg">FIYANEWS</span><span class="text-gray-800 font-light text-lg"></span>
        </div>
        <button onclick="closeSidebar()" class="flex items-center gap-1 text-xs font-bold text-gray-500 hover:text-red-500 transition border border-gray-200 px-2.5 py-1 rounded-lg bg-white cursor-pointer hover:rotate-1">
            ✕ Close
        </button>
    </div>

    <div class="p-4 mx-4 mt-4 bg-gray-50 border border-gray-100 rounded-xl">
        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2.5 px-1">Change Theme :</p>
        <div class="flex flex-wrap items-center gap-3 px-1">
            <button onclick="changeTheme('theme-red', this)" class="w-6 h-6 rounded-full bg-red-600 cursor-pointer hover:scale-125 transition-all border-2 border-white shadow-md" title="MARAHH"></button>
            <button onclick="changeTheme('theme-dark', this)" class="w-6 h-6 rounded-full bg-gray-900 cursor-pointer hover:scale-125 transition-all border-2 border-white shadow-md" title="Black"></button>
            <button onclick="changeTheme('theme-emerald', this)" class="w-6 h-6 rounded-full bg-[#55a578] cursor-pointer hover:scale-125 transition-all border-2 border-white shadow-md" title="Green"></button>
            <button onclick="changeTheme('theme-indigo', this)" class="w-6 h-6 rounded-full bg-[#5469cf] cursor-pointer hover:scale-125 transition-all border-2 border-white shadow-md" title="Blue"></button>
            <button onclick="changeTheme('theme-orange', this)" class="w-6 h-6 rounded-full bg-[#df9263] cursor-pointer hover:scale-125 transition-all border-2 border-white shadow-md" title="Orange"></button>
            <button onclick="changeTheme('theme-pink', this)" class="w-6 h-6 rounded-full bg-[#e09cbb] cursor-pointer hover:scale-125 transition-all border-2 border-white shadow-md" title="Pink"></button>
        </div>
    </div>

    <div class="p-4 md:hidden border-b border-gray-100">
        @php
            $formActionMobile = request()->routeIs('category') ? route('category', request()->route('category')) : route('articles.index');
        @endphp
        <form action="{{ $formActionMobile }}" method="GET" class="relative flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="{{ request()->routeIs('category') ? 'Cari di kategori ini...' : 'Cari berita...' }}"
                class="w-full pl-4 pr-10 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-medium text-gray-900 focus:outline-none">
            <button type="submit" class="absolute right-3 text-gray-400 text-xs">🔍</button>
        </form>
    </div>

    <div class="p-5 flex-1 space-y-6">
        <div>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('articles.index') }}" class="group flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition">
                    <span class="bg-gray-100 w-8 h-8 rounded-lg flex items-center justify-center p-1.5 flex-shrink-0 group-hover:bg-gray-200 transition-colors duration-200">
                        <img src="{{ asset('assets/icons/home.png') }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-200" alt="Home">
                    </span>
                    <span>Top News</span>
                </a>

                @auth
                    <a href="{{ route('articles.create') }}" class="group flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition">
                        <span class="bg-gray-100 w-8 h-8 rounded-lg flex items-center justify-center p-1.5 flex-shrink-0 group-hover:bg-gray-200 transition-colors duration-200">
                            <img src="{{ asset('assets/icons/write.png') }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-200" alt="Write">
                        </span>
                        <span>Write Article</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="group flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-400 opacity-60 hover:text-red-600 transition" onclick="alert('Kamu harus login terlebih dahulu untuk menulis artikel!')">
                        <span class="bg-gray-100 w-8 h-8 rounded-lg flex items-center justify-center p-1.5 flex-shrink-0">
                            <img src="{{ asset('assets/icons/write.png') }}" class="w-full h-full object-contain grayscale" alt="Write">
                        </span>
                        <span>Write Article</span>
                    </a>
                @endauth
            </div>
        </div>

        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3 px-2">Category</p>
            <div class="grid grid-cols-2 gap-1.5">
                @php
                    $categoriesWithImages = [
                        'Sport'      => 'sport.png',
                        'Business'   => 'business.png',
                        'Technology' => 'technology.png',
                        'Health'     => 'health.png',
                        'Culture'    => 'culture.png',
                        'Travel'     => 'travel.png'
                    ];
                @endphp

                @foreach($categoriesWithImages as $cat => $imageName)
                    <a href="{{ route('category', $cat) }}" class="group flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <span class="bg-gray-100 w-8 h-8 rounded-lg flex items-center justify-center p-1.5 flex-shrink-0 group-hover:bg-gray-200 transition-colors duration-200">
                            <img src="{{ asset('assets/icons/' . $imageName) }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-200" alt="{{ $cat }}">
                        </span>
                        <span>{{ $cat }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function changeTheme(themeName, element = null) {
        const header = document.getElementById('main-header');
        if (!header) return;

        // Reset class lama
        header.classList.remove('theme-red', 'theme-dark', 'theme-emerald', 'theme-indigo', 'theme-orange', 'theme-pink');
        
        // Tambahkan tema baru ke header & documentElement
        header.classList.add(themeName);
        document.documentElement.className = themeName;

        // Kunci di memori browser
        localStorage.setItem('fiya_news_theme', themeName);

        // Efek animasi lucu pada lingkaran tombol aktif
        document.querySelectorAll('#sidebar button[onclick^="changeTheme"]').forEach(btn => {
            btn.classList.remove('animate-pop', 'theme-active');
        });

        if (element) {
            element.classList.add('animate-pop', 'theme-active');
        } else {
            // Sinkronisasi tombol aktif saat halaman baru dimuat
            const targetButton = document.querySelector(`#sidebar button[onclick*="'${themeName}'"]`);
            if (targetButton) targetButton.classList.add('theme-active');
        }
    }

    function openSidebar() {
        const overlay = document.getElementById('overlay');
        document.getElementById('sidebar').style.left = '0';
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.add('opacity-100'), 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        const overlay = document.getElementById('overlay');
        document.getElementById('sidebar').style.left = '-400px';
        overlay.classList.remove('opacity-100');
        setTimeout(() => overlay.classList.add('hidden'), 300);
        document.body.classList.remove('overflow-hidden');
    }

    window.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('fiya_news_theme') || 'theme-red';
        changeTheme(savedTheme);

        const hasVisited = localStorage.getItem('been_here');

        if (!hasVisited) {
            Swal.fire({
                title: 'Welcome Nigga',
                text: 'You\'re our first reader!',
                icon: 'success',
                confirmButtonText: 'Start reading',
                confirmButtonColor: '#b91c1c',
                customClass: {
                    popup: 'rounded-2xl scale-95 transition-all duration-300',
                    title: 'font-extrabold text-gray-900',
                    htmlContainer: 'font-medium text-gray-600'
                }
            });

            var duration = 2.5 * 1000;
            var end = Date.now() + duration;

            (function frame() {
                confetti({ particleCount: 3, angle: 60, spread: 55, origin: { x: 0, y: 0.8 } });
                confetti({ particleCount: 3, angle: 120, spread: 55, origin: { x: 1, y: 0.8 } });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());

            localStorage.setItem('been_here', 'true');
        }
    });
</script>