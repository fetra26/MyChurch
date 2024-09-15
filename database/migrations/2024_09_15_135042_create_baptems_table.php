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
        Schema::create('baptemes', function (Blueprint $table) {
            $table->id();
            $table->text('messageBapt');
            $table->string('certificat');
            $table->string('lieuBapt');
            $table->smallInteger('isCertDelivered');
            $table->date('dateBapt');
            $table->unsignedBigInteger('id_pst');
            $table->foreign('id_pst')->references('id')->on('membres');
            $table->unsignedBigInteger('id_membre');
            $table->foreign('id_membre')->references('id')->on('membres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptems');
    }
};
