<?php

namespace sisCancha\Http\Controllers;

use Illuminate\Http\Request;
use sisCancha\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisCancha\Http\Requests\TurnoFormRequest;
use sisCancha\Http\Requests\TurnoEditFormRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use sisCancha\Turno;
use sisCancha\Turnoestado;
use sisCancha\Cancha;
use sisCancha\Cliente;
use sisCancha\Persona;
use sisCancha\User;
use Carbon\carbon; 


use DB;


class TurnoController extends Controller
{
    //constructor
    public function __construct(){
        
        $this->middleware('auth');

    }
    public function index(Request $request){ 
        
        $fechaact=Carbon::now();
        $fechaact = $fechaact->format('Y-m-d');

        if($request){
            
            
            $fecha=trim($request->get('fecha')); //del buscador
            //dd($fecha);
            

            if( $fecha == ""){
                
                $turnos=DB::table('turno as t')
                    ->join('cancha as can','can.idcancha','=','t.idcancha')
                    ->join('cliente as cli','cli.idcliente','=','t.idcliente')
                    ->join('persona as p','p.idpersona','=','cli.idpersona')
                    ->join('estado_turno as est','t.idestado','=','est.idestado_turno')
                    ->where('can.deporte','=','padle')
                    ->where('t.idestado','!=',2)
                    ->where('t.idestado','!=',6)
                    ->where('t.fecha','=',$fechaact)
                ->get();

                


                /*foreach ($turnos as $tur) {
                

                    if ($tur->fecha < $fechaact){
                            $turno=Turno::findOrFail($tur->idturno);
                            $turno->idestado=('6');
                            $turno->update();
                            //dd($tur->idturno);
                        }
                    }*/
                
        //dd($turnos);
            }

            if( $fecha != ""){
                
                $turnos=DB::table('turno as t')
                    ->join('cancha as can','can.idcancha','=','t.idcancha')
                    ->join('cliente as cli','cli.idcliente','=','t.idcliente')
                    ->join('persona as p','p.idpersona','=','cli.idpersona')
                    ->join('estado_turno as est','t.idestado','=','est.idestado_turno')
                    ->where('can.deporte','=','padle')
                    ->where('t.idestado','!=',2)
                    ->where('t.idestado','!=',6)
                    ->where('t.fecha','=',$fecha)
                ->get();

                /*foreach ($turnos as $tur) {
                

                if ($tur->fecha < $fechaact){
                        $turno=Turno::findOrFail($tur->idturno);
                        $turno->idestado=('6');
                        $turno->update();
                        //dd($tur->idturno);
                    }
                }*/
                
        //dd($turnos);
            }
           
        }
        return view('turno.turno.index',["turnos"=>$turnos,  "fecha"=>$fecha]);
        
    }
    public function create()
    {
        $horarios = DB::table('horarios as hor')->orderBy('hora','asc')
        ->select('hor.hora')
        ->get();

        $personas = DB::table('persona as p')
        ->join('cliente as cli','p.idpersona','=','cli.idpersona')
        ->select('p.nombre as nombre','p.apellido as apellido','p.idpersona','cli.idcliente','p.documento')
        ->where('cli.condicion','=','Activo')
        ->orderBy('p.apellido','asc')
        ->get();
    
        $canchas = DB::table('cancha')
        ->where('deporte','=','padle')
        ->where('estado','=','Activo')
        ->get();

        $fechas = DB::table('turno as t')->select('hora_inicio','fecha')
        ->get();

        $fechamax = Carbon::now();
        $fechamax = $fechamax->format('d-m-Y');


        return view("turno.turno.create",["horarios"=>$horarios,"personas"=>$personas, "canchas"=>$canchas, "fechamax"=>$fechamax]);
    }

   public function buscarHorario(Request $request){
        
            $hora = Carbon::now();
            $horaactual = $hora->toTimeString();    
            
            $fecha = Carbon::now();
            $fechaactual = $fecha->format('Y-m-d');

            $fechas = DB::table('turno as t')
            ->select('t.hora_inicio','hora_fin')
            ->where('fecha','=',$request->fecha)
            ->where('idcancha','=',$request->idcancha)
            ->where('idestado','!=','6')
            ->where('t.idestado','!=','2')
            ->get();

            $data = DB::table('horarios')
                ->get();

            if (is_null($fechas)) {
                return  response()->json($data);
            } 
            
            if($request->fecha == $fechaactual){
                $data = DB::table('horarios as hor')
                ->select('hor.hora')
                ->where('hor.hora','>',$horaactual)
                ->get();
            }

            $c=array();
            $c[0]=$data;
            $c[1]=$fechas;
            return response()->json($c);

     }

     public function buscarHorario2(Request $request){
        
            $hora = Carbon::now();
            $horaactual = $hora->toTimeString();    
            
            $fecha = Carbon::now();
            $fechaactual = $fecha->format('Y-m-d');

            $data = DB::table('turno as t')
            ->select('t.hora_inicio','hora_fin')
            ->where('fecha','=',$request->fecha)
            ->where('idcancha','=',$request->idcancha)
            ->wherebetween('hora_fin',[$request->hora_inicio, $request->hora_fin])
            ->where('idestado','!=','6')
            ->where('t.idestado','!=','2')
            ->get();

            
            return response()->json($data);

     }


     public function buscarFecha2(Request $request){
        
        

            $data = DB::table('turno as t')
            ->where('t.idcliente', '=', $request->idcliente)
            ->orderBy('t.fecha', 'desc')
            ->get();

            
            return response()->json($data);

     }

      public function cancelar(Request $request){
        
            
            $turnos = $request->idturno;
            foreach ($turnos as $tur) {

                    $turno=Turno::findOrFail($tur);
                    $turno->idestado=('2');
                    $turno->update();  
                    
            }
            
            $data = "Cancelado Correctamente";
            
            return response()->json($data);

     }



    public function store (TurnoFormRequest $request){

         try {
            DB::beginTransaction();



        $canchafija = $request->get('idcanchafija');
        $hora_inicio = $request->get('hora_i');
        $fecha = $request->get('fechafija');
        $hora_fin = $request->get('hora_f');
        $turnofijo = $request->get('turnofijo');
        //dd($fecha);
        $cont = 0;
        $sumhor = 0; 
        $uno = 1;
       
        
        if($canchafija != null){

                            $hora1=$hora_inicio[$cont];
                            $hora2=$hora_fin[$cont];

                            $temp1 = explode(":",$hora_inicio[$cont]);
                            $temp_h1 = (int)$temp1[0];
                            $temp_m1 = (int)$temp1[1];
                            
                            $temp2 = explode(":",$hora_fin[$cont]);
                            $temp_h2 = (int)$temp2[0];
                            $temp_m2 = (int)$temp2[1];
                    
                         
                            // si $hora2 es mayor que la $hora1, invierto 
                            if( $temp_h1 < $temp_h2 ){
                                $temp  = $hora1;
                                $hora1 = $hora2;
                                $hora2 = $temp;
                            }
                            /* si $hora2 es igual $hora1 y los minutos de 
                               $hora2 son mayor que los de $hora1, invierto*/ 
                            elseif( $temp_h1 == $temp_h2 && $temp_m1 < $temp_m2){
                                $temp  = $hora1;
                                $hora1 = $hora2;
                                $hora2 = $temp;
                            }
                           
                            
                            $hora1=explode(":",$hora1);
                            $hora2=explode(":",$hora2);
                            $temp_horas = 0;
                            $temp_minutos = 0;
                         
                            
                            //resto minutos 
                            $minutos;
                            if((int)$hora1[1] < (int)$hora2[1] ){
                                $temp_horas = -1;
                                $minutos = ( (int)$hora1[1] + 60 ) - (int)$hora2[1] + $temp_minutos;
                            }
                            else
                                $minutos =  (int)$hora1[1] - (int)$hora2[1] + $temp_minutos;
                         
                            //resto horas     
                            $horas = (int)$hora1[0]  - (int)$hora2[0] + $temp_horas;
                         
                            if($horas<10)
                                $horas= '0'.$horas;
                         
                            if($minutos<10)
                                $minutos= '0'.$minutos;
                         
                            
                         
                            $diferenciahoras = $horas.':'.$minutos;
                            $dif=explode(":",$diferenciahoras);
                            
                            
                    
                            $hora1=explode(":",$hora_inicio[$cont]);
                            $hora2=explode(":",$hora_fin[$cont]);
                            $temp=0;
                            

                            $horas = (int)$hora2[0];
                            $minutoss = (int)$hora2[1];
                            $diferencia = (int)$dif[0];
                            
                           
                            if ($diferencia >= 1) { //DIFERENCIA MAYOR O IGUAL A 1, MAS DE UNA HORA RESERVADA
                                if ($turnofijo != $uno ) { //SI NO ES TURNO FIJO Y MAS DE UNA HORA RESERVADA 

                                            $cantidad = $diferencia*2;
                                            $count2 = 0;

                                            $sum_hrsf = $hora_inicio[$cont];
                                            $sum_hrs = $hora_inicio[$cont];


                                            $cantidadsemanas = intval($request->get('cantidadsemanas'));
                                            //dd($cantidadsemanas);
                                            $fecha_inicio = $fecha[$cont];
                                            $i = 0;

                                            

                                            $cantidad = $diferencia*2;
                                            
                                            $count2 = 0;

                                            $sum_hrsf = $hora_inicio[$cont];
                                            $sum_hrs = $hora_inicio[$cont];
                                            $lote= rand();

                                            while ($count2 < $cantidad) { //SE GUARDAN LA CANTIDAD DE TURNOS QUE SE CARGARON
                                                //sumo minutos 

                                                $sum_hrs = $sum_hrsf;
                                                $horaa=explode(":",$sum_hrs);
                                                //dd($horaa);

                                                $minutos=(int)$horaa[1]+30;
                                                $temp=0;

                                                while($minutos>=60){
                                                    $minutos=$minutos-60;
                                                    $temp++;
                                                }
                                                
                                                //sumo horas 
                                                $horas=(int)$horaa[0]+0+$temp;
                                                
                                                //dump($minutos);
                                                if($horas<10){
                                                    $horas= '0'.$horas;
                                                }
                                             
                                                if($minutos<10){
                                                    $minutos= '0'.$minutos;
                                                }
                                             
                                                
                                             
                                                $sum_hrsf = $horas.':'.$minutos;

                                                
                                                $turno=new Turno;
                                                $turno->user=\Auth::user()->id;
                                                $turno->idcliente=$request->get('idcliente');
                                                $turno->clienterapido=$request->get('clienterapido'); 
                                                $turno->idcancha=$canchafija[$cont];
                                                $turno->idestado=('1');
                                                $turno->hora_inicio=$sum_hrs;  
                                                $turno->fecha=$fecha[$cont];
                                                $turno->hora_fin=$sum_hrsf;
                                                $turno->lote = $lote;


                                                $data = DB::table('turno as t')
									            ->select('t.hora_inicio','hora_fin')
									            ->where('fecha','=',$turno->fecha)
									            ->where('idcancha','=',$turno->idcancha)
									            ->where('t.hora_inicio','=',$turno->hora_inicio)
									            ->where('idestado','!=','6')
									            ->where('t.idestado','!=','2')
									            ->first();

									           	//dd($data);

									            	if ($data != "") {  //CONTROLA LOS HORARIOS
									            		$r='Horarios superpuestos';
            											$o='close';
									            		return Redirect::to('turno/turno')->with('popup', $o)->with('notice', $r);
									            	}
									            	if ($data == '') {
									            		$turno->save();# code...
									            	}
                                                		

                                                $count2++;
                                                }
                                    }
                                            
                                }

                                if ($diferencia >= 1) { //DIFERENCIA MAYOR O IGUAL A 1, MAS DE UNA HORA RESERVADA
                                    if ($turnofijo = $uno ) { // mas de una hroa reservada pero turno fijo 

                                        $cantidadsemanas = intval($request->get('cantidadsemanas'));
                                        $fecha_inicio = $fecha[$cont];
                                        $i = 0;
                                        $lote= rand();
                                        while ($i < $cantidadsemanas) {


                                                $cantidad = $diferencia*2;
                                                $count2 = 0;

                                                $sum_hrsf = $hora_inicio[$cont];
                                                $sum_hrs = $hora_inicio[$cont];
                                                
                                                while ($count2 < $cantidad) { 
                                                    //sumo minutos 

                                                    $sum_hrs = $sum_hrsf;
                                                    $horaa=explode(":",$sum_hrs);
                                                    //dd($horaa);

                                                    $minutos=(int)$horaa[1]+30;
                                                    $temp=0;

                                                    while($minutos>=60){
                                                        $minutos=$minutos-60;
                                                        $temp++;
                                                    }
                                                    
                                                    //sumo horas 
                                                    $horas=(int)$horaa[0]+0+$temp;
                                                    
                                           
                                                    if($horas<10)
                                                        $horas= '0'.$horas;
                                                 
                                                    if($minutos<10)
                                                        $minutos= '0'.$minutos;
                                                 
                                                    
                                                 
                                                    $sum_hrsf = $horas.':'.$minutos;

                                                    
                                                    $turno=new Turno;
                                                    $turno->user=\Auth::user()->id;
                                                    $turno->idcliente=$request->get('idcliente');
                                                    $turno->clienterapido=$request->get('clienterapido'); 
                                                    $turno->idcancha=$canchafija[$cont];
                                                    $turno->idestado=('1');
                                                    $turno->hora_inicio=$sum_hrs;  
                                                    $turno->fecha=$fecha_inicio;
                                                    $turno->hora_fin=$sum_hrsf;
                                                    $turno->lote = $lote;
                                                    $turno->turnofijo = '1';

                                                    $data = DB::table('turno as t')
											            ->select('t.hora_inicio','hora_fin')
											            ->where('fecha','=',$turno->fecha)
											            ->where('idcancha','=',$turno->idcancha)
											            ->where('t.hora_inicio','=',$turno->hora_inicio)
											            ->where('idestado','!=','6')
											            ->where('t.idestado','!=','2')
											            ->first();

											           	//dd($data);

									            	if ($data != "") {  //CONTROLA LOS HORARIOS
									            		$r='Horarios superpuestos';
            											$o='close';
									            		return Redirect::to('turno/turno')->with('popup', $o)->with('notice', $r);
									            	}
									            	if ($data == '') {
									            		$turno->save();# code...
									            	}
                                                     
                                                    $count2++;

                                                }
                                                $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio."+ 1 week"));
                                                $count2 = 0;
                                                $i++;
                                        }
                                    //$cont=$cont+1;

                                    }
                            }
                                    

                            if ($diferencia < 1) { //DIFERENCIA MENOR A 1, MENOS DE UNA HORA RESERVADA 
                                if ($turnofijo != $uno ) {
                               
                                
                                $count2 = 0;
                                $lote= rand();
                                $sum_hrsf = $hora_inicio[$cont];
                                $sum_hrs = $hora_inicio[$cont];

                                
                                    //sumo minutos 

                                    $sum_hrs = $sum_hrsf;
                                    $horaa=explode(":",$sum_hrs);
                                    //dd($horaa);

                                    $minutos=(int)$horaa[1]+30;
                                    $temp=0;

                                    while($minutos>=60){
                                        $minutos=$minutos-60;
                                        $temp++;
                                    }
                                    
                                    //sumo horas 
                                    $horas=(int)$horaa[0]+0+$temp;
                                    
                                    //dump($minutos);
                                    if($horas<10)
                                        $horas= '0'.$horas;
                                 
                                    if($minutos<10)
                                        $minutos= '0'.$minutos;
                                 
                                    
                                 
                                    $sum_hrsf = $horas.':'.$minutos;

                                    
                                    $turno=new Turno;
                                    $turno->user=\Auth::user()->id;
                                    $turno->idcliente=$request->get('idcliente');
                                    $turno->clienterapido=$request->get('clienterapido'); 
                                    $turno->idcancha=$canchafija[$cont];
                                    $turno->idestado=('1');
                                    $turno->hora_inicio=$sum_hrs;  
                                    $turno->fecha=$fecha[$cont];
                                    $turno->hora_fin=$sum_hrsf;
                                    $turno->lote = $lote;

									$data = DB::table('turno as t')
									            ->select('t.hora_inicio','hora_fin')
									            ->where('fecha','=',$turno->fecha)
									            ->where('idcancha','=',$turno->idcancha)
									            ->where('t.hora_inicio','=',$turno->hora_inicio)
									            ->where('idestado','!=','6')
									            ->where('t.idestado','!=','2')
									            ->first();

									           	//dd($data);

									            	if ($data != "") {  //CONTROLA LOS HORARIOS
									            		$r='Horarios superpuestos';
            											$o='close';
									            		return Redirect::to('turno/turno')->with('popup', $o)->with('notice', $r);
									            	}
									            	if ($data == '') {
									            		$turno->save();# code...
									            	}

                                    $count2++;
                                }

                                    

                            }

                            if ($diferencia < 1) { //DIFERENCIA MENOR A 1, MENOS DE UNA HORA RESERVADA 
                                if ($turnofijo = $uno ) {

                                    $cantidadsemanas = intval($request->get('cantidadsemanas'));
                                    //dd($fecha[$cont]);
                                    $fecha_inicio = $fecha[$cont];
                                    $i = 0;
                                    $lote= rand();
                                    while ($i < $cantidadsemanas) {


                                        $cantidad = $diferencia*2;
                                            
                                        $count2 = 0;

                                        $sum_hrsf = $hora_fin[$cont];
                                        $sum_hrs = $hora_fin[$cont];
                                        $sum_hrs = $sum_hrsf;
                                        $horaa=explode(":",$sum_hrs);
                                        //dd($horaa);

                                        $minutos=(int)$horaa[1]-30;
                                        $temp=0;

                                        while($minutos>=60){
                                            $minutos=$minutos-60;
                                            $temp++;
                                        }
                                    
                                        //sumo horas 
                                        $horas=(int)$horaa[0]+0+$temp;
                                        
                                        //dump($minutos);
                                        if($horas<10)
                                            $horas= '0'.$horas;
                                     
                                        if($minutos<10)
                                            $minutos= '0'.$minutos;
                                     
                                        
                                     
                                        $sum_hrsf = $horas.':'.$minutos;

                                        
                                        $turno=new Turno;
                                        $turno->user=\Auth::user()->id;
                                        $turno->idcliente=$request->get('idcliente');
                                        $turno->clienterapido=$request->get('clienterapido'); 
                                        $turno->idcancha=$canchafija[$cont];
                                        $turno->idestado=('1');
                                        $turno->hora_inicio=$sum_hrsf;  
                                        $turno->fecha=$fecha_inicio;
                                        $turno->hora_fin=$sum_hrs;
                                        $turno->lote = $lote;
                                        $turno->turnofijo = '1';
                                        
                                        $data = DB::table('turno as t')
									            ->select('t.hora_inicio','hora_fin')
									            ->where('fecha','=',$turno->fecha)
									            ->where('idcancha','=',$turno->idcancha)
									            ->where('t.hora_inicio','=',$turno->hora_inicio)
									            ->where('idestado','!=','6')
									            ->where('t.idestado','!=','2')
									            ->first();

									           	//dd($data);

									            	if ($data != "") {  //CONTROLA LOS HORARIOS
									            		$r='Horarios superpuestos';
            											$o='close';
									            		return Redirect::to('turno/turno')->with('popup', $o)->with('notice', $r);
									            	}
									            	if ($data == '') {
									            		$turno->save();# code...
									            	}

                                        $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio."+ 1 week"));
                                        $i++;


                                    }
                            }
                            //$cont=$cont+1;
                        }
                        //dd($minutos);

                    /*if ($minutos == 30){
                                dd('entro');
                                if ($turnofijo = $uno ) {
                                    $cantidadsemanas = intval($request->get('cantidadsemanas'));
                                    //dd($cantidadsemanas);
                                    $fecha_inicio = $fecha[$cont];
                                    $i = 0;
                                    
                                    while ($i < $cantidadsemanas) {


                                            $cantidad = $diferencia*2;
                                            
                                            $count2 = 0;

                                            $sum_hrsf = $hora_inicio[$cont];
                                            $sum_hrs = $hora_inicio[$cont];
                                            
                                            while ($count2 < $cantidad) { 
                                                //sumo minutos 

                                                $sum_hrs = $sum_hrsf;
                                                $horaa=explode(":",$sum_hrs);
                                                //dd($horaa);

                                                $minutos=(int)$horaa[1]+30;
                                                $temp=0;

                                                while($minutos>=60){
                                                    $minutos=$minutos-60;
                                                    $temp++;
                                                }
                                                
                                                //sumo horas 
                                                $horas=(int)$horaa[0]+0+$temp;
                                                
                                       
                                                if($horas<10)
                                                    $horas= '0'.$horas;
                                             
                                                if($minutos<10)
                                                    $minutos= '0'.$minutos;
                                             
                                                
                                             
                                                $sum_hrsf = $horas.':'.$minutos;

                                                
                                                $turno=new Turno;
                                                $turno->user=\Auth::user()->id;
                                                $turno->idcliente=$request->get('idcliente');
                                                $turno->clienterapido=$request->get('clienterapido'); 
                                                $turno->idcancha=$canchafija[$cont];
                                                $turno->idestado=('1');
                                                $turno->hora_inicio=$sum_hrs;  
                                                $turno->fecha=$fecha_inicio;
                                                $turno->hora_fin=$sum_hrsf;
                                                $turno->lote = $lote;
                                                $turno->turnofijo = '1';
                                                $turno->save();
                                                 
                                                $count2++;

                                            }
                                            $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio."+ 1 week"));
                                            $i++;
                                    }
                                //$cont=$cont+1;

                                }

                            }*/
                   }
                       




        DB::commit();
            $r='El Turno ha sido Creado Correctamente';
            $o='open';
        } catch (\Exception $e) {

            //dd($e);
            DB::rollback(); 
            $r='El Turno NO ha sido Creado!.';
            $o='close';

        }
        /*
        $estados = new Turnoestado;
        $date = Carbon::now();
        $date->toDateTimeString();  
        
        $estados->idturno=$turno->idturno;
        $estados->idestado_turno=('1');
        $estados->inicio=$date;
        $estados->save();*/
        
        return Redirect::to('turno/turno')->with('popup', $o)->with('notice', $r);

    }
    public function show($id){
    $turno=DB::table('turno as t')
            ->join('turno_estado as est','t.idturno','=','est.idturno')
            ->join('estado_turno as et','est.idestado_turno','=','et.idestado_turno')
            ->select('est.inicio','est.fin','est.idturno','est.idestado_turno','et.estado','est.observaciones')
            ->where('t.idturno','=',$id)
            ->groupBy('t.idturno','et.estado')
            ->get();

    return view("turno.turno.show",["turno"=>$turno]);
    }
    public function edit($id)
    {
        $turno = Turno::findOrFail($id);

        $horarios = DB::table('horarios as hor')->orderBy('hora','asc')
        ->select('hor.hora')
        ->get();

        $pacientes = DB::table('turno as t')
        ->join('paciente as p','p.idpaciente','=','t.idpaciente')
        ->join('persona as per','per.idpersona','=','p.idpersona')
        ->where('t.idturno','=',$turno->idturno)
        ->select('per.idpersona','p.idpaciente',DB::raw('CONCAT(per.apellido, " ",per.nombre) AS paciente'))
        ->first();

        $profesional = DB::table('turno as pac')
        ->join('profesional as pro','pro.idprofesional','=','pac.idprofesional')
        ->join('persona as per','per.idpersona','=','pro.idpersona')
        ->join('consultorio as con','con.idconsultorio','=','pro.consultorio')
        ->select(DB::raw('CONCAT(per.apellido, " ",per.nombre) AS profesional'),'con.numero as consultorio','pro.idprofesional')
        ->where('pac.idturno','=',$turno->idturno)
        ->first();

        //dd($profesional);
        
        
        $estados = DB::table('estado_turno')->get();

        $prestaciones = DB::table('prestacion')->get();
        //dd($prestaciones);
        

        $fechas = DB::table('turno as t')->select('hora_inicio','fecha')
        ->first();

        $fechamax = Carbon::now();
        $fechamax = $fechamax->format('Y-m-d');
        return view("turno.turno.edit",["horarios"=>$horarios, "turno"=>$turno, "profesional"=>$profesional, "pacientes"=>$pacientes, "estados"=>$estados, "prestacion"=>$prestaciones, "fechamax"=>$fechamax]);
        
        //return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);

    }
    public function update(TurnoEditFormRequest $request,$id)
    {
        $turno=Turno::findOrFail($id);
        $turno->idestado=$request->get('estado');
        $turno->update();

        $date = Carbon::now();
        $estados = new Turnoestado;
        $estados->idturno=$turno->idturno;
        $estados->idestado_turno=$turno->idestado;
        $estados->inicio=$date;
        $estados->save();

        $cont = 0;
            /*while ($cont < count($idarticulo)) {
                $liquidacion = new Liquidacion;
                $date = Carbon::now();
                $date->toDateString();  
                $liquidacion->fecha=$date; 
                $liquidacion->paciente=$request->get('idpaciente');
                $liquidacion->profesional=$request->get('idprofesional');
                $liquidacion->idprestacion=$request->get('idprestacion');


                $obrasocial= Paciente::select('idobra_social')->where('idpaciente',$turno->idpaciente)->
                select('idobra_social')->first();

                $prestacion = $request->get('prestacion');

                $coseguro = DB::table('prestacion_obrasocial as preo')
                ->where('preo.idprestacion','=',$prestacion)
                ->where('preo.idobrasocial','=',$obrasocial->idobra_social)
                ->select('preo.coseguro')->first();

                //dd($obrasocial);
                $liquidacion->idobrasocial=$obrasocial->idobra_social;
                $liquidacion->coseguro=$coseguro->coseguro;
                $liquidacion->save();
                $cont=$cont+1;
        }*/

        return Redirect::to('turno/turno');
    }


    
    public function destroy($id)
    {
        $turno=Turno::findOrFail($id);
        $turno->idestado=('2');
        $turno->update();

        $estados = new Turnoestado;
        $date = Carbon::now();
        $date->toDateTimeString();  
        $estados->idturno=$turno->idturno;
        $estados->idestado_turno=$turno->idestado;
        $estados->fin=$date;
        $estados->save();

        
        
        return Redirect::to('turno/turno');

        
    }
}
