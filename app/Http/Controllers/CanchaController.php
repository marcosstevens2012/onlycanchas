<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CanchaFormRequest;
use App\Cancha;
use App\Turno;
use DB;
use DataTables;


class CanchaController extends Controller
{
    //constructor
    public function __construct(){
        
        $this->middleware('auth');
    }
    public function index(Request $request){


        $canchas = Cancha::all();
        if ($request->ajax()) {

            $data = Cancha::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                          
                            if ($row->estado == 'Activo') {
                                # code...
                            
                                $btn = ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-3d deleteCancha">Suspender</button>';
                            }

                            if ($row->estado == 'Inactivo') {
                                # code...
                            
                                $btn = ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-success btn-3d activeCancha">Activar</button>';
                            }
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('cancha.index',compact('canchas'));
    }
    public function create()
    {
        return view("cancha.cancha.create");
    }
    public function store (Request $request)
    {   

        
        $cancha = new Cancha;
        $cancha->numero=$request->get('numero');
        $cancha->capacidad=$request->get('capacidad');
        $cancha->tipo=$request->get('tipo');
        $cancha->deporte=$request->get('deporte');
        $cancha->estado='Activo';
        $cancha->save();


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
