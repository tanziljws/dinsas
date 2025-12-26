<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perjalanan_dinas', function (Blueprint $table) {
            $table->text('alasan_ditolak')->nullable()->after('status');
        });

        // Update existing status values to new format
        DB::table('perjalanan_dinas')->where('status', 'Belum Dicek')->update(['status' => 'Terkirim']);
        DB::table('perjalanan_dinas')->where('status', 'Sedang Diproses')->update(['status' => 'Diproses']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perjalanan_dinas', function (Blueprint $table) {
            $table->dropColumn('alasan_ditolak');
        });

        // Revert status values
        DB::table('perjalanan_dinas')->where('status', 'Terkirim')->update(['status' => 'Belum Dicek']);
        DB::table('perjalanan_dinas')->where('status', 'Diproses')->update(['status' => 'Sedang Diproses']);
    }
};
