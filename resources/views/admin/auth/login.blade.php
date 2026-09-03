<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - PWI Kabupaten Banyuasin</title>

    <!-- Favicon Resmi PWI Banyuasin -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/pwi-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

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
                    colors: {
                        pwi: {
                            navy: '#0B132B',
                            dark: '#1C2541',
                            blue: '#1E3A8A',
                            accent: '#F59E0B',
                            gold: '#D97706',
                        }
                    },
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
            background-color: #0B132B;
        }
        .login-mesh {
            background-color: #070D1E;
            background-image: 
                radial-gradient(at 0% 0%, hsla(222,47%,16%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(38,92%,50%,0.15) 0, transparent 45%), 
                radial-gradient(at 50% 50%, hsla(217,91%,20%,0.3) 0, transparent 60%),
                radial-gradient(at 0% 100%, hsla(222,47%,12%,1) 0, transparent 50%),
                radial-gradient(at 100% 100%, hsla(217,91%,25%,0.25) 0, transparent 50%);
        }
        .login-mesh-light {
            background-color: #F8FAFC;
            background-image: 
                radial-gradient(at 0% 0%, hsla(217,91%,92%,0.9) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(38,92%,90%,0.7) 0, transparent 45%), 
                radial-gradient(at 50% 50%, hsla(217,91%,96%,0.8) 0, transparent 60%),
                radial-gradient(at 0% 100%, hsla(217,91%,92%,0.8) 0, transparent 50%),
                radial-gradient(at 100% 100%, hsla(38,92%,92%,0.6) 0, transparent 50%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
        .dark .glass-card {
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .text-gradient-gold {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        @keyframes subtleFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: subtleFloat 5s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased transition-colors duration-300 text-slate-800 dark:text-slate-100"
      :class="isDark ? 'login-mesh' : 'login-mesh-light'"
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

    <!-- Ambient Glowing Blobs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/15 dark:bg-blue-600/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-amber-500/15 dark:bg-amber-500/15 rounded-full blur-3xl"></div>
    </div>

    <!-- Top Navigation Bar (Logo Link + Quick Actions) -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-white dark:bg-white/10 p-1.5 ring-1 ring-slate-200 dark:ring-white/20 shadow-md group-hover:scale-105 transition-transform flex items-center justify-center">
                <img src="{{ asset('assets/images/pwi-logo.webp') }}" alt="Logo PWI" width="32" height="32" class="w-full h-full object-contain" onerror="this.src='{{ asset('assets/images/pwi-logo.png') }}'">
            </div>
            <div class="flex flex-col">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-600 dark:text-amber-400">Portal Resmi</span>
                <span class="text-sm font-black tracking-tight text-slate-900 dark:text-white leading-tight">PWI BANYUASIN</span>
            </div>
        </a>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-white/70 dark:bg-slate-900/60 hover:bg-white dark:hover:bg-slate-800 border border-slate-200/80 dark:border-white/10 shadow-sm backdrop-blur-md transition-all">
                <i class="fa-solid fa-house text-xs text-amber-500"></i>
                <span>Ke Website Publik</span>
            </a>

            <!-- Dark / Light Theme Toggle -->
            <button @click="toggleTheme()" 
                    type="button" 
                    class="p-2.5 rounded-xl border border-slate-200/80 dark:border-white/15 bg-white/70 dark:bg-slate-900/60 hover:bg-white dark:hover:bg-slate-800 backdrop-blur-md text-slate-700 dark:text-amber-400 shadow-sm hover:scale-105 transition-all cursor-pointer flex items-center justify-center"
                    :title="isDark ? 'Ganti ke Mode Terang' : 'Ganti ke Mode Gelap'"
                    aria-label="Toggle Theme">
                <i class="fa-solid fa-sun text-sm text-amber-400" x-show="isDark" x-cloak></i>
                <i class="fa-solid fa-moon text-sm text-slate-700" x-show="!isDark"></i>
            </button>
        </div>
    </header>

    <!-- Main Content: Login Form Card -->
    <main class="relative z-10 flex-grow flex items-center justify-center px-4 py-8 sm:py-12">
        <div class="w-full max-w-md">
            
            <!-- Glassmorphism Card -->
            <div class="glass-card rounded-3xl shadow-2xl overflow-hidden transition-all duration-300">
                
                <!-- Top Vibrant Accent Bar (PWI Blue to Gold) -->
                <div class="h-2 w-full bg-gradient-to-r from-blue-700 via-indigo-600 to-amber-500"></div>

                <div class="p-8 sm:p-10 space-y-6">
                    
                    <!-- Card Header with Official Emblem -->
                    <div class="text-center space-y-3">
                        <div class="inline-flex relative">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 p-2.5 shadow-xl ring-1 ring-slate-200 dark:ring-white/15 flex items-center justify-center animate-float">
                                <img src="{{ asset('assets/images/pwi-logo.webp') }}" alt="PWI Logo" width="56" height="56" class="w-full h-full object-contain" onerror="this.src='{{ asset('assets/images/pwi-logo.png') }}'">
                            </div>
                            <span class="absolute -bottom-1 -right-1 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500 border-2 border-white dark:border-slate-900"></span>
                            </span>
                        </div>

                        <div>
                            <h1 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                                Login Sistem MIS
                            </h1>
                            <p class="text-xs font-semibold text-amber-600 dark:text-amber-400 uppercase tracking-wider mt-1">
                                Pengurus PWI Kabupaten Banyuasin
                            </p>
                        </div>

                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800/80 text-[11px] font-medium text-blue-700 dark:text-blue-300">
                            <i class="fa-solid fa-shield-halved text-[10px] text-emerald-500"></i>
                            <span>Portal Autentikasi Terenkripsi SSL 256-bit</span>
                        </div>
                    </div>

                    <!-- Error Alert -->
                    @if($errors->any())
                        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs font-semibold flex items-start gap-3">
                            <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0 text-sm"></i>
                            <div>
                                <span class="font-bold block">Gagal Melakukan Autentikasi:</span>
                                <span>{{ $errors->first() }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-4 pt-1">
                        @csrf

                        <!-- Email Input -->
                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Isikan Email Anda
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </div>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus
                                       placeholder="email@anda.com" 
                                       autocomplete="email"
                                       class="w-full pl-10 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-950/70 border border-slate-300 dark:border-slate-800 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 outline-none transition-all shadow-sm">
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Kata Sandi Akun
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input :type="showPass ? 'text' : 'password'" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       placeholder="Masukkan kata sandi..." 
                                       autocomplete="current-password"
                                       class="w-full pl-10 pr-11 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-950/70 border border-slate-300 dark:border-slate-800 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 outline-none transition-all shadow-sm">
                                <button type="button" 
                                        @click="showPass = !showPass" 
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 dark:hover:text-white transition-colors cursor-pointer"
                                        aria-label="Lihat / Sembunyikan Sandi"
                                        title="Lihat / Sembunyikan Sandi">
                                    <i class="fa-regular" :class="showPass ? 'fa-eye-slash text-amber-500' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Security Badge (Cleaned - No Default Credentials Hint) -->
                        <div class="flex items-center justify-between text-xs pt-1">
                            <label class="flex items-center gap-2 text-slate-600 dark:text-slate-400 cursor-pointer select-none">
                                <input type="checkbox" 
                                       name="remember" 
                                       class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-amber-500 focus:ring-amber-400 focus:ring-offset-0 bg-slate-100 dark:bg-slate-900 cursor-pointer">
                                <span class="font-medium">Ingat Sesi Saya</span>
                            </label>
                            
                            <span class="text-[11px] font-semibold text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                <i class="fa-solid fa-lock text-[10px] text-amber-500"></i>
                                <span>Akses Khusus</span>
                            </span>
                        </div>

                        <!-- Submit Button (Vibrant Gold Gradient) -->
                        <button type="submit" 
                                class="w-full py-4 px-6 rounded-xl font-black text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 text-sm mt-3 cursor-pointer">
                            <span>Masuk ke Dashboard Sistem</span>
                            <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                        </button>
                    </form>

                    <!-- Footer Link inside Card -->
                    <div class="pt-5 border-t border-slate-200/80 dark:border-slate-800 text-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-amber-400 transition-colors group">
                            <i class="fa-solid fa-arrow-left text-[11px] group-hover:-translate-x-1 transition-transform"></i>
                            <span>Kembali ke Halaman Beranda Utama</span>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Security Assurance Note -->
            <p class="text-center text-[11px] text-slate-500 dark:text-slate-400 mt-6 flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-shield-check text-emerald-500"></i>
                <span>Dilindungi Kode Etik Jurnalistik & Regulasi Pers PWI Indonesia</span>
            </p>

        </div>
    </main>

    <!-- Simple Modern Footer -->
    <footer class="relative z-10 w-full py-4 text-center text-xs text-slate-500 dark:text-slate-400">
    </footer>

    <!-- SweetAlert2 Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Informasi',
                text: {!! json_encode(session('success')) !!},
                timer: 3500,
                timerProgressBar: true,
                confirmButtonColor: '#2563eb',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl dark:bg-slate-900 dark:text-white',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-xs shadow-md'
                }
            });
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Perhatian',
                text: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl dark:bg-slate-900 dark:text-white',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-xs shadow-md'
                }
            });
        });
    </script>
    @endif
</body>
</html>
