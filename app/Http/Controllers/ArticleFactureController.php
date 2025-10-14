<?php

namespace App\Http\Controllers;

use App\Models\ArticleFacture;
use Illuminate\Http\Request;

class ArticleFactureController extends Controller
{
    public function index()
    {
        $articles = ArticleFacture::orderBy('designation')->paginate(10);
        return view('dashboard.pages.articlefacture.index', compact('articles'));
    }

    public function create()
    {
        return view('dashboard.pages.articlefacture.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|unique:article_factures',
            'prix_unite' => 'nullable|numeric|min:0',
        ]);

        ArticleFacture::create($request->only(['designation', 'prix_unite']));

        return redirect()->route('articlefacture.index')->with('success', 'Article ajouté.');
    }

    public function edit(ArticleFacture $articlefacture)
    {
        return view('dashboard.pages.articlefacture.edit', compact('articlefacture'));
    }

    public function update(Request $request, ArticleFacture $articlefacture)
    {
        $request->validate([
            'designation' => 'required|string|unique:article_factures,designation,' . $articlefacture->id,
            'prix_unite' => 'nullable|numeric|min:0',
        ]);

        $articlefacture->update($request->only(['designation', 'prix_unite']));

        return redirect()->route('articlefacture.index')->with('success', 'Article modifié.');
    }

    public function destroy(ArticleFacture $articlefacture)
    {
        $articlefacture->delete();

        return redirect()->route('articlefacture.index')->with('success', 'Article supprimé.');
    }
}
