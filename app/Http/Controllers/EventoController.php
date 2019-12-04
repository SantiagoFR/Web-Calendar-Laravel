<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Etiqueta;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        $users = User::select('name', 'id')->where('id', "!=", Auth::user()->id)->get()->pluck('name', 'id');
        $etiquetas = Etiqueta::select('id', 'name')->pluck('name', 'id');
        return view('eventos.create', compact('etiquetas', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->recursivo) {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'start' => ['required', 'string', 'max:255'],
                'end' => ['required', 'string', 'max:255'],
                'etiqueta' => ['required', 'integer'],
                'users' => ['required', 'array', 'min:1'],
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'dtstart' => ['required', 'string', 'max:255'],
                'until' => ['required', 'string', 'max:255'],
                'freq' => ['required', 'string', 'max:255'],
                'interval' => ['required', 'integer'],
                'etiqueta' => ['required', 'integer'],
                'users' => ['required', 'array', 'min:1'],
            ]);
        }
        if ($validator->fails()) {
            return redirect()->back()->withInput()
                ->withErrors($validator);
        }
        $evento = new Evento();
        if (!$request->recursivo) {
            $evento->start = Carbon::createFromFormat('d/m/Y G:i', $request->start);
            $evento->end = Carbon::createFromFormat('d/m/Y G:i', $request->end);
        } else {
            $rrule = implode(";", [
                $request->freq,
                $request->interval,
                implode(",", $request->byweekday),
                $request->dtstart,
                $request->until
            ]);
            $evento->rrule_data = $rrule;
        }
        $evento->title = $request->title;
        $evento->description = $request->description;
        $evento->etiqueta_id = $request->etiqueta;
        $evento->creator_id = Auth::user()->id;
        $evento->save();
        $evento->users()->attach(Auth::user());
        $evento->users()->attach($request->users);
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
        $users = User::select('name', 'id')->where('id', "!=", Auth::user()->id)->get()->pluck('name', 'id');
        $etiquetas = Etiqueta::select('id', 'name')->pluck('name', 'id');
        return view('eventos.edit', compact('evento', 'users', 'etiquetas'));
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
        
        if (!$request->recursivo) {
            $evento->start = Carbon::createFromFormat('d/m/Y G:i', $request->start);
            $evento->end = Carbon::createFromFormat('d/m/Y G:i', $request->end);
        } else {  
            if(!empty($request->byweekday))$byweekday=implode(",", $request->byweekday);       
            else $byweekday="";
            $rrule = implode(";", [
                $request->freq,
                $request->interval,
                $byweekday,
                $request->dtstart,
                $request->until
            ]);
            $evento->rrule_data = $rrule;
        }
        $evento->title = $request->title;
        $evento->description = $request->description;
        $evento->etiqueta_id = $request->etiqueta;
        $evento->creator_id = Auth::user()->id;
        $evento->save();
        $evento->users()->detach();
        $evento->users()->attach(Auth::user());
        $evento->users()->attach($request->users);
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
        $eventos = Evento::select(
            'id',
            'title',
            'description',
            'start',
            'end',
            'rrule_data',
            'creator_id',
            'etiqueta_id'
        )->with('creator')->with('etiqueta')->with('users')->get();
            
        return response()->json($eventos);
    }
}
