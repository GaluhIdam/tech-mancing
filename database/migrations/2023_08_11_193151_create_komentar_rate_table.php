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
        Schema::create('komentar_rate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pemancingan');
            $table->unsignedBigInteger('id_user');
            $table->string('komentar');
            $table->integer('rate');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_pemancingan')->references('id')->on('pemancingan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_rate');
    }
};
