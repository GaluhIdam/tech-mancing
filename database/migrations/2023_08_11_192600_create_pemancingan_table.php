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
        Schema::create('pemancingan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('category');
            $table->string('image');
            $table->string('path');
            $table->string('nama_pemancingan');
            $table->string('deskripsi');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('alamat');
            $table->string('lokasi');
            $table->boolean('status')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemancingan');
    }
};
