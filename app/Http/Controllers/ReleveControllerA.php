<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Compte;
use App\Models\Releve;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Stub\ReturnStub;

class ReleveControllerA extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $releves = Releve::with("caissier")->get();

        return view("dashboard.pages.releve.index", ["releves" => $releves]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carburants = Carburant::all();

        return view("dashboard.pages.releve.add_releve", ["carburants" => $carburants]);
    }
    public function updateCarburant($title, $qte)
    {
        $carb = Carburant::where("titre", $title)->first();
        //    $oldQte=$carb->qtiteStk;
        $newQte = $carb->qtiteStk - $qte;
        $carb->qtiteStk = $newQte;
        $carb->valeur_stock = $newQte * $carb->prixV;
        $carb->save();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data["date_systeme"] = date("Y-m-d");
            $title = "";

            foreach ($request->input("titles") as $v) {
                if ($v == "D-ENERGIE") {
                    $title = "qte_denergie";
                } else {
                    $title = "qte_" . strtolower($v);
                }

                $this->updateCarburant($v, $data[$title]);

                # code...
            }
            $compte = Compte::where("id", "!=", null)->first();
            if ($compte) {
                $compte->montant += $request->totalPdf;
                $compte->save();
            } else {
                Compte::create(["montant" => $request->totalPdf]);
            }

            Releve::create($data);
            return response(json_encode(["type" => "success", "message" => "Relevee bien ajouté !"]), 200);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Releve  $releve
     * @return \Illuminate\Http\Response
     */
    public function show(Releve $releve)
    {
        $carburants = Carburant::all();

        return view("dashboard.pages.releve.show", ["releve" => $releve, "carburants" => $carburants]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Releve  $releve
     * @return \Illuminate\Http\Response
     */
    public function edit(Releve $releve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Releve  $releve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Releve $releve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Releve  $releve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Releve $releve)
    {
        $releve->delete();

        return redirect()->route('releve.index')
            ->with('success', 'Relevee bien supprimé');
    }
}
