<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleveBoutiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releve_boutiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId("releve_id")->references('id')->on("releves")->onDelete("cascade");
            $table->float("espece")->nullable()->default(0);
            $table->float("carte_bleue")->nullable()->default(0);
            $table->float("cheque")->nullable()->default(0);
            $table->float("client_compte")->nullable()->default(0);
            $table->float("divers")->default(0);
            $table->integer("cigarettes_qte")->default(0);;
            $table->float("cigarettes_recette")->default(0);;
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
        Schema::dropIfExists('releve_boutiques');
    }
}
