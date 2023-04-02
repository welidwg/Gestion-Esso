<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureCaissiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_caissiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->date("date");
            $table->json("SP98")->nullable();
            $table->json("SP95")->nullable();
            $table->json("D-ENERGIE")->nullable();
            $table->json("DIESEL")->nullable();
            $table->json("GPL")->nullable();
            $table->json("PETROL")->nullable();
            $table->json("GNR")->nullable();
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
        Schema::dropIfExists('facture_caissiers');
    }
}
