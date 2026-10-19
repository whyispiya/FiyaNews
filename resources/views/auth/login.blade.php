<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Featured Update - FIYA NEWS</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite('resources/css/app.css')

    <style>
        body, html {
            margin: 0; padding: 0; width: 100%; height: 100%;
            overflow: hidden; background-color: #ffffff;
        }

        /* Premium Input Focus Magic */
        .editorial-input {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .editorial-input:focus {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.08) !important;
            background-color: #ffffff;
        }

        /* Floating effect for the single featured article card */
        @keyframes floatCard {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(0.5deg); }
        }
        .featured-card {
            animation: floatCard 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="flex h-screen w-screen font-sans antialiased text-gray-800">

    {{-- ==========================================================================
       🎨 LEFT SIDE: DARK CANVAS WITH ONE FEATURED LATEST NEWS CARD
       ========================================================================== --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-gray-900 via-slate-900 to-red-950 relative items-center justify-center p-12 overflow-hidden border-r border-gray-800 z-10">
        
        {{-- Interactive Canvas: Floating Alphabets Following Cursor --}}
        <canvas id="literacyCanvas" class="absolute inset-0 z-10 pointer-events-none"></canvas>

        <div class="z-20 max-w-md space-y-6 relative flex flex-col items-start">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-500/10 border border-red-500/30 rounded-full text-red-400 text-xs font-bold uppercase tracking-wider">
                <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                Latest Update
            </div>

            {{-- 📰 SINGLE FEATURED ARTICLE LOOP CARD (Ambil 1 Berita Terbaru) --}}
            @foreach($articles->take(1) as $item)
                <div class="featured-card w-full bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-2xl space-y-4 transition duration-300 hover:bg-white/10">
                    
                    {{-- Thumbnail Img --}}
                    <div class="w-full h-44 bg-gray-950/40 rounded-xl overflow-hidden relative border border-white/5">
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" class="w-full h-full object-cover" alt="Featured News Thumbnail">
                        @else
                            <div class="w-full h-full bg-gradient-to-tr from-red-600/40 to-amber-600/40 flex items-center justify-center p-4 text-center">
                                <span class="text-xs text-white font-black uppercase tracking-wider line-clamp-2">{{ $item->title }}</span>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 bg-red-600 text-white text-[9px] px-2.5 py-0.5 rounded-md font-bold uppercase tracking-widest shadow-sm">
                            {{ $item->source ?? 'FIYA NEWS' }}
                        </span>
                    </div>

                    {{-- Title & Info --}}
                    <div class="space-y-2">
                        <h4 class="text-base font-bold text-white line-clamp-2 leading-snug">
                            {{ $item->title }}
                        </h4>
                        
                        <div class="flex items-center gap-3 pt-2.5 border-t border-white/5 text-[11px] text-gray-400 font-medium">
                            <span class="flex items-center gap-1">✍️ {{ Str::limit($item->author ?? 'Unknown', 15) }}</span>
                            <span>•</span>
                            <span class="flex items-center gap-1">📅 {{ $item->created_at ? $item->created_at->format('M d, Y') : '-' }}</span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Watermark Text --}}
        <div class="absolute bottom-6 left-6 text-[10px] font-mono text-gray-600 tracking-widest z-20">
            FIYANEWS.
        </div>
    </div>


    {{-- ==========================================================================
       📝 RIGHT SIDE: CLEAN, SPACIOUS WHITE LOGIN PANEL
       ========================================================================== --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white relative z-20">
        
        <div class="w-full max-w-sm space-y-8">
            
            {{-- Header Form --}}
            <div class="space-y-2">
                <a href="/" class="inline-block text-2xl font-black tracking-tight text-gray-900 group">
                    <span class="text-red-600 group-hover:text-red-700 transition">FIYA</span> NEWS<span class="text-red-600">.</span>
                </a>
                <h3 class="text-xl font-bold text-gray-900 tracking-tight">Access Your Dashboard</h3>
                <p class="text-xs text-gray-500 font-medium">MASUKKKKK</p>
            </div>

            {{-- FORM LOGIN REAL LARAVEL --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Input Email --}}
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-bold text-gray-700 tracking-wide block">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="journalist@fiyanews.com"
                           class="editorial-input w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-gray-900 placeholder-gray-400 focus:outline-none">
                    @error('email')
                        <p class="text-[11px] font-semibold text-red-600 mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Password --}}
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-xs font-bold text-gray-700 tracking-wide block">Password</label>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           placeholder="••••••••"
                           class="editorial-input w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-sm text-gray-900 placeholder-gray-400 focus:outline-none">
                    @error('password')
                        <p class="text-[11px] font-semibold text-red-600 mt-1">⚠️ {{ $message }}</p>
                    @enderror
                    @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-red-600 hover:underline">Forgot Password?</a>
                        @endif
                </div>

                {{-- Remember Me Option --}}
                <div class="flex items-center pt-1">
                    <input id="remember_me" type="checkbox" name="remember" 
                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500 accent-red-600">
                    <label for="remember_me" class="ml-2 text-xs font-medium text-gray-600 select-none">Remember this device</label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                        class="w-full bg-gray-900 hover:bg-red-600 text-white font-bold py-3.5 px-4 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] cursor-pointer flex items-center justify-center gap-2">
                    Log In
                </button>
            </form>

            {{-- Footer Register Link --}}
            <div class="text-center pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500 font-medium">
                    Don't have an editor account? 
                    <a href="{{ route('register') }}" class="text-red-600 font-bold hover:underline">Register New Account</a>
                </p>
            </div>

        </div>
    </div>

    {{-- ==========================================================================
       ✨ CANVAS SCRIPT: LITERACY TEXT PARTICLES (Left Canvas Cursor Gravity)
       ========================================================================== --}}
    <script>
        const canvas = document.getElementById('literacyCanvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let mouse = { x: null, y: null };
            let particles = [];
            const particleCount = 40; 
            const chars = "BUNNY".split("");

            function resize() {
                canvas.width = canvas.parentElement.clientWidth;
                canvas.height = canvas.parentElement.clientHeight;
            }
            window.addEventListener('resize', resize);
            resize();

            // Menangkap pergerakan mouse eksklusif di area gelap sebelah kiri
            canvas.parentElement.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                mouse.x = e.clientX - rect.left;
                mouse.y = e.clientY - rect.top;
            });

            canvas.parentElement.addEventListener('mouseleave', () => {
                mouse.x = null;
                mouse.y = null;
            });

            class TextParticle {
                constructor() { this.reset(); }
                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.char = chars[Math.floor(Math.random() * chars.length)];
                    this.fontSize = Math.random() * 14 + 10;
                    this.vx = (Math.random() - 0.5) * 0.4;
                    this.vy = (Math.random() - 0.5) * 0.4;
                    this.alpha = Math.random() * 0.2 + 0.05; 
                }
                update() {
                    if (mouse.x !== null) {
                        let dx = mouse.x - this.x;
                        let dy = mouse.y - this.y;
                        let distance = Math.sqrt(dx * dx + dy * dy);
                        if (distance < 200) {
                            let force = (200 - distance) / 200;
                            this.vx += (dx / distance) * force * 0.05;
                            this.vy += (dy / distance) * force * 0.05;
                        }
                    }
                    this.x += this.vx; this.y += this.vy;
                    this.vx *= 0.98; this.vy *= 0.98;
                    if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) { this.reset(); }
                }
                draw() {
                    ctx.save();
                    ctx.fillStyle = `rgba(255, 255, 255, ${this.alpha})`;
                    ctx.font = `bold ${this.fontSize}px monospace`;
                    ctx.fillText(this.char, this.x, this.y);
                    ctx.restore();
                }
            }

            for (let i = 0; i < particleCount; i++) { particles.push(new TextParticle()); }
            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => { p.update(); p.draw(); });
                requestAnimationFrame(animate);
            }
            animate();
        }
    </script>
</body>
</html>