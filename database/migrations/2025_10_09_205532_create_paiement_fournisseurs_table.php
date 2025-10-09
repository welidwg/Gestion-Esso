<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementFournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiement_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('fournisseur');
            $table->decimal('montant_ttc', 10, 2);
            $table->enum('mode_de_paiement', ['Carte banquaire', 'espece']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiement_fournisseurs');
    }
}
