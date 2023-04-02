<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarburantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carburants', function (Blueprint $table) {
            $table->id();
            $table->string("titre");
            $table->float("prixA")->default(0);
            $table->float("prixV")->default(0);
            $table->float("qtiteStk")->default(0);
            $table->float("qtiteJg")->default(0);
            $table->float("seuil")->default(0);
            $table->float("valeur_stock")->default(0);
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
        Schema::dropIfExists('carburants');
    }
}
