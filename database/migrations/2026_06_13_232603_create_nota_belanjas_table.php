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
        Schema::create('nota_belanjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // Mandor yang membeli
            $table->date('tanggal');
            $table->string('nama_barang'); // Contoh: "Semen Padang"
            $table->integer('jumlah'); // Contoh: 50
            $table->string('satuan'); // Contoh: "Sak"
            $table->decimal('total_harga', 12, 2); // Contoh: 3500000.00
            $table->string('foto_nota'); // Bukti struk/nota fisik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_belanjas');
    }
};
