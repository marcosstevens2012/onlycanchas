<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Users;
use Illuminate\Support\Facades\Redirect;
use DB;
use DataTables;

class UsuarioController extends Controller
{
    //constructor
    public function __construct(){
         $this->middleware('auth');
    }

    public function index(Request $request){

            
            $users = Users::all();
            if ($request->ajax()) {

                $data = Users::latest()->get();
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
      
        return view('users.index',compact('users'));
    }
    public function create(){
    	return view("configuracion.usuario.create");
    }

    public function store(UsuarioFormRequest $request){
    	$usuario = new User;
    	$usuario->name=$request->get('name');
    	$usuario->email=$request->get('email');
        $usuario->email=$request->get('telefono');
        $usuario->tipo=$request->get('tipo');
        $usuario->email=$request->get('email');
    	$usuario->password=bcrypt($request->get('password'));
    	$usuario->save();


    	return response()->json(['success'=>'Usuario saved successfully.']);
    }

    
    public function edit($id){
    	return view("configuracion.usuario.edit",["usuario"=>User::findOrFail($id)]);
    }

    public function update(UsuarioFormRequest $request, $id){
    	$usuario = User::findOrFail($id);
    	$usuario->name=$request->get('name');
    	$usuario->email=$request->get('email');
    	$usuario->password=bcrypt($request->get('password'));
    	$usuario->update();
    	return Redirect::to('configuracion/usuario');
    }
    public function destroy($id){
    	$usuario = DB::table('users')->where('id','=',$id)->delete();
    	return Redirect::to('configuracion/usuario');
    }

}
