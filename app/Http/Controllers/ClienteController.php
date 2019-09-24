<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CanchaFormRequest;
use App\Cliente;
use App\Persona;
use DB;
use DataTables;


class ClienteController extends Controller
{
    //constructor
    public function __construct(){
        
        $this->middleware('auth');
    }
    public function index(Request $request){


            $clientes = Persona::all();
            if ($request->ajax()) {

            $data = Persona::latest()->get();

            $datas = Cliente::join('persona', 'persona.id', '=', 'cliente.idpersona')
            ->select('persona.*')
            ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                          
                            
                                # code...
                            
                                $btn = ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-3d deleteCancha">Eliminar</button>';

                                
                            
                                $btn =  $btn.' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-success btn-3d activeCancha">Editar</button>';
                            
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('cliente.index',compact('clientes'));
    }
    public function create()
    {
        return view("cancha.create");
    }
    public function store (Request $request)
    {   

        
        $persona = new Persona;
        $persona->nombre=$request->get('nombre');
        $persona->apellido=$request->get('apellido');
        $persona->email=$request->get('mail');
        $persona->telefono=$request->get('telefono');
        $persona->direccion=$request->get('direccion');
        $persona->save();

        $cliente = new Cliente;
        $cliente->idpersona=$persona->id;
        $cliente->condicion='Activo';


        return response()->json(['success'=>'Product saved successfully.']);
 //redirecciona a la vista cliente

    }
    public function show($id)
    {
        return view("cancha.cancha.show",["cancha"=>Cancha::findOrFail($id)]);//muestra categoria especifica
    }
    public function edit($id)
    {
        return view("profesional.cancha.edit",["cancha"=>cancha::findOrFail($id)]);
        //return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);

    }
    public function update(canchaFormRequest $request,$id)
    {
        $cancha = cancha::findOrFail($id);
        $cancha->numero=$request->get('numero');
        $cancha->piso=$request->get('piso');
        $cancha->sillas=$request->get('sillas');
        $cancha->estado=$request->get('estado');
        $cancha->update();
        return Redirect::to('profesional/cancha');
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
