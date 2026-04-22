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
        Schema::create('concerners', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_Intervtion'); 
            $table->unsignedBigInteger('id_technicien');

            $table->date('Dte_Deb_intervention')->nullable();
            $table->date('Dte_Fin_intervention')->nullable();
            
            $table->foreign('id_Intervtion')->references('id_Intervtion')->on('interventions')->onDelete('cascade');
            $table->foreign('id_technicien')->references('id_technicien')->on('techniciens')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concerners');
    }
};
