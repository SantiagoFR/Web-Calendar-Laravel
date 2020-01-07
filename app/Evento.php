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
        'start',
    ];
    protected $hidden = ['rrule_data','etiqueta_id',];
    protected $appends = ['full_description','belongs'];
    public function formStartAttribute($start)
    {
        if($start == null) return null;
        return Carbon::parse($start)->format('d/m/Y G:i');
    }

    public function formEndAttribute($end)
    {
        if($end == null) return null;
        return Carbon::parse($end)->format('d/m/Y G:i');
    }
    public function formUsersAttribute()
    {
        return $this->users()->get()->pluck('id');
    }
    public function formUntilAttribute()
    {
        if ($this->rrule_data == null)return null;
        return Carbon::parse($this->rrule['until'])->format("d/m/Y");
    }
    public function getUntilAttribute()
    {
        if ($this->rrule_data == null)return null;
        return Carbon::parse($this->rrule['until']);
    }
    public function formDtstartAttribute()
    {
        if ($this->rrule_data == null)return null;
        return Carbon::parse($this->rrule['dtstart'])->format("d/m/Y G:i");
    }
    public function getDtstartAttribute()
    {
        if ($this->rrule_data == null)return null;
        return Carbon::parse($this->rrule['dtstart']);
    }
    public function formByweekdayAttribute()
    {
        if ($this->rrule_data == null)return null;
        return explode(",",$this->rrule['byweekday']);
    }

    public function etiqueta()
    {
        return $this->belongsTo(Etiqueta::class)->select('etiquetas.id','name');
    }
    public function creator()
    {
        return $this->belongsTo(User::class)->select('users.id','name');
    }
    public function request()
    {
        return $this->hasOne(Request::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->select('users.id','name');
    }
    public function getBelongsAttribute(){
        if(Auth::user()->id == $this->creator_id)return true;
        if(in_array(Auth::user()->id,$this->users()->select('users.id')->get()->pluck('id')->toArray()))return true;
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
    public function formDurationAttribute()
    {
        return "02:00";
    }
    public function getRruleAttribute()
    {
        if($this->rrule_data == null) return null;
        $rrule = explode(";",$this->rrule_data);
        $until = Carbon::createFromFormat('d/m/Y',$rrule[4])->format("Y-m-d");
        $dtstart = Carbon::createFromFormat('d/m/Y G:i',"$rrule[3]")->format('Y-m-d\TG:i:s');
        return array( 'freq' => $rrule[0], 'interval' => $rrule[1],
        'dtstart' => $dtstart, 'until' => $until,'byweekday'=>$rrule[2]);
    }
}
