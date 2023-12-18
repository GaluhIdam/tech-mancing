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
            $table->text('gambar');
            $table->text('path');
            $table->text('nama_acara');
            $table->text('deskripsi');
            $table->text('grand_prize');
            $table->date('mulai');
            $table->date('akhir');
            $table->boolean('status')->nullable();
            $table->text('pesan')->nullable();
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
