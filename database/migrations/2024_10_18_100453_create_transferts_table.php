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
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('egliseSource_id')->constrained('eglises')->onDelete('set null'); // Eglise source
            $table->foreignId('egliseDest_id')->constrained('eglises')->onDelete('set null'); // Eglise destination
            $table->foreignId('membre_id')->constrained('membres')->onDelete('set null');
            $table->foreignId('source_responsable_id')->constrained('users')->onDelete('set null');
            $table->foreignId('destination_responsable_id')->constrained('users')->onDelete('set null');
            $table->dateTime('date_demande_transfert')->useCurrent();
            $table->dateTime('date_reponse_demande')->nullable();
            $table->tinyInteger('status')->default(0)->comment('Transfert denied : 0, Transfert accepted : 1 ');
            $table->string('eglise_name')->nullable();
            $table->string('membre_name')->nullable();
            $table->string('egliseSource_name')->nullable();
            $table->string('egliseDest_name')->nullable();
            $table->string('source_responsable_name')->nullable();
            $table->string('destination_responsable_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferts');
    }
};
