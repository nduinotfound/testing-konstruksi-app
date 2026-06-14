<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('nota_belanjas', function (Blueprint $table) {
            // Mengubah kolom-kolom lama menjadi nullable agar aman, atau langsung drop jika mau
            $table->string('nama_barang')->nullable()->change();
            $table->integer('jumlah')->nullable()->change();
            $table->string('satuan')->nullable()->change();
            $table->decimal('total_harga', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
