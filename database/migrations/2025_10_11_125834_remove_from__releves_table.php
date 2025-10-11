<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFromRelevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('releves', function (Blueprint $table) {
            if (Schema::hasColumn('releves', 'boutique_cigarette_recette')) {
                $table->dropColumn('boutique_cigarette_recette');
            }
            if (Schema::hasColumn('releves', 'boutique_cigarette_qte')) {
                $table->dropColumn('boutique_cigarette_qte');
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
