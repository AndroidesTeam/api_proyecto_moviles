<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table= 'evaluacion';

    protected $fillable= [
        'calificacion',
        'fecha',
        'id_user',
        'id_curso'
    ];

    public function set(){
        return $this->hasMany('App\Set','id_evaluacion');
    }
}
