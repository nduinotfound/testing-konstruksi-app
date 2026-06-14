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
        Schema::create('laporan_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // Mandor yang melapor
            $table->date('tanggal');
            $table->text('keterangan_progres'); // Contoh: "Pemasangan bata lantai 2 selesai 80%"
            $table->string('foto_progres')->nullable(); // Foto dokumentasi proyek
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harians');
    }
};
