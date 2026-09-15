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
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('bulan');
            $table->year('tahun');
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('tunjangan', 15, 2);
            $table->integer('jam_lembur')->default(0);
            $table->decimal('total_lembur', 15, 2)->default(0);
            $table->decimal('total_pendapatan', 15, 2);
            $table->decimal('total_potongan', 15, 2)->default(0);
            $table->decimal('thp', 15, 2);
            $table->date('tanggal_gaji');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};