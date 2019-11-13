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
    public function formStartAttribute($start)
    {
        return Carbon::parse($start)->format('d/m/Y G:i');
    }

    public function formEndAttribute($end)
    {
        return Carbon::parse($end)->format('d/m/Y G:i');
    }
}
