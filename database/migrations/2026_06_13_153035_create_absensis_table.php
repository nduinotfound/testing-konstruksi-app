<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained('proyeks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID Mandor yang absen
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->enum('status', ['hadir', 'izin', 'sakit'])->default('hadir');
            $table->string('foto_selfie')->nullable(); // Bukti foto selfie mandor di lokasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
