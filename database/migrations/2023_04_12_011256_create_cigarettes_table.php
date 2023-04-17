<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCigarettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cigarettes', function (Blueprint $table) {
            $table->id();
            $table->string("type",255);
            $table->float("qte")->default(0);
            $table->float("prixA")->default(0);
            $table->float("prixV")->default(0);
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
        Schema::dropIfExists('cigarettes');
    }
}
