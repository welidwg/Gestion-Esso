<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releves', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references('id')->on("users")->onDelete("cascade");
            $table->date("date_systeme");
            $table->time("heure_d");
            $table->time("heure_f");
            $table->float("espece")->nullable()->default(0);
            $table->float("carte_bleu")->nullable()->default(0);
            $table->float("carte_pro")->nullable()->default(0);
            $table->float("cheque")->nullable()->default(0);
            $table->float("boutique")->nullable()->default(0);
            $table->float("client_compte")->nullable()->default(0);
            $table->float("totalSaisie")->nullable()->default(0);
            $table->float("especePdf")->nullable()->default(0);
            $table->float("carte_bleuPdf")->nullable()->default(0);
            $table->float("carte_proPdf")->nullable()->default(0);
            $table->float("chequePdf")->nullable()->default(0);
            $table->float("boutiquePdf")->nullable()->default(0);
            $table->float("client_comptePdf")->nullable()->default(0);
            $table->float("totalPdf")->nullable()->default(0);
            $table->float("qte_sp98")->nullable()->default(0);
            $table->float("qte_sp95")->nullable()->default(0);
            $table->float("qte_denergie")->nullable()->default(0);
            $table->float("qte_diesel")->nullable()->default(0);
            $table->float("qte_gpl")->nullable()->default(0);
            $table->float("qte_petrol")->nullable()->default(0);
            $table->float("qte_gnr")->nullable()->default(0);
            $table->float("diff")->nullable()->default(0);
            $table->longText("explication")->nullable();
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
        Schema::dropIfExists('releves');
    }
}
