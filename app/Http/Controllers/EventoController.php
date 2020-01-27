<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Etiqueta;
use App\Peticion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EventoController extends Controller
{
    public function index()
    {
        $usuarios = User::select('name', 'id')->pluck('name', 'id');
        $etiquetas = Etiqueta::select('name', 'id')->pluck('name', 'id');
        return view('eventos.index', compact('usuarios', 'etiquetas'));
    }
    public function create()
    {

        $users = User::select('name', 'id')->where('id', "!=", Auth::user()->id)->get()->pluck('name', 'id');
        $etiquetas = Etiqueta::select('id', 'name')->pluck('name', 'id');
        return view('eventos.create', compact('etiquetas', 'users'));
    }
    public function store(Request $request)
    {
        if (!$request->recursivo) {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'start' => ['required', 'string', 'max:255'],
                'end' => ['required', 'string', 'max:255'],
                'etiqueta' => ['required', 'integer'],
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
            ]);
        }
        if ($validator->fails()) {
            return redirect()->back()->withInput()
                ->withErrors($validator);
        }
        $etiqueta = Etiqueta::find($request->etiqueta);
        if($etiqueta!=null){
            if($etiqueta->approval && !(Auth::user()->can('administracion')||Auth::user()->can('profesor'))){
                $validator = Validator::make($request->all(), [
                    'requestTitle' => ['required', 'string', 'max:255'],
                    'requestDescription' => ['nullable', 'string', 'max:255'],
                ]);
            }
        }
        if ($validator->fails()) {
            return redirect()->back()->withInput()
                ->withErrors($validator);
        }
        if($etiqueta->exclusive){
            if ($request->recursivo) {
                return redirect()->back()->withInput()->withErrors([
                    'incompatible' => 'No se puede crear un evento recursivo en una etiqueta con exclusividad'
                ]);
            }
            $start = Carbon::createFromFormat('d/m/Y G:i', $request->start);
            $end = Carbon::createFromFormat('d/m/Y G:i', $request->end);
            $eventos = Evento::whereraw("etiqueta_id = '{$etiqueta->id}' AND
            ((start <= '{$start}' and end >= '{$start}') ||
            (start <= '{$end}' and end >= '{$end}') ||
            (start < '{$start}' and end > '{$end}') ||
            (start >= '{$start}' and end <= '{$end}'))");
            if ($eventos->count() != 0) {
                return redirect()->back()->withInput()->withErrors([
                    'fecha' => 'Esa fecha no está disponible, hay un evento programado en ' . $etiqueta->name . ' desde ' .
                        Carbon::parse($eventos->first()->start)->format('d-m-Y G:i') . ' hasta ' .
                        Carbon::parse($eventos->first()->end)->format('d-m-Y G:i')
                ]);
            }
        }
        
        if(!Auth::user()->can('profesor') && !Auth::user()->can('administracion')){
            $fecha_actual = now();
            $eventos = Auth::user()->eventos()->whereraw("etiqueta_id = '{$etiqueta->id}' AND end > '{$fecha_actual}'");
            if ($eventos->count() != 0) {
                return redirect()->back()->withInput()->withErrors([
                    'fecha' => 'Ya tienes un evento pendiente en esta etiqueta, para poder crear otro evento, debes esperar a que acabe'
                ]);
            }
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

        if(!empty($request->requestTitle)) {
            $peticion = new Peticion();
            $peticion->title = $request->requestTitle;
            $peticion->description = $request->requestDescription;
            $peticion->evento_id = $evento->id;
            $peticion->save();
            Alert::success("Se ha enviado una petición para el evento");
        }else{
            Alert::success("Se ha creado el evento");
        }
        return redirect()->route('eventos.index');
    }
    public function edit(Evento $evento)
    {
        $users = User::select('name', 'id')->where('id', "!=", Auth::user()->id)->get()->pluck('name', 'id');
        $etiquetas = Etiqueta::select('id', 'name')->pluck('name', 'id');

        return view('eventos.edit', compact('evento', 'users', 'etiquetas'));
    }
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
    public function destroy(Evento $evento)
    {
        if($evento->peticion != null) $evento->peticion->delete();
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
            if(!empty($request->creator)){
                array_push($search,"creator_id = '{$request->creator}'");
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
        $user = $request->user;
        $eventos = $eventos->filter(function ($evento) use ($start, $end, $user) {
            $filtro = 1;
            if($evento->peticion!=null)$filtro = $evento->peticion->confirmed;
            if($user!=null){
                if($evento->users()->find($user)==null)$filtro=0;
            }
            return $evento->start->gt($start) && Carbon::parse($evento->end)->lt($end) && $filtro;
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
