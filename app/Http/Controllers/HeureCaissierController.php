<?php
// app/Http/Controllers/HeureCaissierController.php

namespace App\Http\Controllers;

use App\Models\HeureCaissier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HeureCaissierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('Y-m'));

        // Parse the selected month
        $date = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth);
        $year = $date->year;
        $month = $date->month;

        // Get all hours for the selected month with user information
        $heures = HeureCaissier::with('user')
            ->whereYear('date_hours', $year)
            ->whereMonth('date_hours', $month)
            ->get();
        if (Auth::user()->role == 1) {
            $heures = HeureCaissier::with('user')
                ->whereYear('date_hours', $year)
                ->whereMonth('date_hours', $month)
                ->where("user_id", Auth::user()->id)
                ->get();
        }

        // Get all users for the dropdown


        return view('dashboard.pages.heure_caissiers.index', compact('heures', 'selectedMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('dashboard.pages.heure_caissiers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'month_year' => 'required|date_format:Y-m',
            'total_hours' => 'required|numeric|min:0|max:744', // Max 31*24 hours
        ]);

        // Convert Y-m to first day of month for storage
        $date = \Carbon\Carbon::createFromFormat('Y-m', $request->month_year)->startOfMonth();

        // Check if entry already exists for this user and month
        $existing = HeureCaissier::where('user_id', $request->user_id)
            ->whereYear('date_hours', $date->year)
            ->whereMonth('date_hours', $date->month)
            ->first();

        if ($existing) {
            return redirect()->back()->withErrors(['month_year' => 'Une entrée existe déjà pour cet utilisateur et ce mois.'])->withInput();
        }


        HeureCaissier::create([
            'user_id' => $request->user_id,
            'date_hours' => $date,
            'total_hours' => $request->total_hours,
        ]);

        return redirect()->route('heure-caissiers.index')->with('success', 'Heures ajoutées avec succès.');
    }

    function destroy($id)
    {
        $heure = HeureCaissier::findOrFail($id);
        $heure->delete();

        return redirect()->route('heure-caissiers.index')->with('success', 'Heures supprimées avec succès.');
    }
}
