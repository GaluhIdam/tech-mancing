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
            $table->string('buka');
            $table->string('tutup');
            $table->string('nama_pemancingan');
            $table->text('deskripsi');

            $table->string('id_provinsi');
            $table->string('provinsi');

            $table->string('id_kota');
            $table->string('kota');


            $table->string('id_kecamatan');
            $table->string('kecamatan');

            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('pesan')->nullable();
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
