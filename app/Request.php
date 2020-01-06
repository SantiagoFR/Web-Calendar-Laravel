<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
