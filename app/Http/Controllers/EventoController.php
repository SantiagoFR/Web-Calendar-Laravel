<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Etiqueta;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
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
        $usuarios = User::select('name', 'id')->pluck('name', 'id');
        $etiquetas = Etiqueta::select('name', 'id')->pluck('name', 'id');
        return view('eventos.index', compact('usuarios', 'etiquetas'));
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
        $etiqueta = Etiqueta::find($request->etiqueta);
        if($etiqueta!=null){
            if($etiqueta->approval){  
                $validator = Validator::make($request->all(), [
                    'requestTitle' => ['required', 'string', 'max:255'],
                    'requestDescription' => ['required', 'string', 'max:255'],
                ]);       
            }
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
            if (!empty($request->byweekday)) $byweekday = implode(",", $request->byweekday);
            else $byweekday = "";
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

        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        
        $search=array();
        if(!empty($request->etiqueta)||!empty($request->user)){
            if(!empty($request->etiqueta)){
                array_push($search,"etiqueta_id = '{$request->etiqueta}'");
            }
            if(!empty($request->user)){
                array_push($search,"creator_id = '{$request->user}'");
            }
        }
        $search_final = implode(" AND ",$search);  
        if(!empty($search_final)){
            $search_final = " AND " .$search_final;
        }
        $eventos = Evento::selectRaw('id,title,description,start,end,creator_id,etiqueta_id')
            ->whereraw("rrule_data is null AND start > '{$start}' AND end < '{$end}' {$search_final}")->with('creator')->get();

        $eventos_recursivos = Evento::selectRaw('id,title,description,creator_id,etiqueta_id,rrule_data')
            ->whereraw("rrule_data is not null {$search_final}")->with('creator')->get();
         
        foreach ($eventos_recursivos as $evento) {
            $until = Carbon::parse($evento->rrule['until']);
            if ($until > $end) {
                $until = $end;
            }
            $dtstart = Carbon::parse($evento->rrule['dtstart']);
            $period = CarbonPeriod::create($dtstart, "{$evento->rrule['interval']} {$evento->rrule['freq']}s", $until);
            foreach ($period as $date) {
                $newEvento = new Evento();
                $newEvento->id = $evento->id;
                $newEvento->title = $evento->title;
                $newEvento->description = $evento->description;
                $newEvento->start = $date;
                $newEvento->etiqueta_id = $evento->etiqueta_id;
                $newEvento->creator = $evento->creator;
                $newEvento->end = $date->addHour();
                $eventos->push($newEvento);
            }
        }

        $eventos = $eventos->filter(function ($evento) use ($start, $end) {  
            return $evento->start->gt($start) && Carbon::parse($evento->end)->lt($end);
        });

        return response()->json($eventos->values());
    }
    
    public function getUsers()
    {
        $usuarios=User::select('name as text','id as value')->orderBy('text')->get();
        $vacio = new User;
        $vacio->text = "Todos";
        $vacio->value = "";
        $usuarios->prepend($vacio);
        return response()->json($usuarios);
    }
    public function getEtiquetas()
    {
        $etiquetas=Etiqueta::select('name as text','id as value')->orderBy('text')->get();
        $vacio = new Etiqueta;
        $vacio->text = "Todos";
        $vacio->value = "";
        $etiquetas->prepend($vacio);
        return response()->json($etiquetas);
    }
}
