<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    protected $table= 'edificio';

    protected $fillable= [
        'nombre',
        'id_campus',
        'foto',
        'referencia'
    ];
}
