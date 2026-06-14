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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained()->onDelete('cascade');
            $table->string('tipe_pengeluaran'); // Contoh: Logistik Material, Operasional, Sewa Alat
            $table->date('tanggal');
            $table->string('nama_material');
            $table->integer('qty');
            $table->string('satuan'); // Contoh: Sak, Batang, M3, Kg
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('harga_total', 15, 2);
            $table->decimal('ppn', 15, 2)->default(0); // Nilai nominal PPN nya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
