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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan')->default('PT. Sejahtera Bersama');
            $table->string('email_perusahaan')->default('info@sejahtera.co.id');
            $table->string('telepon')->default('(021) 555-0192');
            $table->text('alamat')->nullable();
            $table->string('npwp')->default('01.234.567.8-012.000');
            $table->string('logo')->nullable();
            $table->string('latitude')->default('-6.2088');
            $table->string('longitude')->default('106.8456');
            $table->integer('radius_meter')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
