<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EditStockReelColumnToStockCarburantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->float('stock_new')->nullable();
        });
        DB::statement('UPDATE stock_carburants SET stock_new = stock_reel');
        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->dropColumn('stock_reel');
        });
        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->renameColumn('stock_new', 'stock_reel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->integer('stock_old')->nullable();
        });

        DB::statement('UPDATE stock_carburants SET stock_old = stock_reel');

        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->dropColumn('stock_reel');
            $table->renameColumn('stock_old', 'stock_reel');
        });
    }
}
