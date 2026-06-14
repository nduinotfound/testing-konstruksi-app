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
        Schema::create('absen_pekerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained()->onDelete('cascade');
            $table->string('nama_pekerja');
            $table->enum('status_kehadiran', ['hadir', 'izin', 'alfa'])->default('hadir');
            $table->date('tanggal'); // Otomatis diisi tanggal hari ini oleh backend
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Otomatis ID Mandor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_pekerjas');
    }
};
