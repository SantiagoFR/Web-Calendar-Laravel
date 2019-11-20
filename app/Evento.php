<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;

class Evento extends Model
{
    use FormAccessible;

    protected $dates = [
        'start'
    ];
    protected $appends = ['full_description'];
    public function formStartAttribute($start)
    {
        return Carbon::parse($start)->format('d/m/Y G:i');
    }

    public function formEndAttribute($end)
    {
        return Carbon::parse($end)->format('d/m/Y G:i');
    }
    public function etiqueta()
    {
        return $this->belongsTo(Etiqueta::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
    public function getFullDescriptionAttribute()
    {
        if(isset($this->etiqueta)){
            $etiqueta = $this->etiqueta->name;
        }else{
            $etiqueta = "";
        }
        //con usuario funciona pero con etiqueta no????
        if(isset($this->user)){
            $user = $this->user->first()->name;
        }else{
            $user = "";
        }
        return "<p>".$this->description."</p>"."<p>Etiqueta: ".$etiqueta."</p>";
    }
}
