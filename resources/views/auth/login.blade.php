<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RuteSales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="h-full flex items-center justify-center p-4">

<div class="max-w-md w-full">
    <!-- Brand Header -->
    <div class="text-center mb-8">
        <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 items-center justify-center text-white shadow-xl shadow-blue-500/30 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
        </div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Rute<span class="text-blue-600">Sales</span></h1>
        <p class="text-xs text-slate-500 mt-1 font-medium">Sistem Pemantauan Rute &amp; Kunjungan Sales Lapangan</p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 p-6 sm:p-8">
        <h2 class="text-lg font-bold text-slate-900 mb-1">Masuk ke Sistem</h2>
        <p class="text-xs text-slate-400 mb-6">Silakan masukkan email dan kata sandi akun Anda.</p>

        @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Email
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', 'admin@rutesales.com') }}" required autofocus
                       placeholder="nama@rutesales.com"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kata Sandi
                </label>
                <input type="password" name="password" id="password" value="password" required
                       placeholder="••••••••"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500">
                    <span class="text-slate-600">Ingat Saya</span>
                </label>
                <span class="text-slate-400">Password default: <code class="text-slate-700 font-bold">password</code></span>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm shadow-md shadow-blue-500/25 transition-all mt-2">
                Masuk ke Aplikasi
            </button>
        </form>

        <!-- Quick 1-Click Demo Login -->
        <div class="mt-6 pt-6 border-t border-slate-100">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center mb-3">
                Atau Masuk Cepat (Demo Akun Pengujian):
            </p>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('quick.login', 1) }}" class="p-2.5 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-200 text-center transition-colors">
                    <span class="block text-xs font-bold text-slate-800">Admin Pusat</span>
                    <span class="block text-[10px] text-blue-600">admin@rutesales.com</span>
                </a>
                <a href="{{ route('quick.login', 2) }}" class="p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-200 text-center transition-colors">
                    <span class="block text-xs font-bold text-slate-800">Sales Budi</span>
                    <span class="block text-[10px] text-emerald-600">sales1@rutesales.com</span>
                </a>
                <a href="{{ route('quick.login', 3) }}" class="p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-200 text-center transition-colors">
                    <span class="block text-xs font-bold text-slate-800">Sales Siti</span>
                    <span class="block text-[10px] text-emerald-600">sales2@rutesales.com</span>
                </a>
                <a href="{{ route('quick.login', 4) }}" class="p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-200 text-center transition-colors">
                    <span class="block text-xs font-bold text-slate-800">Sales Fauzi</span>
                    <span class="block text-[10px] text-emerald-600">sales3@rutesales.com</span>
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
