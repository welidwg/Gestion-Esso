<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Releve;
use Illuminate\Http\Request;

class StatController extends Controller
{
    //
    function moyenne($date1, $date2)
    {
        $moyennes = [];
        $carbs = Carburant::all();
        // $releves = Releve::whereBetween('date_systeme', [$date1, $date2])
        //     ->get();
        $dates = Releve::select('date_systeme')->whereBetween('date_systeme', [$date1, $date2])->distinct()->get();
        foreach ($dates as $date) {
            $rels = Releve::where('date_systeme', '=', $date->date_systeme)->get();
            if ($rels) {
                foreach ($rels as $rel) {
                    foreach ($carbs as $carburant) {
                        $total = 0;
                        $title = 'qte_' . strtolower($carburant->titre);
                        if ($carburant->titre == 'D-ENERGIE') {
                            $title = 'qte_denergie';
                        }

                        if ($rel->$title != 0.0) {
                            $total += $rel->$title;
                            // echo $rel->$title . ' ';
                            if (isset($moyennes[$carburant->titre])) {
                                $moyennes[$carburant->titre] += $total;
                                // array_merge($moyennes, [$carburant->titre => $total]);
                            } else {
                                $moyennes["$carburant->titre"] = $total;
                            }
                        }
                    }

                    $total = 0;
                }
            }
            # code...
        }

        return $moyennes;
    }
}
