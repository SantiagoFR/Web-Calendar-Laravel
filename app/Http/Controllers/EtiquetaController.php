<?php

namespace App\Http\Controllers;

use App\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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

        Alert::success("Etiqueta creada", "La etiqueta '{$etiqueta->name}' ha sido creada correctamente");

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
        Alert::success("Etiqueta modificada", "La etiqueta '{$etiqueta->name}' ha sido modificada correctamente");
        return "Success";
    }

    public function destroy(Etiqueta $etiqueta)
    {
        Alert::success("Etiqueta eliminada", "La etiqueta '{$etiqueta->name}' ha sido eliminada correctamente");
        $etiqueta->delete();
        return redirect()->route('etiquetas.index');
    }
}
