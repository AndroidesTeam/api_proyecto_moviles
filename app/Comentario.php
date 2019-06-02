<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table= 'comentario';

    protected $fillable= [
        'texto',
        'fecha',
        'id_curso',
        'id_user'
    ];
}
