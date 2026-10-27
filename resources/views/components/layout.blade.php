@props(['title' => 'RuteSales'])

<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - RuteSales</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js for lightweight UI interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    
    <!-- Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="h-full antialiased text-slate-800" x-data="{ mobileMenuOpen: false }">

<div class="min-h-full flex flex-col md:flex-row">
    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 bg-slate-900 border-r border-slate-800 z-30">
        <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
            <!-- App Brand Logo -->
            <div class="flex items-center gap-3 px-6 pb-6 border-b border-slate-800">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-white tracking-tight">Rute<span class="text-blue-400">Sales</span></h1>
                    <p class="text-[11px] text-slate-400 font-medium">Monitoring Kunjungan</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="mt-6 flex-grow flex flex-col px-4 space-y-1.5">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard Admin
                </a>

                <a href="{{ route('rute.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('rute.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Rute Kunjungan
                </a>

                <a href="{{ route('stores.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('stores.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Daftar Toko / Warung
                </a>

                <a href="{{ route('sales.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('sales.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Tim Sales & Admin
                </a>

                <div class="pt-4 pb-2 px-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Demo Rute Langsung</p>
                </div>

                <a href="{{ url('/rute/detail/1') }}" 
                   class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-blue-300 transition-all border border-dashed border-slate-700/60">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    URI: /rute/detail/1
                </a>
            </div>

            <!-- User Status / Quick Switcher in Sidebar -->
            <div class="px-4 mt-auto pt-4 border-t border-slate-800">
                <div class="bg-slate-800/80 rounded-xl p-3 border border-slate-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white font-bold flex items-center justify-center text-xs">
                                {{ auth()->check() ? substr(auth()->user()->name, 0, 1) : 'G' }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs font-bold text-white truncate">{{ auth()->check() ? auth()->user()->name : 'Tamu (Evaluator)' }}</p>
                                <p class="text-[10px] text-blue-400 capitalize font-medium">{{ auth()->check() ? auth()->user()->role : 'Mode Akses Cepat' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Switcher Buttons -->
                    <div class="mt-2.5 pt-2 border-t border-slate-700/60 flex items-center justify-between text-[11px] text-slate-300">
                        <span class="text-slate-400 text-[10px]">Pindah:</span>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('quick.login', 1) }}" title="Login Admin" class="px-1.5 py-0.5 rounded bg-slate-700 hover:bg-blue-600 text-white text-[10px] transition-colors">Admin</a>
                            <a href="{{ route('quick.login', 2) }}" title="Login Sales 1" class="px-1.5 py-0.5 rounded bg-slate-700 hover:bg-emerald-600 text-white text-[10px] transition-colors">Sales 1</a>
                            <a href="{{ route('quick.login', 3) }}" title="Login Sales 2" class="px-1.5 py-0.5 rounded bg-slate-700 hover:bg-emerald-600 text-white text-[10px] transition-colors">Sales 2</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Top Navigation Bar -->
    <header class="md:hidden bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-40">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <span class="font-bold text-white text-base">Rute<span class="text-blue-400">Sales</span></span>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs bg-slate-800 text-blue-400 px-2.5 py-1 rounded-full font-medium">
                    {{ auth()->check() ? auth()->user()->role : 'Demo' }}
                </span>
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="border-t border-slate-800 px-4 py-3 space-y-2 bg-slate-900">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:bg-slate-800">Dashboard</a>
            <a href="{{ route('rute.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:bg-slate-800">Rute Kunjungan</a>
            <a href="{{ route('stores.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:bg-slate-800">Data Toko</a>
            <a href="{{ route('sales.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:bg-slate-800">Tim Sales</a>
            <div class="pt-2 border-t border-slate-800 flex items-center gap-2">
                <span class="text-xs text-slate-400">Pindah Akun:</span>
                <a href="{{ route('quick.login', 1) }}" class="text-xs bg-blue-600 px-2 py-1 rounded text-white font-medium">Admin</a>
                <a href="{{ route('quick.login', 2) }}" class="text-xs bg-emerald-600 px-2 py-1 rounded text-white font-medium">Sales 1</a>
                <a href="{{ route('quick.login', 3) }}" class="text-xs bg-emerald-600 px-2 py-1 rounded text-white font-medium">Sales 2</a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <div class="flex-1 md:pl-64 flex flex-col min-h-screen">
        <!-- Top App Bar for Desktop -->
        <div class="hidden md:flex items-center justify-between bg-white border-b border-slate-200 px-8 py-4 sticky top-0 z-20 shadow-xs">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">{{ $title }}</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Role Switcher Quick Pill -->
                <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl text-xs font-semibold text-slate-600">
                    <span class="px-2 text-slate-400">Beralih Role:</span>
                    <a href="{{ route('quick.login', 1) }}" class="px-2.5 py-1 rounded-lg {{ auth()->id() == 1 ? 'bg-blue-600 text-white shadow-xs' : 'hover:bg-white text-slate-700' }}">Admin</a>
                    <a href="{{ route('quick.login', 2) }}" class="px-2.5 py-1 rounded-lg {{ auth()->id() == 2 ? 'bg-blue-600 text-white shadow-xs' : 'hover:bg-white text-slate-700' }}">Sales Budi</a>
                    <a href="{{ route('quick.login', 3) }}" class="px-2.5 py-1 rounded-lg {{ auth()->id() == 3 ? 'bg-blue-600 text-white shadow-xs' : 'hover:bg-white text-slate-700' }}">Sales Siti</a>
                </div>

                @if(auth()->check())
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 px-3 py-1.5 rounded-lg transition-colors border border-rose-200">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-200">
                        Masuk
                    </a>
                @endif
            </div>
        </div>

        <!-- Main Page Body -->
        <main class="flex-1 p-4 sm:p-6 md:p-8 max-w-7xl w-full mx-auto pb-24 md:pb-12">
            <!-- Global Flash & Validation Alerts -->
            <x-alert />

            <!-- Page Content -->
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="mt-auto border-t border-slate-200 bg-white py-4 px-6 text-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} <strong>RuteSales</strong> - Sistem Pemantauan Kunjungan Sales Lapangan (Laravel 11 &amp; Blade).</p>
        </footer>
    </div>
</div>

<!-- Mobile Bottom Navigation Bar -->
<div class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-slate-200 px-4 py-2 z-30 shadow-lg">
    <div class="grid grid-cols-4 gap-1 text-center">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('dashboard') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[10px] mt-0.5">Home</span>
        </a>

        <a href="{{ route('rute.index') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('rute.*') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <span class="text-[10px] mt-0.5">Rute</span>
        </a>

        <a href="{{ route('stores.index') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('stores.*') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span class="text-[10px] mt-0.5">Toko</span>
        </a>

        <a href="{{ route('sales.index') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('sales.*') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="text-[10px] mt-0.5">Sales</span>
        </a>
    </div>
</div>

</body>
</html>

