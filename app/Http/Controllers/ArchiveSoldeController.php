<?php

namespace App\Http\Controllers;

use App\Models\ArchiveSolde;
use App\Models\User;
use Illuminate\Http\Request;

class ArchiveSoldeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $users = User::whereMonth('created_date', $month)
            ->whereYear('created_date', $year)
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArchiveSolde  $archiveSolde
     * @return \Illuminate\Http\Response
     */
    public function show(ArchiveSolde $archiveSolde)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArchiveSolde  $archiveSolde
     * @return \Illuminate\Http\Response
     */
    public function edit(ArchiveSolde $archiveSolde)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ArchiveSolde  $archiveSolde
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArchiveSolde $archiveSolde)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArchiveSolde  $archiveSolde
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArchiveSolde $archiveSolde)
    {
        //
    }
}
