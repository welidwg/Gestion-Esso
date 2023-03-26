<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKiosquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosques', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references('id')->on("users")->onDelete("cascade");
            $table->date("date_today");
            $table->dateTime("date_d");
            $table->dateTime("date_f");
            $table->float("espece")->nullable()->default(0);
            $table->float("carte_bleu")->nullable()->default(0);
            $table->float("cheque")->nullable()->default(0);
            $table->float("boutique")->nullable()->default(0);
            $table->float("compte_provisoir")->nullable()->default(0);
            $table->float("litres")->nullable()->default(0);
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
        Schema::dropIfExists('kiosques');
    }
}
