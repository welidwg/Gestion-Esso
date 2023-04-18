<?php

namespace App\Http\Controllers;

use App\Models\AchatCigarette;
use App\Models\Cigarette;
use App\Models\Compte;
use Illuminate\Http\Request;

class CigaretteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("dashboard.pages.cigarette.index", ["cigarettes" => Cigarette::orderBy("id", "desc")->get()]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.pages.cigarette.create");
    }

    public function prixV($id)
    {
        $cigarette = Cigarette::find($id);
        return view("dashboard.pages.cigarette.prixV", ["cigarette" => $cigarette]);
    }
    public function historique()
    {
        return view("dashboard.pages.cigarette.historique", ["cigarettes" => AchatCigarette::orderBy("id", "desc")->get()]);
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
        $check = Cigarette::where("type", $request->type)->first();
        if ($check) {
            return response(["error" => "Ce type est déjà existant!"], 500);
        }
        if (strpos($request->type, ',') !== false && strpos($request->type, '.') !== false) {
            return response(["error" => "Le type ne doit pas contenir des virgules et des points."], 500);
        }
        $new = Cigarette::create($request->all());
        return response(["success" => "Type du Cigarette bien ajouté ! "], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cigarette  $cigarette
     * @return \Illuminate\Http\Response
     */
    public function show(Cigarette $cigarette)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cigarette  $cigarette
     * @return \Illuminate\Http\Response
     */
    public function edit(Cigarette $cigarette)
    {
        //
        return view("dashboard.pages.cigarette.edit", ["cigarette" => $cigarette]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cigarette  $cigarette
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cigarette $cigarette)
    {
        //
    }

    public function achat()
    {
        return view("dashboard.pages.cigarette.achat", ["cigarettes" => Cigarette::all()]);
    }


    public function achat_store(Request $request)
    {

        $cigarettes = Cigarette::all();
        $compte = Compte::latest()->first();
        $solde = $compte->montant;
        $total = 0;
        $date = date("Y-m-d");
        $final = [];
        $achat = [];

        if ($request->has("types")) {
            foreach ($request->input("types") as $type) {
                $cigar = Cigarette::where("type", $type)->first();
                $qte = "qte_$cigar->id";
                $prix_a = "prixA_$cigar->id";
                $total += $request->$prix_a * $request->$qte;
            }
            if ($total > $solde) {
                return response(["error" => "Solde insuffisant !", "message" => "Votre solde est insuffisant ! <br> <strong>Solde :</strong>  $solde €| <strong>Total commande: </strong> $total €"], 500);
            }
            foreach ($request->input("types") as $type) {

                # code...
                $cigar = Cigarette::where("type", $type)->first();
                $qte = "qte_$cigar->id";
                $prix_v = "prixV_$cigar->id";
                $prix_a = "prixA_$cigar->id";
                $cigar->qte += $request->$qte;
                $cigar->prixA = $request->$prix_a;
                $cigar->prixV = $request->$prix_a + 1;
                $total += $request->$prix_a * $request->$qte;
                array_push($achat, [$type => ["qte" => $request->$qte, "prixA" => $request->$prix_a]]);
                $cigar->save();
            }
            // array_push($final, $achat);
            $achatCigars = new AchatCigarette();
            $achatCigars->date_achat = $date;
            $achatCigars->total = $total;
            $achatCigars->achat = json_encode($achat);
            $compte->montant -= $total;
            $compte->tva_achat += $total * 0.2;
            $compte->save();
            $achatCigars->save();
            return response(["success" => "Type du Cigarette bien ajouté ! "], 201);
        } else {
            return response(["message" => "Erreur ! "], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cigarette  $cigarette
     * @return \Illuminate\Http\Response
     */
    public function editPrixV(Request $request, $id)
    {
        $cigarette = Cigarette::find($id);
        if ($request->prixV != 0) {
            $cigarette->prixV = $request->prixV;
            $cigarette->save();
            return response(["success" => "Prix de vente bien modifié! "], 200);
        }
        return response(["message" => "Prix de vente non valide "], 500);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cigarette  $cigarette
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cigarette $cigarette)
    {
        //
        $cigarette->delete();
        return redirect()->to("/cigarette");
    }
}
