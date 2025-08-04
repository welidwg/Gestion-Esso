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
        return view("dashboard.pages.facture.index", ["factures" => Facture::orderBy("date_facture", "desc")->get()]);
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
            $tva = 0;
            $compte = Compte::where("id", "!=", null)->first();
            $check = Facture::where("date_facture", $request->date_facture)->first();
            $facture = new Facture();
            $facture->ref = $request->ref;
            $facture->montant = $request->montant;
            $facture->date_facture = $request->date_facture;
            // if ($check) {
            //     return response(json_encode(["type" => "error", "message" => "Vous avez déjà ajouter une facture avec cette date !"]), 500);
            // }
            $data = [];
            $carbs = Carburant::all();
            if ($request->has("tva")) {
                foreach ($request->input("tva") as $tv) {
                    # code...
                    $tva += $tv;
                }
            }
            foreach ($request->titre as $titre) {
                $carb = Carburant::where("titre", $titre)->first();
                $data = [];
                $column = $carb->titre;
                if ($request->has("qte_new_$carb->id")) {
                    $carb->qtiteStk += $request->input("qte_new_$carb->id");
                    $carb->prixA = $request->input("prix_u_ttc_new_$carb->id");
                    array_push($data, ["prixA" => $request->input("prixA_new_$carb->id"), "qte" => $request->input("qte_new_$carb->id"), "pu_htva" => $request->input("prix_u_ht_new_$carb->id"), "pu_ttc" => $request->input("prix_u_ttc_new_$carb->id"), "montant" => $request->input("montant_ttc_new_$carb->id")]);
                }
                if ($request->has("qte_$carb->id")) {
                    $carb->prixA = $request->input("prix_u_ttc_$carb->id");
                    array_push($data, ["prixA" => $request->input("prixA_$carb->id"), "qte" => $request->input("qte_$carb->id"), "pu_htva" => $request->input("prix_u_ht_$carb->id"), "pu_ttc" => $request->input("prix_u_ttc_$carb->id"), "montant" => $request->input("montant_ttc_$carb->id")]);
                }
                $carb->save();
                $facture->$column = json_encode($data);
            }
            if ($compte) {
                $compte->montant -= $montant;
                // $compte->tva_achat += $tva;
                $compte->save();
            }
            $facture->save();
            // Facture::create($request->all());
            return response(json_encode(["type" => "success", "message" => "Facture bien ajoutée !", "data" => $data]), 200);
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
        $facture->delete();
        return redirect()->to("/facture");
    }
}
