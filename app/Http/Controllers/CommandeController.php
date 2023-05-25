<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Facture;
use App\Models\Releve;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    //
    public function index()
    {
        $carbs = Carburant::all();
        $oneWeekAgo = now()->subWeek();
        $data = "";
        $moyennes = [];
        foreach ($carbs as $carburant) {
            $moyennes[$carburant->titre] = $carburant->seuilA;
        }
        $dates = Releve::select('date_systeme')->whereBetween("date_systeme", [date("Y-m-d", strtotime($oneWeekAgo)), date("Y-m-d")])->distinct()->get();
        foreach ($dates as $date) {
            $rels = Releve::where('date_systeme', '=', $date->date_systeme)->get();
            if ($rels) {
                foreach ($rels as $rel) {
                    $ventes = json_decode($rel->vente);
                    foreach ($carbs as $carburant) {
                        $total = 0;
                        foreach ($ventes as $vente) {
                            foreach ($vente as $k => $v) {
                                if ($k == $carburant->titre) {
                                    $total += $v->qte;
                                    if (isset($moyennes[$carburant->titre])) {
                                        $moyennes[$carburant->titre] += $total;
                                    } else {
                                        $moyennes[$carburant->titre] = $total;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (count($moyennes) !== 0) {
            foreach ($moyennes as $k => $v) {
                $carb = Carburant::where("titre", $k)->first();
                if ($carb->seuilA == $v) {
                    $carb->seuil = $carb->seuilA;
                } else {
                    $moyennes[$k] = ($v / 7) + $carb->seuilA;
                }

                // $test = $carb;
            }
        }
        $facture = Facture::latest()->first();
        return view("dashboard.pages.commande.index", ["carburants" => $carbs, "facture" => $facture, "moyennes" => $moyennes]);
    }
}
