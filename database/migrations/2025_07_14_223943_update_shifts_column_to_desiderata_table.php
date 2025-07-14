<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShiftsColumnToDesiderataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('desideratas', function (Blueprint $table) {
            Schema::table('desideratas', function (Blueprint $table) {
                $table->time('shift_start')->nullable()->after('shift');
                $table->time('shift_end')->nullable()->after('shift_start');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('desideratas', function (Blueprint $table) {
            $table->dropColumn(['shift_start', 'shift_end']);
        });
    }
}
