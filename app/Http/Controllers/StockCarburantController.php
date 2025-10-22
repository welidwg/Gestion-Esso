<?php

namespace App\Http\Controllers;

use App\Models\StockCarburant;
use Exception;
use Illuminate\Http\Request;

class StockCarburantController extends Controller
{

    public function index()
    {
        $stocks = StockCarburant::orderByDesc('date_stock')->paginate(10);
        return view('dashboard.pages.stock.index', compact('stocks'));
    }

    public function create()
    {
        $carburants = \App\Models\Carburant::orderBy('titre')->get(); // use your actual field names
        return view('dashboard.pages.stock.create', compact('carburants'));
    }

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'date_stock' => 'required',
                'stocks' => 'required|array',
                'stocks.*.carburant' => 'required|string',
                'stocks.*.stock_reel' => 'required|integer',
            ]);

            foreach ($validated['stocks'] as $item) {
                StockCarburant::create([
                    'date_stock' => $validated['date_stock'],
                    'carburant' => $item['carburant'],
                    'stock_reel' => $item['stock_reel'],
                ]);
            }

            return redirect()->route('stockcarburant.index')->with('success', 'Stocks enregistrés avec succès.');
        } catch (\Throwable $th) {
            // dd(date("Y-m-d", strtotime()));
            if ($th instanceof \Illuminate\Validation\ValidationException) {
                dd($th->errors()); // 👈 shows the specific validation errors
            }
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
