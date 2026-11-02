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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')
                  ->constrained('karyawans')
                  ->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', [
                'Hadir',
                'Terlambat',
                'Izin',
                'Sakit',
                'Cuti',
                'Alpa'
            ])->default('Hadir');
            $table->decimal('jam_lembur', 4, 1)->default(0);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('jarak_meter')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['karyawan_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
