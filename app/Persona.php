<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';

    protected $fillable = [
        'nombre', 'apellido','documento','direccion','telefono','email'
    ];
}
