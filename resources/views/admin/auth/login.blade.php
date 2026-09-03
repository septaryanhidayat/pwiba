<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - PWI Banyuasin</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Anti-FOUC Theme Initializer (Default: Light Mode) -->
    <script>
        if (localStorage.getItem('pwi_theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            background-image: 
                radial-gradient(at 0% 0%, hsla(217,91%,90%,0.8) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(217,91%,95%,0.8) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(38,92%,90%,0.5) 0, transparent 50%),
                radial-gradient(at 50% 100%, hsla(217,91%,90%,0.8) 0, transparent 50%);
        }
        .dark body {
            background-color: #0B132B;
            background-image: 
                radial-gradient(at 0% 0%, hsla(222,47%,11%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(217,91%,25%,0.5) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(38,92%,50%,0.25) 0, transparent 50%),
                radial-gradient(at 50% 100%, hsla(222,47%,11%,1) 0, transparent 50%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 text-slate-800 dark:text-slate-100 antialiased transition-colors duration-200" 
      x-data="{ 
          showPass: false,
          isDark: document.documentElement.classList.contains('dark'),
          toggleTheme() {
              this.isDark = !this.isDark;
              if (this.isDark) {
                  document.documentElement.classList.add('dark');
                  localStorage.setItem('pwi_theme', 'dark');
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.setItem('pwi_theme', 'light');
              }
          }
      }">

    <!-- Top Right Theme Toggle -->
    <div class="fixed top-6 right-6 z-50">
        <button @click="toggleTheme()" 
                type="button" 
                class="p-3 rounded-2xl border border-slate-200 dark:border-white/15 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md text-slate-700 dark:text-amber-400 shadow-lg hover:scale-105 transition-all cursor-pointer flex items-center justify-center"
                :title="isDark ? 'Ganti ke Mode Terang (Light Mode)' : 'Ganti ke Mode Gelap (Dark Mode)'"
                aria-label="Toggle Theme">
            <i class="fa-solid fa-sun text-base text-amber-400" x-show="isDark" x-cloak></i>
            <i class="fa-solid fa-moon text-base text-slate-700" x-show="!isDark"></i>
        </button>
    </div>

    <div class="w-full max-w-md">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-white dark:bg-white/10 p-3.5 ring-1 ring-slate-200 dark:ring-white/20 shadow-2xl backdrop-blur-md mb-4 hover:scale-105 transition-transform">
                <img src="{{ asset('assets/images/pwi-logo.png') }}" alt="Logo PWI" class="w-full h-full object-contain">
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Portal Sistem Informasi MIS</h1>
            <p class="text-xs text-amber-600 dark:text-amber-400 font-bold mt-1 uppercase tracking-wider">Persatuan Wartawan Indonesia Banyuasin</p>
        </div>

        <!-- Login Card Glassmorphism -->
        <div class="bg-white/90 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/80 dark:border-white/10 rounded-3xl p-8 sm:p-10 shadow-2xl space-y-6">
            
            <div class="border-b border-slate-200 dark:border-slate-800 pb-4">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Login Autentikasi</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Masukkan email dan kata sandi admin Anda</p>
            </div>

            @if($errors->any())
                <div class="p-3.5 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1.5">Email Administrator *</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email', 'admin@pwibanyuasin.or.id') }}" required class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-800 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-slate-400 dark:text-slate-500 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1.5">Kata Sandi / Password *</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" required class="w-full pl-10 pr-10 py-3 rounded-xl bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-800 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none" placeholder="••••••••">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400 dark:text-slate-500 text-xs"></i>
                        <button type="button" @click="showPass = !showPass" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-700 dark:hover:text-white text-xs">
                            <i class="fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="rounded bg-slate-100 dark:bg-slate-950 border-slate-300 dark:border-slate-800 text-amber-500 focus:ring-amber-500">
                        <span>Ingat Saya</span>
                    </label>
                    <span class="text-slate-400 dark:text-slate-500 text-[11px]">Kredensial Default Tertera</span>
                </div>

                <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-400/20 transition-all flex items-center justify-center gap-2 text-sm mt-2 cursor-pointer">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 text-center">
                <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Website Publik</span>
                </a>
            </div>

        </div>

    </div>

</body>
</html>

