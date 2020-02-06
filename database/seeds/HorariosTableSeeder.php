<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Horarios;


class HorariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    
    {
        $newDate = date('07:00');
        
        for ($i=0; $i < 5; $i++) { 
            # code...
            //$date->format("h:i"); 

            Horarios::create([
            
                'hora'            =>$newDate,
                
            ]);

            $newDate = strtotime ( '+30 minute' , $newDate ) ; 

        }
    }

    
}
