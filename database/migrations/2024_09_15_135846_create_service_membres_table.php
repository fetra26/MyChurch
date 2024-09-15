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
        Schema::create('service_membres', function (Blueprint $table) {
            $table->id();
            $table->date('dateDebutServ');
            $table->date('dateFinServ');
            $table->unsignedBigInteger('id_membre');
            $table->foreign('id_membre')->references('id')->on('membres');
            $table->unsignedBigInteger('id_serv');
            $table->foreign('id_serv')->references('id')->on('services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_membres');
    }
};
