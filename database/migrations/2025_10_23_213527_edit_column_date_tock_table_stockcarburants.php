<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EditColumnDateTockTableStockcarburants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->datetime('date_time')->nullable();
        });
        DB::statement('UPDATE stock_carburants SET date_time = CONCAT(date_stock, " 00:00:00")');
        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->dropColumn('date_stock');
        });
        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->renameColumn('date_time', 'date_stock');
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
            $table->date('date_old')->nullable();
        });

        DB::statement('UPDATE stock_carburants SET date_old = DATE(date)');

        Schema::table('stock_carburants', function (Blueprint $table) {
            $table->dropColumn('date_stock');
            $table->renameColumn('date_old', 'date_stock');
        });
    }
}
