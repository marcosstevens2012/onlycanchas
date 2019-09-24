<?php

namespace sisCancha\Http\Controllers;

use Illuminate\Http\Request;
use sisCancha\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use sisCancha\Http\Requests\IngresoFormRequest;
use Illuminate\Support\Facades\Validator;
use sisCancha\Ingreso;
use sisCancha\Turno;
use sisCancha\Insumo;
use sisCancha\DetalleIngreso;

use sisCancha\Event;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use DB;
use Carbon\Carbon; //Fecha zona horaria
use Response;
use Illuminate\Support\Collection;

class InicioController extends Controller
{

     public function __construct(){
        
        $this->middleware('auth');

    }
	public function index(Request $request){

            $searchtext = $request->get('idcancha');

            $cancha = $request->get('idcancha');

            $canchas = DB::table('cancha as c')
            ->groupBy('c.deporte')
            ->get();

            $fecha=Carbon::now();

    		$turnos = DB::table('turno')
            ->count();

            $turnosconsultorio = DB::table('turno')
            ->where('idestado','=',3)
            ->count();

            $turnospendientes = DB::table('turno')
            ->join('estado_turno as est','est.idestado_turno','=','turno.idestado')
            ->select('turno.*')
    		->where('est.estado','=','Pendiente')
      		->count();

            $finalizados = DB::table('turno')
            ->join('estado_turno as est','est.idestado_turno','=','turno.idestado')
            ->select('turno.*')
            ->where('est.estado','=','Finalizado')
            ->count();

            $usuarioactual=\Auth::user();
            $data=DB::table('turno as t')
                ->join('cancha as can','can.idcancha','=','t.idcancha')
                ->join('estado_turno as est','t.idestado','=','est.idestado_turno')
                ->select('t.fecha',DB::raw('CONCAT(t.fecha, " ",t.hora_inicio) AS hora_inicio'),DB::raw('CONCAT(t.fecha, " ",t.hora_fin) AS hora_fin'),DB::raw('CONCAT(can.numero," ",t.hora_inicio, " ",t.hora_fin) AS numero'), 't.idcancha')
                ->where('t.idestado','!=','2')
                ->where('t.idestado','!=','6')
                ->where('can.deporte','=',$searchtext)
                ->get();
                $events = [];
                
            if ($searchtext == 'Futbol'){
                $data=DB::table('turnofutbol as t')
                ->join('cancha as can','can.idcancha','=','t.idcancha')
                ->join('estado_turno as est','t.idestado','=','est.idestado_turno')
                ->join('cliente as cli','cli.idcliente','=','t.idcliente')
                ->join('persona as p','p.idpersona','=','cli.idpersona')
                ->select('t.fecha',DB::raw('CONCAT(t.fecha, " ",t.hora_inicio) AS hora_inicio'),DB::raw('CONCAT(t.fecha, " ",t.hora_fin) AS hora_fin'),DB::raw('CONCAT(can.numero," - ",t.hora_inicio, " ",t.hora_fin, "-", p.nombre) AS numero'), 't.idcancha')
                ->where('t.idestado','!=','2')
                ->where('t.idestado','!=','6')
                ->where('can.deporte','=',$searchtext)
                
                ->get();
            }
            
            if ($searchtext == 'Padle'){
                $data=DB::table('turno as t')
                ->join('cancha as can','can.idcancha','=','t.idcancha')
                ->join('estado_turno as est','t.idestado','=','est.idestado_turno')
                ->join('cliente as cli','cli.idcliente','=','t.idcliente')
                ->join('persona as p','p.idpersona','=','cli.idpersona')
                ->select('t.fecha',DB::raw('CONCAT(t.fecha, " ",t.hora_inicio) AS hora_inicio'),DB::raw('CONCAT(t.fecha, " ",t.hora_fin) AS hora_fin'),DB::raw('CONCAT(can.numero," ",t.hora_inicio, " ",t.hora_fin,"-", p.nombre) AS numero'), 't.idcancha')
                ->where('t.idestado','!=','2')
                ->where('t.idestado','!=','6')
                ->where('can.deporte','=',$searchtext)
                ->get();
            }
            
            
            

                //dd($data);

               
                    foreach ($data as $key => $value) {

                            $col = "";   
                              if($value->idcancha == 1)  
                              { 
                               $col = "#00c0ef"; 
                              } 
                              else if($value->idcancha == 2){ 
                               $col = "#dd4b39"; 
                              }  
                              else if ($value->idcancha == 3) 
                              {  
                               $col = "#f39c12"; 
                              } 
                              else if ($value->idcancha == 4) 
                              {  
                               $col = "#732D8D"; 
                              } 
                              else if ($value->idcancha == 5) 
                              {  
                               $col = "#880505"; 
                              } 
                              else if ($value->idcancha == 6) 
                              {  
                               $col = "#05A998"; 
                              } 
                              else if ($value->idcancha == 7) 
                              {  
                               $col = "#A98E05"; 
                              } 
                              else { 
                               $col = "93A905"; 
                              }  
                            $events[] = Calendar::event(
                            $value->numero,
                            false,
                            new \DateTime($value->hora_inicio),
                            new \DateTime($value->hora_fin),
                            null,

                            // Add color and link on event
                         [
                             'color' => $col,
                             'url' => '',   

                         ]
                        );
                    }
                
            $calendar = Calendar::addEvents($events);

                
    		return view('inicio.inicio.inicio',["espera"=> $turnosconsultorio, "turnos"=>intval(($turnospendientes/2)), "turnostotales"=>intval(($turnos/2)), "calendar"=>$calendar,"finalizados"=>$finalizados, "usuario"=>$usuarioactual, "cancha"=>$cancha, "canchas"=>$canchas]);

    	}
    
}
