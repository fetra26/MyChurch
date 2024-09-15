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
        Schema::create('eglises', function (Blueprint $table) {
            $table->id();
            $table->string('nomEglise');
            $table->unsignedBigInteger('id_type');
            $table->foreign('id_type')->references('id')->on('types');
            $table->unsignedBigInteger('id_cont');
            $table->foreign('id_cont')->references('id')->on('contacts');
            $table->unsignedBigInteger('id_dist');
            $table->foreign('id_dist')->references('id')->on('districts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eglises');
    }
};
