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
        Schema::create('demandeurs', function (Blueprint $table) {
            $table->id('id_utilisateur');
            $table->string('nom_demandeur');
            $table->string('prenom_demandeur');
            $table->integer('telephone_demandeur')->unique();
            $table->string('sexe_demandeurs');
            $table->string('service_demandeur');
            $table->string('email_demandeur')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandeurs');
    }
};
