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
        Schema::create('techniciens', function (Blueprint $table) {
            $table->id('id_technicien');
            $table->string('nom_techniciens');
            $table->string('prenom_techniciens');
            $table->integer('telephone_technicien')->unique();
            $table->string('sexe_techniciens');
            $table->string('specialite_technicien');
            $table->string('email_technicien')->unique();
            $table->string('statut_tech');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('techniciens');
    }
};
