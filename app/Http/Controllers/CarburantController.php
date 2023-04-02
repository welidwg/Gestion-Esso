<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use Illuminate\Http\Request;

/**
 * Class CarburantController
 * @package App\Http\Controllers
 */
class CarburantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carburants = Carburant::paginate();

        return view('carburant.index', compact('carburants'))
            ->with('i', (request()->input('page', 1) - 1) * $carburants->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carburant = new Carburant();
        return view('carburant.create', compact('carburant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Carburant::$rules);

        $carburant = Carburant::create($request->all());

        return redirect()->route('carburants.index')
            ->with('success', 'Carburant ajouté avec succèes.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carburant = Carburant::find($id);

        return view('carburant.show', compact('carburant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carburant = Carburant::find($id);

        return view('carburant.edit', compact('carburant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Carburant $carburant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carburant $carburant)
    {
        request()->validate(Carburant::$rules);

        $carburant->update($request->all());

        return redirect()->route('carburants.index')
            ->with('success', 'Carburant modifié');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $carburant = Carburant::find($id)->delete();

        return redirect()->route('carburants.index')
            ->with('success', 'Carburant est supprimé avec succès');
    }
}
