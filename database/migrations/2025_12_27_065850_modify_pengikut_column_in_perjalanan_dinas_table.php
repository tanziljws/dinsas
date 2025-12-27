<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perjalanan_dinas', function (Blueprint $table) {
            $table->dropColumn(['nama_pengikut1', 'nama_pengikut2', 'nama_pengikut3']);
            $table->json('pengikut')->nullable()->after('guru_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perjalanan_dinas', function (Blueprint $table) {
            $table->dropColumn('pengikut');
            $table->string('nama_pengikut1')->nullable();
            $table->string('nama_pengikut2')->nullable();
            $table->string('nama_pengikut3')->nullable();
        });
    }
};
