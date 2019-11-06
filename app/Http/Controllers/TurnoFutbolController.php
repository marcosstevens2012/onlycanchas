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


class TurnoFutbolController extends Controller
{
    //constructor
    public function __construct(){
        
        $this->middleware('auth');
    }
    public function index(Request $request){

        $turnos = DB::table('turnofutbol')
        ->join('persona', 'persona.id', '=', 'turnofutbol.id')
        ->join('cancha','cancha.id','=','turnofutbol.id')
        ->join('estado_turno','estado_turno.id','=','turnofutbol.id')
        ->select('turnofutbol.*','persona.*','cancha.*','estado_turno.estado as estadot', DB::raw('CONCAT(persona.nombre, " ",persona.apellido) AS cliente'))
        
        ->get();



        $estados = DB::table('estado_turno')->get();
        $clientes = Persona::all();
        $canchas = Cancha::all();
        $horarios = DB::table('horariosfutbol as hor')->orderBy('hora','asc')
        ->select('hor.hora')
        ->get();


        $fechamax = Carbon::now();
        $fechamax = $fechamax->format('d-m-Y');

        $fechaact=Carbon::now();
        $fechaact = $fechaact->format('Y-m-d');
        
        if ($request->ajax()) {

            
        $data = DB::table('turnofutbol')
        ->join('persona', 'persona.id', '=', 'turnofutbol.idcliente')
        ->join('cancha','cancha.id','=','turnofutbol.idcancha')
        ->join('estado_turno','estado_turno.id','=','turnofutbol.idestado')
        ->select('turnofutbol.*','persona.*','cancha.*','estado_turno.estado as estadot',DB::raw('CONCAT(persona.nombre, " ",persona.apellido) AS cliente'))
        ->orderBy('turnofutbol.created_at', 'desc')
        ->get();

        //var_dump($data);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                                $btn = ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary btn-3d editTurno">Editar</button>';


                                $btn = $btn .  ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-3d deleteCliente">Finalizar</button>';
                                if ($row->turnofijo =='1'){
                                $btn = $btn .  ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Finfijo" class="btn btn-danger btn-3d deleteCliente">Finalizar Fijo</button>';
                                }
                            
                            return $btn;
                    })
                    ->addColumn('fijo', function($row){
                                

                                if ($row->estadot=='En Cancha'){
                                    $btn = '<td align="center"><button type="button" class="btn btn-info btn-3d">'.$row->estadot.'</button>';
                                      if ($row->turnofijo =='1'){
                                          $btn = $btn . ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary btn-3d editTurno">Turno Fijo</button>';
                                      }
                                }
                               
                                elseif ($row->estadot=='Pendiente'){
                                    $btn = '<td align="center"><button type="button" class="btn btn-warning btn-3d">'.$row->estadot.'</button>';
                                        if ($row->turnofijo =='1'){
                                            $btn = $btn . ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary btn-3d editTurno">Turno Fijo</button>';
                                        }
                                       
                                }
                              
                                else{
                                    $btn = '<td align="center"><button type="button" class="btn btn-success btn-3d">'.$row->estadot.'</button>';
                                        if ($row->turnofijo =='1'){
                                            $btn = $btn . ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary btn-3d editTurno">Turno Fijo</button>';
                                        }
                                        
                                }
                               

                             


                                
                                
                            
                            return $btn;
                    })
                    ->rawColumns(['action','fijo'])
                    ->make(true);
        }

        //dd($data);
      
        return view('turnofutbol.index',compact('turnos','clientes','canchas','horarios','fechamax','estados'));
    }
    public function create()
    {

        $clientes = Persona::all();
        $canchas = Cancha::all();
        return view("turnofutbol.create", compact('clientes','canchas'));
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
    public function store (Request $request)
    {   

        
        
       

            //EDITAR
        
        

        $cont = 0;
        
        
                    if ($request->get('turnofijo') != 1 ) {
                            $lote=rand();
                            $turno=new TurnoFutbol;
                            $turno->user=\Auth::user()->id;
                            $turno->idcliente=$request->get('idcliente');
                            $turno->idcancha=$request->get('idcancha'); 
                            $turno->idestado=('1');
                            $turno->hora_inicio=$request->get('hora_inicio'); 
                            $turno->fecha=$request->get('fecha'); 
                            $turno->hora_fin=$request->get('hora_fin'); 
                            $turno->lote = $lote;
                            $turno->save();
                            $cont=$cont+1;
                    }else{
                        
                        $cantidadsemanas = intval($request->get('cantidadsemanas'));
                        //dd($cantidadsemanas);
                        $fecha_inicio = $request->get('fecha'); 
                        $i = 0;
                        $lote=rand();
                        while ($i < $cantidadsemanas) { 
                            $turno=new TurnoFutbol;
                            $turno->user=\Auth::user()->id;
                            $turno->idcliente=$request->get('idcliente');
                            $turno->idcancha=$request->get('idcancha'); 
                            $turno->idestado=('1');
                            $turno->hora_inicio=$request->get('hora_inicio'); 
                            $turno->fecha=$fecha_inicio; 
                            $turno->hora_fin=$request->get('hora_fin'); 
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
        
        

        return response()->json(['success'=>'Product saved successfully.']);
 //redirecciona a la vista cliente

    }
    public function show($id)
    {
        return view("cancha.cancha.show",["cancha"=>Cancha::findOrFail($id)]);//muestra categoria especifica
    }
    public function edit($id)
    {
        $turno = TurnoFutbol::find($id);

        return response()->json($turno);
    }
    public function actualizar (Request $request)
    {   

        $id = $request->get('turno_id_edit');   
        $turno = TurnoFutbol::findOrFail($id);
        $turno->idestado = $request->get('estado');
        $turno->update();    

         return response()->json(['success'=>'Product saved successfully.']);
    }
    public function destroy($id)
    {
        $cancha=Cancha::findOrFail($id);

        //$estado = DB::table('turno')->select('idpaciente')->where('idpaciente','=',$id)->first();
        //dd($estado);
            
            if ($cancha->estado == 'Activo') {

                $cancha->estado='Inactivo';
                $cancha->update();
            
                return response()->json(['success'=>'Cancha Suspendida']);
            }


            if ($cancha->estado == 'Inactivo') {

                $cancha->estado='Activo';
                $cancha->update();
            
                return response()->json(['success'=>'Cancha Activada']);
            }
            
        

        

    }

    

    
}
