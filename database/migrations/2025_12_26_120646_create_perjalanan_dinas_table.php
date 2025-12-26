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
        Schema::create('perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->cascadeOnDelete();
            $table->string('nama_pengikut1')->nullable();
            $table->string('nama_pengikut2')->nullable();
            $table->string('nama_pengikut3')->nullable();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_berangkat');
            $table->enum('jenis', ['Dalam Kota', 'Luar Kota']);
            $table->string('lama');
            $table->text('nama_kegiatan');
            $table->string('nama_instansi');
            $table->text('alamat_instansi');
            $table->string('file_path');
            $table->enum('status', ['Belum Dicek', 'Sedang Diproses', 'Disetujui', 'Ditolak'])->default('Belum Dicek');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas');
    }
};
