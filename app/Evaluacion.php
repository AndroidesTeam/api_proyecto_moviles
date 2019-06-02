<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table= 'evaluacion';

    protected $fillable= [
        'calificacion',
        'fecha',
<<<<<<< HEAD
        'id_user',
        'id_curso'
=======
        'id_profesor',
		'id_user',
		'id_curso'
>>>>>>> 25d17aca55a93d510998b8030467b76376f7d35f
    ];

    public function set(){
        return $this->hasMany('App\Set','id_evaluacion');
    }
}
