<?php

use App\Http\Controllers\CarburantController;
use App\Http\Controllers\CarburantControllerA;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\FactureCaissierController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\KiosqueController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReleveControllerA;
use App\Http\Controllers\StatController;
use App\Http\Controllers\UserController;
use App\Models\Carburant;
use App\Models\FactureCaissier;
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
        UserController::class, "index"
    ])->name("user.caissier");
    Route::get('/caissier/releves', [UserController::class, "rapports"])->name("caissier.releves");
    Route::get('/caissier/hours', [UserController::class, "hours"])->name("caissier.hours");
    Route::get('/caissier/{month}/hours', [UserController::class, "getHours"])->name("caissier.getHours");
    Route::get('/caissier/{id}/rapport', [UserController::class, "rapport"])->name("user.rapport");


    //compte
    Route::post("/comptes/init", [CompteController::class, "init"])->name("comptes.init")->middleware("admin");
    Route::resource('comptes', CompteController::class)->middleware("admin");


    Route::resource('carburants', CarburantController::class)->middleware("admin");;

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
        "/carburant/majSeuilCalcule",
        [CarburantControllerA::class, "majSeuilCalcule"]
    )->name("carburant.majSeuilCalcule")->middleware("admin");;
    Route::get("/carburant/jauge", [CarburantControllerA::class, "jauge"])->name("carburant.jauge")->middleware("admin");
    Route::get("/carburant/seuil", [CarburantControllerA::class, "seuil"])->name("carburant.seuil")->middleware("admin");
    Route::get("/carburant/marge", [CarburantControllerA::class, "marge"])->name("carburant.marge")->middleware("admin");
    Route::get("/carburant/prix", [CarburantControllerA::class, "prixA"])->name("carburant.prix")->middleware("admin");
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
