<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Menampilkan halaman daftar user
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    // 2. Memproses simpan akun baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,mandor,owner',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun baru berhasil didaftarkan ke sistem!');
    }

    // 3. Menampilkan form edit user (mengambil data user berdasarkan ID)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $users = User::orderBy('id', 'desc')->get(); // Tetap ambil daftar user untuk tabel di bawah/samping

        return view('admin.users', compact('user', 'users'));
    }

    // 4. Memproses update data akun yang diubah
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8', // Password opsional, diisi jika ingin diganti saja
            'role' => 'required|in:admin,mandor,owner',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Jika password baru diisi, enkripsi dan update
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data akun berhasil diperbarui!');
    }

    // 5. Memproses hapus akun dari database
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah Admin menghapus akun dirinya sendiri yang sedang login
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus dari sistem!');
    }
}
