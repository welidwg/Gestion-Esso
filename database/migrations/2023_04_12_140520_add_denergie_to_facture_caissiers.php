<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDenergieToFactureCaissiers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facture_caissiers', function (Blueprint $table) {
            $table->float("SP98")->default(0)->change();
            $table->float("SP95")->default(0)->change();
            $table->float("DIESEL")->default(0)->change();
            $table->float("GPL")->default(0)->change();
            $table->float("PETROL")->default(0)->change();
            $table->float("GNR")->default(0)->change();
            $table->float("D-ENERGIE")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facture_caissiers', function (Blueprint $table) {
            //
        });
    }
}
