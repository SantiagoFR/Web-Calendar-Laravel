<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Evento extends Model
{
    use FormAccessible;

    protected $dates = [
        'start'
    ];
    protected $appends = ['full_description','belongs'];
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
    public function formUsuariosAttribute($usuarios)
    {
        return $this->user;
    }
    public function getBelongsAttribute(){
        if(Auth::user()->id == $this->creator_id)return true;
        dump($this->title);
        dump(in_array(Auth::user()->id,$this->user()->select('users.id')->get()->pluck('id')->toArray()));
        if(in_array(Auth::user()->id,$this->user()->select('users.id')->get()->pluck('id')->toArray()))return true;
        return false; 
    }
    public function getFullDescriptionAttribute()
    {
        if(isset($this->etiqueta)){
            $etiqueta = $this->etiqueta->name;
        }else{
            $etiqueta = "";
        }
        return $this->description."<p><strong>Etiqueta: </strong>".$etiqueta."</p>";
    }
}
