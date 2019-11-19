<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Etiqueta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('eventos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $etiquetas = Etiqueta::select('id','name')->pluck('name','id');
        return view('eventos.create',compact('etiquetas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $evento = new Evento();
        $evento->title = $request->title;
        $evento->description = $request->description;
        $evento->start = Carbon::createFromFormat('d/m/Y G:i',$request->start);
        $evento->end = Carbon::createFromFormat('d/m/Y G:i',$request->end);
        $evento->etiqueta_id = $request->etiqueta;
        $evento->save();
        return redirect()->route('eventos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        return view('eventos.edit',compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        $evento->title = $request->title;
        $evento->description = $request->description;
        $evento->start = Carbon::createFromFormat('d/m/Y G:i',$request->start);
        $evento->end = Carbon::createFromFormat('d/m/Y G:i',$request->end);
        $evento->save();
        return redirect()->route('eventos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index');
    }

    public function provide(Request $request)
    {
        return response()->json(Evento::select('id','title','description','start','end')->get());
    }
}
