<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peticion extends Model
{
    public function evento(){
        return $this->belongsTo(Evento::class);
    }
    public function getColorAttribute(){
        if($this->confirmed){
            return "table-success";
        }else{
            return "table-primary";
        }
    }
}
