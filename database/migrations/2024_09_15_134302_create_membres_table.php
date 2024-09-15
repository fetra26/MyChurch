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
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->integer('sexe');
            $table->date('datenais');
            $table->unsignedBigInteger('id_eglise');
            $table->foreign('id_eglise')->references('id')->on('eglises');
            $table->unsignedBigInteger('id_cont');
            $table->foreign('id_cont')->references('id')->on('contacts');
            $table->unsignedBigInteger('id_stat');
            $table->foreign('id_stat')->references('id')->on('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membres');
    }
};
