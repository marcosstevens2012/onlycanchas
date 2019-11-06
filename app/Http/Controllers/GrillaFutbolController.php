<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Cancha;
use App\TurnoFutbol;
use App\Persona;
use DB;
use DataTables;
use Carbon\carbon;
class GrillaFutbolController extends Controller
{
    public function index(Request $request){ 
        
        $fechaact=Carbon::now();
        $fechaact = $fechaact->format('Y-m-d');

        if($request){
            
            
            $fecha=trim($request->get('fecha')); //del buscador
            //dd($fecha);
            
            $canchas = DB::table('cancha')
                ->where('cancha.deporte','=','Futbol')
                ->get();
                

            $horarios = DB::table('horariosfutbol as hor')->orderBy('hora','asc')
            ->select('hor.hora')
            ->get();
          
            
           
        }
        return view('turnofutbol.grilla.index',["fecha"=>$fecha, "canchas"=>$canchas, "horarios"=>$horarios, "fechaact"=>$fechaact]);
        
    }

}
