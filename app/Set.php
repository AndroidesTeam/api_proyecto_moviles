<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $table = 'set';
    protected $fillable = ['id_evaluacion','id_pregunta','puntuacion'];

    public function evaluacion(){
        return $this->belongsTo('App\Evaluacion','id_evaluacion');
    }
}
