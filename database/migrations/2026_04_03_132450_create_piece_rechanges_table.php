<?php

use App\Models\Interventions;
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
        Schema::create('piece_rechanges', function (Blueprint $table) {
            $table->id('id_PRechange');
            $table->string('Nom');
            $table->string('Marque')->nullable();
            $table->string('Prix');
            $table->string('Stock');
            $table->foreignId('id_Intervtion')->nullable()
                                              ->constrained(table: 'interventions', column: 'id_Intervtion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piece_rechanges');
    }
};
