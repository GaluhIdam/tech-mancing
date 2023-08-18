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
            $table->string('nama_acara');
            $table->string('deskripsi');
            $table->dateTime('mulai');
            $table->dateTime('akhir');
            $table->timestamps();

            $table->foreign('id_pemancingan')->references('id')->on('pemancingan');
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
