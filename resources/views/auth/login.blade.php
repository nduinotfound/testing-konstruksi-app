<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Logistik Konstruksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased min-h-screen flex flex-col justify-center py-0 sm:py-0">

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-12 bg-white">

        <div class="hidden md:flex md:col-span-5 lg:col-span-6 bg-slate-900 relative items-center justify-center p-12 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700/40 via-slate-900 to-slate-950 z-10"></div>
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>

            <div class="relative z-20 max-w-md text-left space-y-6">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center font-black text-xl text-white tracking-wider shadow-lg shadow-blue-600/30">
                    K
                </div>
                <div class="space-y-2">
                    <h1 class="text-3xl font-black text-white tracking-tight leading-tight">
                        Sistem Pemantauan Infrastruktur & Logistik
                    </h1>
                    <p class="text-sm text-slate-400 font-medium leading-relaxed">
                        Integrasi data lapangan murni antara Mandor, Admin, dan Owner secara real-time demi efisiensi operasional proyek.
                    </p>
                </div>

                <div class="inline-flex items-center space-x-2 bg-white/5 border border-white/10 px-3 py-1.5 rounded-xl">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-mono font-black text-slate-300 uppercase tracking-wider">Production Build v2.1</span>
                </div>
            </div>
        </div>

        <div class="col-span-1 md:col-span-7 lg:col-span-6 flex items-center justify-center p-6 sm:p-12 md:p-16 bg-gray-50/50">
            <div class="w-full max-w-sm space-y-8 bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50">

                <div>
                    <div class="md:hidden w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-black text-sm text-white tracking-wider mb-4 shadow-md">
                        K
                    </div>
                    <h2 class="text-xl font-black text-gray-800 tracking-tight">Selamat Datang</h2>
                    <p class="text-xs text-gray-400 mt-1">Silakan masukkan kredensial akun Anda untuk mengakses ruang kerja.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200/60 rounded-xl p-4 text-xs font-semibold text-red-600 animate-fadeIn">
                        <ul class="list-disc pl-3 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="block text-xs font-black text-gray-700 uppercase tracking-wider">Alamat Email Resmi</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@konstruksi.com"
                                   class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl pl-11 pr-4 py-3.5 text-xs font-bold text-gray-800 outline-none transition placeholder-gray-400">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-black text-gray-700 uppercase tracking-wider">Kata Sandi Akun</label>
                        </div>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            <input type="password" id="password" name="password" required placeholder="••••••••"
                                   class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl pl-11 pr-4 py-3.5 text-xs font-bold text-gray-800 outline-none transition placeholder-gray-400">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 bg-gray-50 transition cursor-pointer">
                            <span class="ml-2 text-[11px] font-bold text-gray-400">Ingat sesi masuk saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-xs tracking-wider uppercase py-4 rounded-xl shadow-lg shadow-blue-600/20 active:scale-98 transition duration-150 mt-2">
                        Masuk Ke Ruang Kerja
                    </button>
                </form>

                <div class="text-center pt-4 border-t border-gray-50">
                    <p class="text-[10px] text-gray-400 font-semibold tracking-wide">&copy; {{ date('Y') }} PT. Barkha Cipta Karya.</p>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
