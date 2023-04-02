<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Compte;
use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("dashboard.pages.facture.index", ["factures" => Facture::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $compte = Compte::where("id", "!=", null)->first();
        $carburants = Carburant::all();

        return view("dashboard.pages.facture.create", ["montant" => $compte ? $compte->montant : 0, "carburants" => $carburants]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $montant = $request->montant;
            $compte = Compte::where("id", "!=", null)->first();
            $facture = new Facture();
            $facture->ref = $request->ref;
            $facture->montant = $request->montant;
            $facture->date_facture = $request->date_facture;
            if ($compte) {
                $compte->montant -= $montant;
                $compte->save();
            }
            $carbs = Carburant::all();
            foreach ($carbs as $carb) {
                # code...
                $data = [];
                $prixA = $carb->prixA;
                $qte = $carb->qtiteStk;
                if ($request->has("qte_$carb->titre")) {
                    $newQte = $request->input("qte_$carb->titre");
                    $pa = ($request->input("prixA_$carb->id") * 1.2);
                    $pv = $pa * (1 + $carb->marge_beneficiere);
                    $vs = ($carb->qtiteStk + $newQte) * $pv;
                    array_push($data, ["prixAHT" => $request->input("prixA_$carb->id"), "prixATTC" => $pa, "qte" => $newQte]);
                    // $carb->prixA = $pa;
                    // $carb->prixV = $pv;
                    // $carb->qtiteStk += $newQte;
                    // $carb->valeur_stock = $vs;
                    // $carb->save();
                    $title =  $carb->titre;
                    $facture->$title = json_encode($data);
                }
            }
            $facture->save();
            // Facture::create($request->all());
            return response(json_encode(["type" => "success", "message" => "Facture bien ajoutée !", "data" => $request->all()]), 200);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function show(Facture $facture)
    {
        //
        $carbs = Carburant::all();
        return view("dashboard.pages.facture.show", ["facture" => $facture, "carburants" => $carbs]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function edit(Facture $facture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facture $facture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facture $facture)
    {
        //
    }
}
