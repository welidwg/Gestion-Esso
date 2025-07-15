<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSplittableToDesideratasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('desideratas', function (Blueprint $table) {
            $table->boolean('is_splittable')->default(false);
            $table->dropColumn('shift_type');

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
            //
        });
    }
}
