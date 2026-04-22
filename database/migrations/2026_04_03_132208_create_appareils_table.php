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
        Schema::create('appareils', function (Blueprint $table) {
            $table->id('id_appareil');
            $table->string('nom_appareil');
            $table->string('marque_appareil');
            $table->string('type_appareil');
            $table->string('etat_appareil');
            $table->string('couleur_appareil');
            $table->foreignId('id_utilisateur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appareils');
    }
};
