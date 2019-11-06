<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Persona;

class cliente_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Persona::create([
        
            'nombre'            =>'Marcos',
            'apellido'       =>'Stevens',
            'telefono'       =>'3743562805',
            'email'       =>'marcosstevens2012@gmail.com',
            'documento'       =>'38567656',
            'direccion'       =>'calle 2',
            
        ]);

    }
}
