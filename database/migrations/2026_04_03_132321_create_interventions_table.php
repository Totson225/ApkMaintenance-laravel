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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id('id_Intervtion');
            $table->date('date_demande');
            $table->date('date_intervention');
            $table->string('descript_panne');
            $table->string('solution_apportee')->default('Aucune solution apportee');
            $table->string('type_intervention');
            $table->foreignId('id_appareil');
            $table->foreignId('id_utilisateur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
