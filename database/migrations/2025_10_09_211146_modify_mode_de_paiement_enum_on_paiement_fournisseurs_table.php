<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyModeDePaiementEnumOnPaiementFournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paiement_fournisseurs', function (Blueprint $table) {
            DB::statement("ALTER TABLE paiement_fournisseurs MODIFY mode_de_paiement ENUM('Carte bancaire', 'Espèce', 'Virement', 'Chèque', 'Prélèvement') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paiement_fournisseurs', function (Blueprint $table) {
            DB::statement("ALTER TABLE paiement_fournisseurs MODIFY mode_de_paiement ENUM('Carte bancaire', 'Espèce') NOT NULL");
        });
    }
}
