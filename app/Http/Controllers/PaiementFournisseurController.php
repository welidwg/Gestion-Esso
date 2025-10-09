<?php

namespace App\Http\Controllers;

use App\Models\PaiementFournisseur;
use Illuminate\Http\Request;

class PaiementFournisseurController extends Controller
{
    public function create()
    {
        return view('dashboard.pages.paiementfournisseur.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'paiements.*.date' => 'required|date',
            'paiements.*.fournisseur' => 'required|string',
            'paiements.*.montant_ttc' => 'required|numeric',
            'paiements.*.mode_de_paiement' => 'required|in:Carte bancaire,Espèce,Virement,Chèque,Prélèvement',
        ]);
        foreach ($data['paiements'] as $paiement) {
            PaiementFournisseur::create($paiement);
        }
        return redirect()->route('paiementfournisseur.index');
    }

    public function index()
    {
        $paiements = PaiementFournisseur::paginate(10);
        return view('dashboard.pages.paiementfournisseur.index', compact('paiements'));
    }

    public function show($id)
    {
        $paiement = PaiementFournisseur::findOrFail($id);
        return view('dashboard.pages.paiementfournisseur.show', compact('paiement'));
    }

    public function destroy($id)
    {
        $paiement = PaiementFournisseur::findOrFail($id);
        $paiement->delete();
        return redirect()->route('paiementfournisseur.index')->with('success', 'Paiement supprimée avec succès.');
    }
}
