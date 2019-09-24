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
use sisCancha\TurnoFutbol;
use sisCancha\Turnoestado;
use sisCancha\Cancha;
use sisCancha\Cliente;
use sisCancha\Persona;
use sisCancha\User;
use Carbon\carbon; 


use DB;


class TurnoFutbolController extends Controller
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
                
                $turnos=DB::table('turnofutbol as t')
                    ->join('cancha as can','can.idcancha','=','t.idcancha')
                    ->join('cliente as cli','cli.idcliente','=','t.idcliente')
                    ->join('persona as p','p.idpersona','=','cli.idpersona')
                    ->join('estado_turno as est','t.idestado','=','est.idestado_turno')
                    ->where('can.deporte','=','futbol')
                    ->where('t.idestado','!=',2)
                    ->where('t.idestado','!=',6)
                    ->where('t.fecha','=',$fechaact)
                ->get();

                  foreach ($turnos as $tur) {
                

                /*if ($tur->fecha < $fechaact){
                        $turno=TurnoFutbol::findOrFail($tur->idturno);
                        $turno->idestado=('6');
                        $turno->update();
                        //dd($tur->idturno);
                    }*/
                }
            }

            if( $fecha != ""){
                $turnos=DB::table('turnofutbol as t')
                    ->join('cancha as can','can.idcancha','=','t.idcancha')
                    ->join('cliente as cli','cli.idcliente','=','t.idcliente')
                    ->join('persona as p','p.idpersona','=','cli.idpersona')
                    ->join('estado_turno as est','t.idestado','=','est.idestado_turno')
                    ->where('can.deporte','=','futbol')
                    ->where('t.idestado','!=',2)
                    ->where('t.idestado','!=',6)
                    ->where('t.fecha','=',$fecha)
                ->get();

                  foreach ($turnos as $tur) {
                

                /*if ($tur->fecha < $fechaact){
                        $turno=TurnoFutbol::findOrFail($tur->idturno);
                        $turno->idestado=('6');
                        $turno->update();
                        //dd($tur->idturno);
                    }*/
                }


            }
           
        }
        return view('turnofutbol.turno.index',["turnos"=>$turnos,  "fecha"=>$fecha]);
        
    }
    public function create()
    {
        $horarios = DB::table('horariosfutbol as hor')->orderBy('hora','asc')
        ->select('hor.hora')
        ->get();

        $personas = DB::table('persona as p')
        ->join('cliente as cli','p.idpersona','=','cli.idpersona')
        ->select('p.nombre as nombre','p.apellido as apellido','p.idpersona','cli.idcliente','p.documento')
        ->where('cli.condicion','=','Activo')
        ->orderBy('p.apellido','asc')
        ->get();
    
        $canchas = DB::table('cancha as c')
        ->where('c.deporte','=','futbol')
        ->get();

        

        $fechamax = Carbon::now();
        $fechamax = $fechamax->format('d-m-Y');


        return view("turnofutbol.turno.create",["horarios"=>$horarios,"personas"=>$personas, "canchas"=>$canchas, "fechamax"=>$fechamax]);
    }

    public function buscarHorarioFutbol(Request $request){
        
            $hora = Carbon::now();
            $horaactual = $hora->toTimeString();    
            
            $fecha = Carbon::now();
            $fechaactual = $fecha->format('Y-m-d');

            $fechas = DB::table('turnofutbol as t')
            ->select('t.hora_inicio','hora_fin')
            ->where('fecha','=',$request->fecha)
            ->where('idcancha','=',$request->idcancha)
            ->where('idestado','!=','6')
            ->where('t.idestado','!=',2)
            ->get();

            $data = DB::table('horariosfutbol')
                ->get();

            if (is_null($fechas)) {
                return  response()->json($data);
            } 
            
            if($request->fecha == $fechaactual){
	        	$data = DB::table('horariosfutbol as hor')
	            ->select('hor.hora')
	            ->where('hor.hora','>',$horaactual)
	            ->get();
	        }

            $c=array();
            $c[0]=$data;
            $c[1]=$fechas;
            return response()->json($c);

     }

     public function buscarFecha(Request $request){
        
        

            $data = DB::table('turnofutbol as t')
            ->where('t.idcliente', '=', $request->idcliente)
            ->orderBy('t.fecha', 'desc')
            ->get();


            
            return response()->json($data);

     }

    public function store (TurnoFormRequest $request){
        try {
            DB::beginTransaction();


        
        /*$obrasocial= Paciente::select('idobra_social')->where('idpaciente',$turno->idpaciente)->
        select('idobra_social')->first();*/

        /*if ($obrasocial = '7'){
            $saldo = Paciente::findOrFail($turno->idpaciente);
            $saldo->saldo = $request('costo');
            $saldo->save();
        }*/


        $canchafija = $request->get('idcanchafija');
        $hora_inicio = $request->get('hora_i');
        $fecha = $request->get('fechafija');
        $hora_fin = $request->get('hora_f');
        
        //dd($request->get('idcliente'));

        //dd($canchafija);
        $cont = 0;
        
        if($canchafija != null){
            while ($cont < count($canchafija)) {
                if($request->get('idcliente') != 'Seleccione Cliente') {
                    if ($request->get('turnofijo') != 1 ) {
                            $lote=rand();
                            $turno=new TurnoFutbol;
                            $turno->user=\Auth::user()->id;
                            $turno->idcliente=$request->get('idcliente');
                            $turno->clienterapido=$request->get('clienterapido'); 
                            $turno->idcancha=$canchafija[$cont];
                            $turno->idestado=('1');
                            $turno->hora_inicio=$hora_inicio[$cont];  
                            $turno->fecha=$fecha[$cont];
                            $turno->hora_fin=$hora_fin[$cont];
                            $turno->lote = $lote;
                            $turno->save();
                            $cont=$cont+1;
                    }else{
                        
                        $cantidadsemanas = intval($request->get('cantidadsemanas'));
                        //dd($cantidadsemanas);
                        $fecha_inicio = $fecha[$cont];
                        $i = 0;
                         $lote=rand();
                        while ($i < $cantidadsemanas) { 
                            $turno=new TurnoFutbol;
                            $turno->user=\Auth::user()->id;
                            $turno->idcliente=$request->get('idcliente');
                            $turno->clienterapido=$request->get('clienterapido'); 
                            $turno->idcancha=$canchafija[$cont];
                            $turno->idestado=('1');
                            $turno->hora_inicio=$hora_inicio[$cont];  
                            $turno->fecha=$fecha_inicio;
                            $turno->hora_fin=$hora_fin[$cont];
                            $turno->turnofijo = '1';
                            $turno->lote = $lote;
                            $turno->save();
                            $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio."+ 1 week")); 
                            //$fecha_inicio->addWeek();
                            //dd($fecha_inicio); 
                            $i++;
                        }
                        $cont=$cont+1;

                    }


                }
                else{
                    $lote=rand();
                    $persona=new Persona;
                    $persona->nombre=$request->get('clienterapido');
                    //dd($request->get('clienterapido'));
                    $persona->save();
                    $paciente=new Cliente;
                    $paciente->idpersona=$persona->idpersona;
                    $paciente->condicion='Activo';
                    $paciente->save();
                    $turno=new TurnoFutbol;
                    $turno->user=\Auth::user()->id;
                    $turno->idcliente=$paciente->idcliente;
                    $turno->idcancha=$canchafija[$cont];
                    $turno->idestado=('1');
                    $turno->hora_inicio=$hora_inicio[$cont];  
                    $turno->fecha=$fecha[$cont];
                    $turno->hora_fin=$hora_fin[$cont];
                    $turno->lote = $lote;
                    $turno->save();
                    $cont=$cont+1;
                }

            }
        }
        
        

            $estados = new Turnoestado;
            $date = Carbon::now();
            $date->toDateTimeString();  
            
            $estados->idturno=$turno->idturno;
            $estados->idestado_turno=('1');
            $estados->inicio=$date;
            $estados->save();

        DB::commit();
            $r='El Turno ha sido Creado Correctamente';
            $o='open';
        } catch (\Exception $e) {

            //dd($e);
            DB::rollback(); 
            $r='El Turno NO ha sido Creado!.';
            $o='close';

        }
        
        return Redirect::to('turnofutbol/turno')->with('popup', $o)->with('notice', $r)->with('id', $turno->idturno);

    }
    public function show($id){
    $turno=DB::table('turnofutbol as t')
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
        $turno = TurnoFutbol::findOrFail($id);

        $horarios = DB::table('horarios as hor')->orderBy('hora','asc')
        ->select('hor.hora')
        ->get();

        $pacientes = DB::table('turnofutbol as t')
        ->join('paciente as p','p.idpaciente','=','t.idpaciente')
        ->join('persona as per','per.idpersona','=','p.idpersona')
        ->where('t.idturno','=',$turno->idturno)
        ->select('per.idpersona','p.idpaciente',DB::raw('CONCAT(per.apellido, " ",per.nombre) AS paciente'))
        ->first();

        $profesional = DB::table('turnofutbol as pac')
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
        

        $fechas = DB::table('turnofutbol as t')->select('hora_inicio','fecha')
        ->first();

        $fechamax = Carbon::now();
        $fechamax = $fechamax->format('Y-m-d');
        return view("turno.turno.edit",["horarios"=>$horarios, "turno"=>$turno, "profesional"=>$profesional, "pacientes"=>$pacientes, "estados"=>$estados, "prestacion"=>$prestaciones, "fechamax"=>$fechamax]);
        
        //return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);

    }
    public function update(TurnoEditFormRequest $request,$id)
    {
        $turno=TurnoFutbol::findOrFail($id);
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

        return Redirect::to('turnofutbol/turno');
    }


    
    public function destroy($id)
    {
        $turno=TurnoFutbol::findOrFail($id);
        $turno->idestado=('2');
        $turno->update();

        $estados = new Turnoestado;
        $date = Carbon::now();
        $date->toDateTimeString();  
        $estados->idturno=$turno->idturno;
        $estados->idestado_turno=$turno->idestado;
        $estados->fin=$date;
        $estados->save();

        
        
        return Redirect::to('turnofutbol/turno');

        
    }
}
