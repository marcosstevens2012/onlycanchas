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
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                          
                            
                                # code...
                            
                                $btn = ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-3d deleteCliente">Eliminar</button>';

                                
                            
                                $btn =  $btn.' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-success btn-3d editCliente">Editar</button>';
                            
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


    public function store(Request $request)
    {
        Persona::updateOrCreate(
                ['nombre' => $request->nombre, 'apellido' => $request->apellido, 'documento' => $request->dni, 'email' => $request->mail
                , 'telefono' => $request->telefono, 'direccion' => $request->direccion]);
        $clientes = Persona::all();
        return response()->json($clientes);
    }
    
    public function show($id)
    {
        return view("cancha.cancha.show",["cancha"=>Cancha::findOrFail($id)]);//muestra categoria especifica
    }
    public function edit($id)
    {
        $cliente = Persona::find($id);
        return response()->json($cliente);
    }
    public function update(canchaFormRequest $request,$id)
    {
        $cancha = cancha::findOrFail($id);
        $cancha->numero=$request->get('numero');
        $cancha->piso=$request->get('piso');
        $cancha->sillas=$request->get('sillas');
        $cancha->estado=$request->get('estado');
        $cancha->update();

        return response()->json(['success'=>'Cliente Guardado.']);
    }
    public function destroy($id)
    {
        $cancha=Cancha::findOrFail($id);

        //$estado = DB::table('turno')->select('idpaciente')->where('idpaciente','=',$id)->first();
        //dd($estado);
            
            if ($cancha->estado == 'Activo') {

                $cancha->estado='Inactivo';
                $cancha->update();
            
                return response()->json(['success'=>'Cliente Suspendido']);
            }


            if ($cancha->estado == 'Inactivo') {

                $cancha->estado='Activo';
                $cancha->update();
            
                return response()->json(['success'=>'Cliente Activado']);
            }
            
        

        

    }

    
}
