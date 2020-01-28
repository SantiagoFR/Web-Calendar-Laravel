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
        $start = now()->format('Y-m-d') . " 00:00:00";
        $end = now()->addMonths(2);
        $eventos = Auth::user()->eventos()->whereraw("start > '{$start}' AND start < '{$end}'")->get();
        $eventos_recursivos = Auth::user()->eventos()->whereraw("rrule_data is not null")->get()
            ->filter(function ($evento) use ($start) {
                return $evento->until->gt($start);
            });
        foreach ($eventos_recursivos as $evento) {
            $until = Carbon::parse($evento->rrule['until']);
            if ($until->gt($end)) {
                $until = $end;
            }
            $dtstart = Carbon::parse($evento->rrule['dtstart']);
            $period = CarbonPeriod::create($dtstart, "{$evento->rrule['interval']} {$evento->rrule['freq']}s", $until);
            foreach ($period as $date) {
                if ($date->gt($start)) {
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
        }
        $eventos = $eventos->sortBy('start');

        return view('home', compact('eventos'));
    }
}
