<?php

namespace App\Http\Controllers;

use App\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtiquetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etiquetas = Etiqueta::all();
        return view('etiquetas.index',compact('etiquetas'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $etiqueta = new Etiqueta();
        $etiqueta->name = $request->formValues['name'];
        $etiqueta->exclusive = $request->formValues['exclusive'];
        $etiqueta->approval = $request->formValues['approval'];
        $etiqueta->save();

        return "Success";
    }
    public function needApproval(Etiqueta $etiqueta)
    {
        if(Auth::user()->can('administracion_profesor')) return 0;

        return $etiqueta->approval;
    }
    public function edit(Etiqueta $etiqueta)
    {
        //
    }
    public function update(Request $request, Etiqueta $etiqueta)
    {
        $etiqueta->name = $request->formValues['name'];
        $etiqueta->exclusive = $request->formValues['exclusive'];
        $etiqueta->approval = $request->formValues['approval'];
        $etiqueta->save();

        return "Success";
    }

    public function destroy(Etiqueta $etiqueta)
    {
        $etiqueta->delete();
        return redirect()->route('etiquetas.index');
    }
}
