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
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('pin', 10)->default('1234')->after('status');
            $table->integer('sisa_cuti')->default(12)->after('pin');
        });

        Schema::table('penggajians', function (Blueprint $table) {
            $table->enum('status_approval', ['Draft', 'Menunggu Persetujuan', 'Disetujui'])->default('Disetujui')->after('tanggal_gaji');
            $table->integer('hari_kerja_efektif')->default(22)->after('status_approval');
            $table->integer('total_hadir')->default(0)->after('hari_kerja_efektif');
            $table->integer('total_sakit')->default(0)->after('total_hadir');
            $table->integer('total_izin')->default(0)->after('total_sakit');
            $table->integer('total_alpa')->default(0)->after('total_izin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn(['pin', 'sisa_cuti']);
        });

        Schema::table('penggajians', function (Blueprint $table) {
            $table->dropColumn([
                'status_approval',
                'hari_kerja_efektif',
                'total_hadir',
                'total_sakit',
                'total_izin',
                'total_alpa'
            ]);
        });
    }
};
