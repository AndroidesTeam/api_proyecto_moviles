<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table= 'profesor';

    protected $fillable= [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'foto'
    ];
}
