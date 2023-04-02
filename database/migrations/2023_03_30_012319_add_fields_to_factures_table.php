<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factures', function (Blueprint $table) {
            //
            $table->json("SP98")->nullable();
            $table->json("SP95")->nullable();
            $table->json("D-ENERGIE")->nullable();
            $table->json("DIESEL")->nullable();
            $table->json("GPL")->nullable();
            $table->json("PETROL")->nullable();
            $table->json("GNR")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factures', function (Blueprint $table) {
            //
        });
    }
}
