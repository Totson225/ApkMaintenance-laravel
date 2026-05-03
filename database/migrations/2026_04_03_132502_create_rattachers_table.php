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
        Schema::create('rattachers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_Intervtion'); 
            $table->unsignedBigInteger('Id_materiel');

            $table->date('Deb_intervention')->nullable();;
            $table->date('Fin_intervention')->nullable();

            $table->foreign('id_Intervtion')->references('id_Intervtion')->on('interventions')->onDelete('cascade');
            $table->foreign('Id_materiel')->references('Id_materiel')->on('materiels')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rattachers');
    }
};
