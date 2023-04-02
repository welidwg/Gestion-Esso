<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Compte;
use Illuminate\Http\Request;

class CarburantControllerA extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all = Carburant::all();
        return view("dashboard.pages.carburant.index", ["carburants" => $all]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("dashboard.pages.carburant.add_carburant");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            Carburant::create($req->all());


            return response(json_encode(["type" => "success", "message" => "Carburant bien ajouté !"]), 200);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carburant  $carburant
     * @return \Illuminate\Http\Response
     */
    public function show(Carburant $carburant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carburant  $carburant
     * @return \Illuminate\Http\Response
     */
    public function edit(Carburant $carburant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carburant  $carburant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carburant $carburant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carburant  $carburant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carburant $carburant)
    {
        //
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jauge()
    {
        # code...
        $all = Carburant::all();
        return view("dashboard.pages.carburant.jauge", ["carburants" => $all]);
    }
    public function seuil()
    {
        # code...
        $all = Carburant::all();
        return view("dashboard.pages.carburant.seuil", ["carburants" => $all]);
    }
    public function marge()
    {
        # code...
        $all = Carburant::all();
        return view("dashboard.pages.carburant.marge", ["carburants" => $all]);
    }
    public function editjauge(Request $req)
    {
        # code...
        $all = Carburant::all();
        $column = "";
        $data = "";
        $ecraser = false;
        if ($req->has("ecraser")) {
            $ecraser = true;
        }
        foreach ($all as $v) {
            $data = "qtiteJg" . $v->id;


            $v->qtiteJg = $req->$data;
            if ($ecraser) {
                $v->qtiteStk = $req->$data;
                $v->valeur_stock = $v->prixV * $req->$data;
            }
            $v->save();
        }

        return "done";
    }

    public function editSeuil(Request $req)
    {
        # code...
        $all = Carburant::all();
        $column = "";
        $data = "";
        foreach ($all as $v) {
            $data = "seuil" . $v->id;

            $v->seuil = $req->$data;
            $v->save();
            # code...
        }

        return "done";
    }

    public function editMarge(Request $req)
    {
        # code...
        $all = Carburant::all();
        $column = "";
        $data = "";
        foreach ($all as $v) {
            $data = "marge_beneficiere" . $v->id;
            $newPV = $v->prixA * (1 + $req->$data);
            $v->marge_beneficiere = $req->$data;
            $v->prixV = $newPV;
            $v->valeur_stock = $v->qtiteStk * $newPV;
            $v->save();
            # code...
        }

        return "done";
    }
}
