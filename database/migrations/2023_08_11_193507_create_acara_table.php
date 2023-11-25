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
        Schema::create('acara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pemancingan');
            $table->unsignedBigInteger('id_user');
            $table->string('gambar');
            $table->string('path');
            $table->string('nama_acara');
            $table->string('deskripsi');
            $table->string('grand_prize');
            $table->date('mulai');
            $table->date('akhir');
            $table->boolean('status')->nullable();
            $table->timestamps();

            $table->foreign('id_pemancingan')->references('id')->on('pemancingan');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acara');
    }
};
