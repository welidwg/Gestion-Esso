<?php

namespace App\Http\Controllers;

use App\Models\ArticleFacture;
use App\Models\FactureEpicerie;
use Illuminate\Http\Request;

class FactureEpicerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factures = FactureEpicerie::paginate(10);
        return view('dashboard.pages.facture_epicerie.index', compact('factures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articles = \App\Models\ArticleFacture::orderBy('designation')->get();
        return view('dashboard.pages.facture_epicerie.create', compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom_de_fournisseur' => 'required|string',
            'date' => 'required|date',
            'articles' => 'required|array',
        ]);
        foreach ($validatedData['articles'] as $index => $article) {
            $des = $article["designation"];

            $check = ArticleFacture::where("designation", "like", $des)->first();
            if ($check->tva == 0) {
                $check->tva = $article["tva"];
                $check->save();
            }
        }

        FactureEpicerie::create([
            'nom_de_fournisseur' => $validatedData['nom_de_fournisseur'],
            'date' => $validatedData['date'],
            'articles' => $validatedData['articles'],
        ]);

        return redirect()->route('factureepicerie.index')->with('success', 'Facture créée avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FactureEpicerie  $factureEpicerie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $facture = FactureEpicerie::findOrFail($id);
        return view('dashboard.pages.facture_epicerie.show', compact('facture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FactureEpicerie  $factureEpicerie
     * @return \Illuminate\Http\Response
     */
    public function edit(FactureEpicerie $factureEpicerie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FactureEpicerie  $factureEpicerie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FactureEpicerie $factureEpicerie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FactureEpicerie  $factureEpicerie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facture = FactureEpicerie::findOrFail($id);
        $facture->delete();

        return redirect()->route('factureepicerie.index')->with('success', 'Facture supprimée');
    }
}
