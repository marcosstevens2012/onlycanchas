<?php

use Illuminate\Database\Seeder;
use App\Cancha;

class cancha_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           
            'deporte'=>'Futbol', 
            'capacidad' => '10',
            'tipo' => 'cesped', // secret
            'numero' => '1',

        ]);

        User::create([
           
            'deporte'=>'Padle', 
            'capacidad' => '2',
            'tipo' => 'cesped', // secret
            'numero' => '1',

        ]);
    }
}
