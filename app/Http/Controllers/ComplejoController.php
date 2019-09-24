<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\complejoFormRequest;
use App\Complejo;
use App\Turno;
use App\Users;
use DB;
use DataTables;


class ComplejoController extends Controller
{
    //constructor
    public function __construct(){
        
        $this->middleware('auth');
    }
    public function index(Request $request){

        $users = Users::all();
        $complejos = Complejo::all();
        if ($request->ajax()) {
            
            $data = Complejo::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            
                          
                            if ($row->estado == 'Activo') {
                                # code...
                            
                                $btn = ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-3d deletecomplejo">Suspender</button>';
                            }

                            if ($row->estado != 'Activo') {
                                # code...
                            
                                $btn = ' <button href="javascript:void(0)" data-toggle="tooltip" type="button" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-success btn-3d activecomplejo">Activar</button>';
                            }
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('complejo.index',compact('complejos','users'));
    }
    public function create()
    {
        $users = User::all();
        return view("complejo.complejo.create", compact('users'));
    }
    public function store (Request $request)
    {   

        
        $complejo = new Complejo;
        $complejo->nombre=$request->get('nombre');
        $complejo->direccion=$request->get('direccion');
        $complejo->telefono=$request->get('telefono');
        $complejo->iduser=$request->get('user');
        $complejo->estado='Activo';
        $complejo->save();


        return response()->json(['success'=>'Product saved successfully.']);
 //redirecciona a la vista cliente

    }
    public function show($id)
    {
        return view("complejo.complejo.show",["complejo"=>complejo::findOrFail($id)]);//muestra categoria especifica
    }
    public function edit($id)
    {
        return view("profesional.complejo.edit",["complejo"=>complejo::findOrFail($id)]);
        //return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);

    }
    public function update(complejoFormRequest $request,$id)
    {
        $complejo = complejo::findOrFail($id);
        $complejo->nombre=$request->get('nombre');
        $complejo->direccion=$request->get('direccion');
        $complejo->telefono=$request->get('telefono');
        $complejo->estado=$request->get('estado');
        $complejo->update();
        return Redirect::to('profesional/complejo');
    }
    public function destroy($id)
    {
        $complejo=complejo::findOrFail($id);

        //$estado = DB::table('turno')->select('idpaciente')->where('idpaciente','=',$id)->first();
        //dd($estado);
            
            if ($complejo->estado == 'Activo') {

                $complejo->estado='Inactivo';
                $complejo->update();
            
                return response()->json(['success'=>'complejo Suspendida']);
            }


            if ($complejo->estado == 'Inactivo') {

                $complejo->estado='Activo';
                $complejo->update();
            
                return response()->json(['success'=>'complejo Activada']);
            }
            
        

        

    }

    
}
