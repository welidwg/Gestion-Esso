<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromReleves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('releves', function (Blueprint $table) {
            //
            if (Schema::hasColumn('releves', 'qte_sp98')) {
                $table->dropColumn('qte_sp98');
            }
            if (Schema::hasColumn('releves', 'qte_sp95')) {
                $table->dropColumn('qte_sp95');
            }
            if (Schema::hasColumn('releves', 'qte_denergie')) {
                $table->dropColumn('qte_denergie');
            }
            if (Schema::hasColumn('releves', 'qte_diesel')) {
                $table->dropColumn('qte_diesel');
            }
            if (Schema::hasColumn('releves', 'qte_gpl')) {
                $table->dropColumn('qte_gpl');
            }
            if (Schema::hasColumn('releves', 'qte_petrol')) {
                $table->dropColumn('qte_petrol');
            }
            if (Schema::hasColumn('releves', 'qte_gnr')) {
                $table->dropColumn('qte_gnr');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('releves', function (Blueprint $table) {
            //
        });
    }
}
