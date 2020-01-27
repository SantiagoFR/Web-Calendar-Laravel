<?php

namespace App\Http\Controllers;

use App\Peticion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PeticionController extends Controller
{
    public function index(Request $request)
    {
        $search = array();
        $peticiones = Peticion::orderby('confirmed');
        if (!empty($request->title) || !empty($request->description) || !empty($request->desde) || !empty($request->hasta)) {
            if (!empty($request->title)) {
                array_push($search, "title like '%{$request->title}%'");
            }
            if (!empty($request->description)) {
                array_push($search, "description like '%{$request->description}%'");
            }
            if (!empty($request->desde)) {
                $desde = Carbon::createFromFormat('d/m/Y G:i',$request->desde);
                array_push($search, "created_at > '{$desde}'");
            }
            if (!empty($request->hasta)) {
                $hasta = Carbon::createFromFormat('d/m/Y G:i',$request->hasta);
                array_push($search, "created_at < '{$hasta}'");
            }
            $search = implode(' AND ', $search);
            $peticiones = $peticiones->whereraw("{$search}");
        }
        $search = array();
        if (!empty($request->event_title) || !empty($request->event_description)) {
            if (!empty($request->event_title)) {
                array_push($search, "title like '%{$request->event_title}%'");
            }
            if (!empty($request->event_description)) {
                array_push($search, "description like '%{$request->event_description}%'");
            }
            $search = implode(' AND ', $search);
            $peticiones = $peticiones->whereHas("evento", function($q) use($search){
                $q->whereraw("{$search}");
            });
        }
        $peticiones = $peticiones->paginate(15);
        return view('peticions.index', compact('peticiones', 'request'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Peticion $peticion)
    {
        //
    }

    public function edit(Peticion $peticion)
    {
        //
    }

    public function update(Request $request, Peticion $peticion)
    {
        $peticion->confirmed = 1;
        $peticion->responsable_id = Auth::user()->id;
        $peticion->save();
        Alert::success('Se ha confirmado la solicitud');
        return redirect()->route('peticions.index');
    }

    public function destroy(Peticion $peticion)
    {
        $peticion->evento->delete();
        $peticion->delete();
        Alert::success('Se ha rechazado la solicitud');
        return redirect()->route('peticions.index');
    }
}
