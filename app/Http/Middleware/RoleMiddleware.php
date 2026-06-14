<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah pengguna sudah login atau belum
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil data role dari pengguna yang sedang login
        $userRole = Auth::user()->role;

        // 3. JIKA role pengguna TIDAK ADA di dalam daftar izin, langsung blokir 403
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        // 4. Jika punya izin, silakan lanjut ke halaman tujuan
        return $next($request);
    }
}
