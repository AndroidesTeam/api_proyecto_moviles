<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table= 'pregunta';
    protected $fillable = [
        'pregunta'
    ];

    public function respuestas(){
        return $this->hasMany('App\Respuesta','id_pregunta');
    }
}
