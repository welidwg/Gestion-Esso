<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use Illuminate\Http\Request;

/**
 * Class CompteController
 * @package App\Http\Controllers
 */
class CompteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comptes = Compte::paginate();

        return view('compte.index', compact('comptes'))
            ->with('i', (request()->input('page', 1) - 1) * $comptes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $compte = new Compte();
        return view('compte.create', compact('compte'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Compte::$rules);

        $compte = Compte::create($request->all());

        return redirect()->route('comptes.index')
            ->with('success', 'Compte created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $compte = Compte::find($id);

        return view('compte.show', compact('compte'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $compte = Compte::find($id);

        return view('compte.edit', compact('compte'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Compte $compte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compte $compte)
    {
        request()->validate(Compte::$rules);

        $compte->update($request->all());

        return redirect()->route('comptes.index')
            ->with('success', 'Compte updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $compte = Compte::find($id)->delete();

        return redirect()->route('comptes.index')
            ->with('success', 'Compte deleted successfully');
    }
}
