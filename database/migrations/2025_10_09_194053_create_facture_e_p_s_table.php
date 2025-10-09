<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureEPSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_ep', function (Blueprint $table) {
            $table->id();
            $table->string('nom_de_fournisseur');
            $table->date('date');
            $table->string('designation');
            $table->decimal('prix_unite', 10, 2);
            $table->integer('qte');
            $table->decimal('prix_ht', 10, 2);
            $table->decimal('tva', 5, 2);
            $table->decimal('prix_ttc', 10, 2);
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
        Schema::dropIfExists('facture_ep');
    }
}
