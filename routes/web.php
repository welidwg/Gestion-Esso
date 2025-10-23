<?php

use App\Http\Controllers\ArchiveSoldeController;
use App\Http\Controllers\ArticleFactureController;
use App\Http\Controllers\CarburantController;
use App\Http\Controllers\CarburantControllerA;
use App\Http\Controllers\CigaretteController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\DesiderataController;
use App\Http\Controllers\FactureCaissierController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FactureEPController;
use App\Http\Controllers\FactureEpicerieController;
use App\Http\Controllers\KiosqueController;
use App\Http\Controllers\PaiementFournisseurController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReleveControllerA;
use App\Http\Controllers\StatController;
use App\Http\Controllers\StockCarburantController;
use App\Http\Controllers\UserController;
use App\Models\Carburant;
use App\Models\Cigarette;
use App\Models\FactureCaissier;
use App\Models\FactureEpicerie;
use App\Models\Releve;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/token", function () {
    return csrf_token();
});
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->to("/main");
    }
    return view('welcome');
})->name("view.login");
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->to("/main");
    }
    return view('welcome');
})->name("view.login2");
Route::get('/pdf',  [PdfController::class, "index"])->name("view.pdf");
Route::post("/user/auth", [UserController::class, "auth"])->name("backend.login");
// Route::get('/user/add', function () {
//     return view('dashboard/pages/add_user');
// })->name("view.add_user");


Route::group(["middleware" => "auth"], function () {
    //views
    Route::get('/migrate', function () {
        Artisan::call('migrate');
        dd('migrated!');
    });
    Route::get('/optimize', function () {
        Artisan::call('optimize');
        dd('optimized!');
    });
    Route::get('/main', function () {
        $dates = Releve::select('date_systeme')->whereMonth('date_systeme', date("m"))
            ->whereYear('date_systeme', date("Y"))->distinct()->get();


        return view('dashboard/pages/main', ["dates" => $dates]);
    })->name("view.main");
    Route::get('/user/add', function () {
        return view('dashboard/pages/add_user');
    })->name("view.add_user")->middleware('admin');

    Route::get('/carburant/add', function () {
        return view('dashboard/pages/add_carburant');
    })->name("view.add_carburant")->middleware('admin');
    //controllers


    //user

    Route::post('/user/add', [UserController::class, "store"])->name("backend.add_user")->middleware('admin');
    Route::get('/user/logout', [UserController::class, "logout"])->name("logout");
    Route::post('/user/add', [UserController::class, "store"])->name("backend.add_user");
    Route::delete('/user/{id}', [UserController::class, "destory"])->name("user.destroy");
    Route::get('/user/{id}', [UserController::class, "show"])->name("user.show");
    Route::post('/user/{id}/edit', [UserController::class, "edit"])->name("user.edit");
    Route::get('/caissier', [
        UserController::class,
        "index"
    ])->name("user.caissier");
    Route::get('/caissier/releves', [UserController::class, "rapports"])->name("caissier.releves");
    Route::get('/caissier/hours', [UserController::class, "hours"])->name("caissier.hours");
    Route::get('/caissier/{month}/hours', [UserController::class, "getHours"])->name("caissier.getHours");
    Route::get(
        '/caissier/{id}/rapport',
        [UserController::class, "rapport"]
    )->name("user.rapport");
    // Route::get('/caissier/heures/{month}', [UserController::class, "rapport"])->name("caissier.heures");


    //compte
    Route::post("/comptes/init", [CompteController::class, "init"])->name("comptes.init")->middleware("admin");
    Route::post("/comptes/v2/init", [CompteController::class, "initV2"])->name("comptes.initV2");
    Route::resource('comptes', CompteController::class)->middleware("admin");


    Route::resource('carburants', CarburantController::class)->middleware("admin");;
    Route::resource('factureep', FactureEPController::class)->middleware("admin");;
    Route::resource('factureepicerie', FactureEpicerieController::class)->middleware("admin");
    Route::resource('paiementfournisseur', PaiementFournisseurController::class);
    Route::resource('articlefacture', ArticleFactureController::class)->middleware("admin");
    Route::resource('stockcarburant', StockCarburantController::class);

    //carburant
    Route::post(
        "/carburant/editjauge",
        [CarburantControllerA::class, "editjauge"]
    )->name("carburant.editJauge")->middleware("admin");


    Route::post(
        "/carburant/editSeuil",
        [CarburantControllerA::class, "editSeuil"]
    )->name("carburant.editSeuil")->middleware("admin");
    Route::post(
        "/carburant/editMarge",
        [CarburantControllerA::class, "editMarge"]
    )->name("carburant.editMarge")->middleware("admin");
    Route::post(
        "/carburant/editPrixA",
        [CarburantControllerA::class, "editPrixA"]
    )->name("carburant.editPrixA")->middleware("admin");
    Route::post(
        "/carburant/editPrixV",
        [CarburantControllerA::class, "editPrixV"]
    )->name("carburant.editPrixV")->middleware("admin");
    Route::post(
        "/carburant/majSeuilCalcule",
        [CarburantControllerA::class, "majSeuilCalcule"]
    )->name("carburant.majSeuilCalcule")->middleware("admin");;
    Route::get("/carburant/jauge", [CarburantControllerA::class, "jauge"])->name("carburant.jauge")->middleware("admin");
    Route::get("/carburant/seuil", [CarburantControllerA::class, "seuil"])->name("carburant.seuil")->middleware("admin");
    Route::get("/carburant/marge", [CarburantControllerA::class, "marge"])->name("carburant.marge")->middleware("admin");
    Route::get("/carburant/prix", [CarburantControllerA::class, "prixA"])->name("carburant.prix")->middleware("admin");
    Route::get("/carburant/prixV", [CarburantControllerA::class, "prixV"])->name("carburant.prixV")->middleware("admin");
    Route::get("/carburant/{id}/ventes", [CarburantControllerA::class, "ventes"])->name("carburant.ventes")->middleware("admin");
    Route::get("/carburant/stats", [CarburantControllerA::class, "stats"])->name("carburant.stats")->middleware("admin");

    Route::resource("carburant", CarburantControllerA::class)->middleware("admin");


    //releve
    Route::get("/releve/{date}/{user_id}", function ($date, $user_id) {
        $year = date("Y", strtotime($date));
        $month = date("m", strtotime($date));
        $releves = Releve::where('user_id', $user_id)
            ->whereMonth('date_systeme', $month)
            ->whereYear('date_systeme', $year)
            ->get();
        return $releves;
    })->name("releve.rapport")->middleware("admin");
    Route::get("/releve/caisse", [ReleveControllerA::class, "parCaissier"])->name("releve.caissier")->middleware("admin");
    Route::resource("releve", ReleveControllerA::class);

    //facture
    Route::get("/checkFacture/{date}", function ($date) {
        $carbs = Carburant::all();
        $check = FactureCaissier::whereDate('date', '=', date("Y-m-d", strtotime($date)))->with("caissier")->get();
        if ($check->count() > 0) {
            return response(["facture" => json_decode($check), "carburants" => json_decode($carbs)], 200);
        }
        return response("not found", 404);
    });
    Route::resource("facture", FactureController::class);

    //cigarettes


    Route::get("cigarette/achat", [CigaretteController::class, "achat"])->name("cigarette.achat");
    Route::get("cigarette/historique", [CigaretteController::class, "historique"])->name("cigarette.historique")->middleware("admin");
    Route::get("cigarette/{id}/prixv", [CigaretteController::class, "prixV"])->name("cigarette.prixV")->middleware("admin");
    Route::put("cigarette/achat/create", [CigaretteController::class, "achat_store"])->name("cigarette.achat_store");
    Route::put("cigarette/{id}/editprix", [CigaretteController::class, "editPrixV"])->name("cigarette.editPrixV")->middleware("admin");
    Route::get("/cigarette/stats", [CigaretteController::class, "stats"])->name("cigarette.stats")->middleware("admin");

    Route::resource("cigarette", CigaretteController::class)->middleware("admin");

    //commande
    Route::resource("commande", CommandeController::class)->middleware("admin");

    //archive solde
    Route::resource("archive/solde", ArchiveSoldeController::class)->middleware("admin");

    Route::get('/desiderata/report', [DesiderataController::class, 'generateReport'])->name('desiderata.report');
    Route::get('/desiderata/shifts', [DesiderataController::class, 'getShiftsForDate'])->name('desiderata.shifts');
    Route::get('/desiderata/events', [DesiderataController::class, 'events'])->name('desiderata.events');
    Route::resource("desiderata", DesiderataController::class);

    //rapport
    Route::get("/rapport", function () {
        return view("dashboard.pages.releve.rapport");
    })->name("rapport")->middleware("admin");






    //stats
    Route::get("/stats/moyenne", function () {
        $carbs = Carburant::all();
        return view("dashboard.pages.stats.moyenne", ["carburants" => $carbs]);
    })->name("stats");
    Route::post("/stats/moyenne/{date1}/{date2}", [StatController::class, "moyenne"])->name("stats.moyenne");
    //factureCaissier
    Route::resource("factureCaissier", FactureCaissierController::class);
    // Route::post('/carburant/add', [CarburantController::class, "store"])->name("backend.add_carburant")->middleware('admin');;
});
