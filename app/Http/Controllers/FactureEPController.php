<?php

namespace App\Http\Controllers;

use App\Models\FactureEP;
use Illuminate\Http\Request;

class FactureEPController extends Controller
{

    public function create()
    {
        return view('dashboard.pages.factureep.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'factures.*.nom_de_fournisseur' => 'required|string',
            'factures.*.date' => 'required|date',
            'factures.*.designation' => 'required|string',
            'factures.*.prix_unite' => 'required|numeric',
            'factures.*.qte' => 'required|integer',
            'factures.*.prix_ht' => 'required|numeric',
            'factures.*.tva' => 'required|numeric',
            'factures.*.prix_ttc' => 'required|numeric',
        ]);
        foreach ($data['factures'] as $facture) {
            FactureEP::create($facture);
        }
        return redirect()->route('factureep.index');
    }
    public function show($id)
    {
        $facture = FactureEP::findOrFail($id);
        return view('dashboard.pages.factureep.show', compact('facture'));
    }

    public function index()
    {
        $factures = FactureEP::paginate(10);
        return view('dashboard.pages.factureep.index', compact('factures'));
    }

    public function destroy($id)
    {
        $facture = FactureEp::findOrFail($id);
        $facture->delete();
        return redirect()->route('factureep.index')->with('success', 'Facture supprimée avec succès.');
    }
}
