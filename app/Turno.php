<?php

namespace sisCancha;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'turno';
    protected $primaryKey = 'idturno';
    public $timestamp = false;
    protected $fillable = [
    	
    ];
    protected $guarded = [

     ];
     protected $dates = ['fecha_inicio'];
}
