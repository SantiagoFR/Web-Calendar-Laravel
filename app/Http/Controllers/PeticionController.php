<?php

namespace App\Http\Controllers;

use App\Peticion;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PeticionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peticiones = Peticion::orderby('confirmed')->get();
        return view('peticions.index',compact('peticiones'));
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
     * @param  \App\Peticion  $peticion
     * @return \Illuminate\Http\Response
     */
    public function show(Peticion $peticion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Peticion  $peticion
     * @return \Illuminate\Http\Response
     */
    public function edit(Peticion $peticion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Peticion  $peticion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peticion $peticion)
    {
        $peticion->confirmed = 1;
        $peticion->save();
        Alert::success('Se ha confirmado la solicitud');
        return redirect()->route('peticions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Peticion  $peticion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peticion $peticion)
    {
        $peticion->evento->delete();
        $peticion->delete();
        Alert::success('Se ha rechazado la solicitud');
        return redirect()->route('peticions.index');
    }
}
