<?php

namespace App\Http\Controllers;

use App\Evento;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hoy = now()->format('Y-m-d')." 00:00:00";
        $eventos = Auth::user()->eventos()->whereraw("start > '{$hoy}'")->take(10)->get();
        $eventos_recursivos = Auth::user()->eventos()->whereraw("start is null AND end is null")->take(10)->get()
        ->filter(function ($evento) use ($hoy) {
            return $evento->until < $hoy;
        });
        foreach ($eventos_recursivos as $evento) {
            $until = Carbon::parse($evento->rrule['until']);
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
                $newEvento->end = $date->addHour()->format("Y-m-d G:i");
                $eventos->push($newEvento);
            }
        } 
        return view('home',compact('eventos'));
    }
}
