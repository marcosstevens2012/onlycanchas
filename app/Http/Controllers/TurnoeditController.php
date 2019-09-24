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
use sisCancha\Profesional;
use sisCancha\Paciente;
use sisCancha\Persona;
use sisCancha\Insumo;
use sisCancha\User;
use sisCancha\Liquidacion;
use sisCancha\Prestacion;
use sisCancha\Estado_turno;
use sisCancha\Turnoestado;
use Carbon\carbon; 


use DB;


class TurnoeditController extends Controller
{
    //constructor
    
    
    public function create()
    {
        
    }

    public function buscarSaldo (Request $request){

        
    }
    public function buscarAlerta (Request $request) {

        
    }

    public function store (TurnoFormRequest $request){
         

    }
    public function show($id){
    
   
    }
    public function edit($id)
    {

        
    }
    public function update(TurnoEditFormRequest $request,$id)
    {
        
    }
    public function destroy(Request $accion,$id)
    {
        $date = Carbon::now();
        $turno=Turno::findOrFail($id);

        //dd($turno->lote);

        if($accion->val == 'C'){
        $turno->idestado=('3');
        $turno->update();
        }

        if($accion->val == 'S'){
        $turno->idestado=('4');
        $turno->update();
        }

        if($accion->val == 'F'){
        $turno->idestado=('2');
        $turno->update();
        }

        if($accion->val == 'FF'){ //FINALIZAR TURNOS FIJOS PARA UN CLIENTE

        $turnos = DB::table('turno as tur')
        ->where('tur.lote','=',$turno->lote)
        ->get();
        
        //dd($turnos);
            foreach ($turnos as $tur) {
                # code...
            
                $turno=Turno::findOrFail($tur->idturno);
                //dd($turno);
                $turno->idestado=('6');
                $turno->update();
            }
        }

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
