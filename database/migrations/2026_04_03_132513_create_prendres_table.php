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
        Schema::create('prendres', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_technicien'); 
            $table->unsignedBigInteger('Id_materiel');

            $table->date('date_prise')->nullable();;
            $table->date('date_retour')->nullable();;
            $table->string('type_mat')->nullable();

            $table->foreign('id_technicien')->references('id_technicien')->on('techniciens')->onDelete('cascade');
            $table->foreign('Id_materiel')->references('Id_materiel')->on('materiels')->onDelete('cascade');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prendres');
    }
};
