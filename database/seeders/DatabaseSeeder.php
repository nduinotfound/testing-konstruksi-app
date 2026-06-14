<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan data lama terlebih dahulu agar tidak duplikat saat seeding
        config(['database.connections.mysql.strict' => false]); // Amankan query truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \App\Models\User::truncate();
        DB::table('proyeks')->truncate();
        DB::table('pengeluarans')->truncate(); // Bersihkan juga tabel pengeluaran baru, Ndut!

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Membuat Akun Pengguna Sistem (Admin, Mandor, Owner)
        $admin = \App\Models\User::create([
            'name' => 'Aulia Admin',
            'email' => 'admin@konstruksi.com',
            'password' => Hash::make('password123'), // Password aman: password123
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Randu Mandor',
            'email' => 'mandor@konstruksi.com',
            'password' => Hash::make('password123'),
            'role' => 'mandor',
        ]);

        \App\Models\User::create([
            'name' => 'Arini Owner',
            'email' => 'owner@konstruksi.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
        ]);

        // 3. Membuat Data Proyek Contoh
        DB::table('proyeks')->insert([
            [
                'id' => 1,
                'nama_proyek' => 'Pembangunan Gedung Laboratorium Komputer',
                'lokasi' => 'Kampus Utama, Gedung B',
                'tanggal_mulai' => '2026-06-01',
                'deadline' => '2026-12-31',
                'status' => 'berjalan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_proyek' => 'Renovasi Aula Pertemuan Utama',
                'lokasi' => 'Sayap Kiri Kampus',
                'tanggal_mulai' => '2026-07-15',
                'deadline' => '2026-10-15',
                'status' => 'perencanaan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 4. Guyur Data Dummy Pengeluaran Multi-Material untuk Proyek ID 1
        // Format simulasi: (Qty * Harga Satuan) + PPN = Harga Total
        DB::table('pengeluarans')->insert([
            [
                'proyek_id' => 1,
                'tipe_pengeluaran' => 'Logistik Material',
                'tanggal' => '2026-06-10',
                'nama_material' => 'Semen Padang PCC',
                'qty' => 50,
                'satuan' => 'Sak',
                'harga_satuan' => 65000,
                'ppn' => 357500, // Contoh PPN diinput manual
                'harga_total' => 3607500, // (50 * 65.000) + 357.500
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'proyek_id' => 1,
                'tipe_pengeluaran' => 'Logistik Material',
                'tanggal' => '2026-06-12',
                'nama_material' => 'Besi Beton 12mm',
                'qty' => 20,
                'satuan' => 'Btg',
                'harga_satuan' => 110000,
                'ppn' => 0, // Simulasi non-PPN
                'harga_total' => 2200000, // (20 * 110.000) + 0
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'proyek_id' => 1,
                'tipe_pengeluaran' => 'Sewa Alat Berat',
                'tanggal' => '2026-06-14',
                'nama_material' => 'Sewa Molen Beton (Harian)',
                'qty' => 2,
                'satuan' => 'Unit',
                'harga_satuan' => 250000,
                'ppn' => 55000,
                'harga_total' => 555000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
