<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\FactureCaissier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactureCaissierController extends Controller
{
    public $tva = 1.2;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $carbs = Carburant::all();

        return view('dashboard.pages.facture_caissier.create', ["carburants" => $carbs]);
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

            $facture = new FactureCaissier();

            $facture->date = date("Y-m-d");
            $facture->user_id = Auth::id();
            $carbs = Carburant::all();
            foreach ($carbs as $carb) {
                if ($request->has("qte_$carb->titre")) {
                    $newQte = $request->input("qte_$carb->titre");

                    $vs = ($carb->qtiteStk + $newQte) * $carb->prixV;

                    $carb->qtiteStk += $newQte;
                    $carb->valeur_stock = $vs;
                    $carb->save();
                    $title =  $carb->titre;
                    $facture->$title = $newQte;
                }
            }
            $facture->save();
            // Facture::create($request->all());
            return response(json_encode(["type" => "success", "message" => "Stock est à jour !"]), 200);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FactureCaissier  $factureCaissier
     * @return \Illuminate\Http\Response
     */
    public function show(FactureCaissier $factureCaissier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FactureCaissier  $factureCaissier
     * @return \Illuminate\Http\Response
     */
    public function edit(FactureCaissier $factureCaissier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FactureCaissier  $factureCaissier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FactureCaissier $factureCaissier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FactureCaissier  $factureCaissier
     * @return \Illuminate\Http\Response
     */
    public function destroy(FactureCaissier $factureCaissier)
    {
        //
    }
}
