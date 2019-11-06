@extends ('layouts.admin')
@section ('content')
	<div class="row" id="crud">
                    <div class="col-md-12">
                        <!--breadcrumbs start -->
                        <ul class="breadcrumb">
                            <li><a href="#">Escritorio</a></li>
                            <li>Turno</li>
                            <li class="active">Mis Turnos</li>
                        </ul>
                        <!--breadcrumbs end -->

                    <h1 class="h1">Turnos<button type="button" class="nueva btn btn-primary btn-3d" href="javascript:void(0)" id="createNewTurno">Nuevo</button></h1>
                </div>
     </div>

	<div class="row" >
                    <div class="col-md-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">Turno</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                          </div>
                          <div class="panel-body">
                            <table id="example" class="table data-table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora Inicio</th>
                                    <th>Hora Final</th>
                                    <th>Cancha</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                     
                                <tbody>
                                    
                                </tbody>
                        </table>

                       </div>
                     </div>
                </div>
            </div>

    <div class="modal fade" id="ajaxModel"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" id="turnoForm" role="form">
                        <input type="hidden" name="turno_id" id="turno_id">


                        

                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Cliente</label>

                            <div class="row">
                                <div class="col-sm-6">
                                    <select name="idcliente" id="idcliente"  class="selectcliente idcliente form-control" style="width:100%">
                                        <option>Seleccione Cliente</option>
                                        @foreach($clientes as $c)
                                            <option value="{{$c->id}}">{{$c->nombre}} {{$c->apellido}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary btn-3d" href="javascript:void(0)" id="createNewCliente">Nuevo</button>
                                </div>
                            </div>
                           
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Cancha</label>
                            <div class="col-sm-10">
                                <select name="idcancha" id="idcancha"  class="selectcancha idcancha form-control select2-single" style="width:100%">
                                    <option>Seleccione Cancha</option>
                                    @foreach($canchas as $c)
                                        <option value="{{$c->id}}">{{$c->numero}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Fecha</label>
                            <div class="col-sm-10">
                                <input type="date" class="fecha form-control" required="" id="fecha" name="fecha" data-date-format="mm/dd/yyyy" min="<?php echo date("Y-m-d");?>" data-date-format="mm/dd/yyyy">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Hora Inicio</label>
                            <div class="col-sm-10">
                                <select name="hora_inicio" id="hora_inicio"  class="hora_inicio form-control select2-single" style="width:100%">
                                    <option>Seleccione Hora</option>
                                    @foreach($horarios as $h)
                                        <option value="{{$h->hora}}">{{$h->hora}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Hora Fin</label>
                            <div class="col-sm-10">
                                <input class="hora_fin form-control" id="hora_fin" name="hora_fin">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Turno Fijo</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="turnofijo" value="1"> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Cantidad Semanas</label>
                            <div class="col-sm-10">
                                <input type="number" name="cantidadsemanas" value="cantidadsemanas" id="cantidadsemanas" class="form-control" max="50" style="width:20%">
                            </div>
                        </div>
                        <input type="num" name="cancha" id="cancha" style="visibility: hidden;" readonly class="form-control" placeholder="Consultorio">
                        <input type="num" name="cliente" id="cliente" style="visibility: hidden;" readonly class="form-control" placeholder="Consultorio">
                    </form>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="saveBtn" >Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModeledit"  role="dialog" aria-labelledby="myModalLabeledit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabeledit"></h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" id="turnoFormedit" role="form">
                        <input type="hidden" name="turno_id_edit" id="turno_id_edit">

                

                        
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Estado</label>
                            <div class="col-sm-10">
                                <select name="estado" id="estado"  class="estado form-control select2-single" style="width:100%">
                                    <option>Seleccione Estado</option>
                                     @foreach($estados as $e)
                                        <option value="{{$e->id}}">{{$e->estado}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        


                    
                    </form>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="saveBtnedit" >Guardar</button>
                </div>
            </div>
        </div>
    </div>


     <div class="modal fade" id="ajaxModelcliente"  role="dialog" aria-labelledby="myModalLabelcliente" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabelcliente">Nuevo Cliente</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" id="clienteForm" role="form">
                        <input type="hidden" name="cliente_id" id="cliente_id">

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required="" id="nombre" name="nombre" placeholder="Nombre">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Apellido</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required="" id="apellido" name="apellido" placeholder="Apellido">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Dni</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control"  id="dni" name="dni" placeholder="Dni">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Mail</label>
                            <div class="col-sm-10">
                                <input type="mail" class="form-control"  id="mail" name="mail" placeholder="Mail">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Telefono</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required="" id="telefono" name="telefono" placeholder="Telefono">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Direccion</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  id="direccion" name="direccion" placeholder="Direccion">
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveBtncliente" >Guardar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="{{asset('/js/application.js')}}"></script>
    <script src="{{asset('plugins/dataTables/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('plugins/dataTables/js/dataTables.bootstrap.js')}}"></script>

<script>
     
    $(document).ready(function() {  
        
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });



        var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('turnofutbol.index') }}",
        columns: [
            {data: 'fecha', name: 'fecha'},
            {data: 'hora_inicio', name: 'hora_inicio'},
            {data: 'hora_fin', name: 'hora_fin'},
            {data: 'numero', name: 'numero'},
            {data: 'cliente', name: 'cliente'},
            {data: 'fijo', name: 'fijo'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        });

        
            $('#example').dataTable();

            $('#createNewTurno').click(function () {
                $('#saveBtn').val("create-product");
                $('#turno_id').val('');
                $('#turnoForm').trigger("reset");
                $('#myModalLabel').html("Crear Turno Futbol");
                $('#ajaxModel').modal('show');
            });

            $('#createNewCliente').click(function () {
                //$('#ajaxModel').modal('hide');
                $('#saveBtncliente').val("create-cliente");
                $('#cliente_id').val('');
                $('#clienteForm').trigger("reset");
                $('#myModalLabelcliente').html("Crear Cliente");
                $('#ajaxModelcliente').modal('show');

            });

            //FORMULARIO EDIT
            $('body').on('click', '.editTurno', function () {
              var turno_id = $(this).data('id');
             
              $.get("{{ route('turnofutbol.index') }}" +'/' + turno_id +'/edit', function (data) {
                  $('#modelHeading').html("Edit Product");
                  $('#saveBtn').val("edit-turno");
                  $('#ajaxModeledit').modal('show');
                  $('#turno_id_edit').val(turno_id);

            
              })
           });
            //GUARDAR CLIENTE

        $('#saveBtncliente').click(function (e) {

            
            e.preventDefault();
            $(this).html('Enviando..');
            
            $.ajax({
                  data: $('#clienteForm').serialize(),
                  url: "{{ route('cliente.store') }}",
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
                    
                      

                      $('#ajaxModelcliente').modal('hide');
                      swal({
                          title: 'Bien!',
                          text: 'Cliente Creado Correctamente',
                          type: 'success',
                          confirmButtonText: 'OK'
                            })
                    $('selectcliente').empty();
                     $.each(data,function(key, registro) {
                        $("#idcliente").append('<option value='+registro.id+'>'+registro.nombre+' '+registro.apellido+'</option>');
                        });   


                      $('#saveBtncliente').html('Guardar');
                      
                 
                  },
                  error: function (data) {
                      console.log('Error:', data);
                      $('#saveBtncliente').html('Guardar');
                  }
            });
        });

        //GUARDAR
        $('#saveBtn').click(function (e) {

            
            e.preventDefault();
            $(this).html('Enviando..');
            
            $.ajax({
                  data: $('#turnoForm').serialize(),
                  url: "{{ route('turnofutbol.store') }}",
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
                    
                      $('#turnoForm').trigger("reset");
                      $('#ajaxModel').modal('hide');
                      swal({
                          type: 'success',
                          title: 'Turno Creado',//carga el titulo con lo q hay en el input notice
                          showConfirmButton:true,
                          confirmButtonText:"Aceptar",
                          width:"30%",
                          padding: '10em',
                          showLoaderOnConfirm: true,
                        });
                      table.draw();
                      
                 
                  },
                  error: function (data) {
                      console.log('Error:', data);
                      $('#saveBtn').html('Guardar Cambios');
                  }
            });
        });

        //EDITAR

        $('#saveBtnedit').click(function (e) {

            
            e.preventDefault();
            $(this).html('Enviando..');
            
            $.ajax({
                  data: $('#turnoFormedit').serialize(),
                  url: "{{ route('turnofutbol.actualizar') }}",
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
                    
                      $('#turnoFormedit').trigger("reset");
                      $('#ajaxModeledit').modal('hide');
                      swal({
                          type: 'success',
                          title: 'Turno Editado',//carga el titulo con lo q hay en el input notice
                          showConfirmButton:true,
                          confirmButtonText:"Aceptar",
                          width:"30%",
                          padding: '10em',
                          showLoaderOnConfirm: true,
                        });
                      table.draw();
                      
                 
                  },
                  error: function (data) {
                      console.log('Error:', data);
                      $('#saveBtn').html('Guardar Cambios');
                  }
            });
        });

        $('body').on('click', '.deleteTurno', function () {
     
        var turnoid = $(this).data("id");
        confirm("Seguro que desea suspender turno?!");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('turnofutbol.store') }}"+'/'+turnoid,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
            });
        });

        $('body').on('click', '.activeCancha', function () {
     
        var turnoid = $(this).data("id");
        confirm("Seguro que desea suspender cancha?!");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('cancha.store') }}"+'/'+canchaid,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
            });
        });
    });

        


    </script>
<script type="text/javascript">
    function CheckTime(str) 
            { 
            hora=str.value; 
            if (hora=='') { 
            return; 
            } 
            if (hora.length>8) { 
            swal("Introdujo una cadena mayor a 8 caracteres"); 
            return; 
            } 
            if (hora.length!=5) { 
            swal("Introducir HH:MM"); 
            return; 
            } 
            a=hora.charAt(0); //<=2 
            b=hora.charAt(1); //<4 
            c=hora.charAt(2); //: 
            d=hora.charAt(3); //<=0 
            e=hora.charAt(5); //: 
            f=hora.charAt(6); //<=0 
            if ((a==2 && b>3) || (a>2)) { 
            swal("El valor que introdujo en la Hora no corresponde, introduzca un digito entre 00 y 23"); 
            return; 
            } 
            if (d>0) { 
            swal("El valor que introdujo en los minutos no corresponde, introduzca un digito entre 00 y 59"); 
            return; 2
            } 
            if (f>0) { 
            s("El valor que introdujo en los segundos no corresponde"); 
            return; 
            } 
            if (c!=':') { 
            swal("Introduzca el caracter ':' para separar la hora, los minutos y los segundos"); 
            return; 
            } 
            } 

</script> 





<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('focusout','.fecha',function(){

            datoscancha = ($("#idcancha option:selected").val());
            console.log(datoscancha)


            if(datoscancha == "vacio"){
                document.getElementById("hora_inicio").disabled = true;
                swal("Debe seleccionar cancha");
            }else{
                document.getElementById("hora_inicio").disabled = false;
            }

            var fecha=$(this).val();
            var cancha=$("#idcancha option:selected").val();
            console.log(fecha);
            console.log(cancha);
            
            var div=$(this).parent();
            $('#hora_inicio').empty();
            //$('hora_inicio').empty().append('whatever');
            var op=" ";
            
            $.ajax({
                type:'get',
                url:'{!!URL::to('buscarHorarioFutbol')!!}',
                data:{'idcancha': cancha, 'fecha': fecha},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                        console.log('success');

                        
                        horariosocu = data[1];
                        horariosdis = data[0];
                        
                        
                        var i;
                        var z =0; 
                        var k=0;

                        

                        var horariosocupados = [];
                        var horariosdisponibles = [];


                        console.log(horariosocu);
                        console.log(horariosdis);

                        for (i = 0; i < horariosdis.length; i++) { 
                            for (z = 0; z < horariosocu.length; z++) { 
                                if (horariosdis[i].hora == horariosocu[z].hora_inicio){

                                    if (i-1 > 0) {
                                        var hora = horariosdis[i-1].hora;
                                        horariosocupados.push(hora);
                                    }

                                    var hora = horariosdis[i].hora;
                                    horariosocupados.push(hora);

                                    if (i+1 < horariosdis.length) {

                                        var hora = horariosdis[i+1].hora;
                                        horariosocupados.push(hora);
                                    }   
                                    
                                    
                                    
                                } 
                    
                            }
                        }

                        for (i = 0; i < horariosdis.length; i++) { 
                            

                                    var hora = horariosdis[i].hora;
                                    
                                    horariosdisponibles.push(hora); 
                                    
                                

                            
                        }   
                        //console.log(horariosdisponibles);


                                for (i = 0; i < horariosdisponibles.length; i++) { 
                                    console.log(z);
                                    while (k < horariosocupados.length) {

                                        

                                            var pos = horariosdisponibles.indexOf(horariosocupados[k]);
                                            var elementoEliminado = horariosdisponibles.splice(pos, 1);

                                            
                                            console.log(horariosdisponibles);
                                        
                                        k++;
                                }
                            }
                        $('#hora_inicio').append('<option value="">Seleccione Hora</option>');
                        for (i = 0; i < horariosdisponibles.length; i++) {
                            $('#hora_inicio').append($('<option>', { 
                                value: horariosdisponibles[i],
                                text : horariosdisponibles[i] 
                            }));
                            
                        }

                        
                        
                                 
                }
                
                
            });

        });
     });  

</script> 

<script type="text/javascript">
    //PONER EN MAYUSCULA LOS INPUTS
function aMays(e, elemento) {
tecla=(document.all) ? e.keyCode : e.which; 
 elemento.value = elemento.value.toUpperCase();
}
$(".nombre").on("input", function(){
  var regexp = /[^a-zA-Z]/g;
  if($(this).val().match(regexp)){
    $(this).val( $(this).val().replace(regexp,'') );
  }
});
</script>
<script>
        $(document).ready(function(){
            $('#clienterap').click(function(){
                $('#clienterapido').show();
                $('#label').show();
            });


            $('#idcliente').change(function(){
                console.log($('#idcliente').val());

                if($('#idcliente').val() != 'nada'){
                    $('#clienterapido').hide();
                    $('#label').hide();
                    $('#clienterap').attr("disabled", true);
                }

                else {
                    $('#clienterap').attr("disabled", false);
                }

            });
        });
</script>
<script>
        
        $(document).ready(function() {


        $('#clienterapido').hide();
        $('#label').hide();
        $('#divocultamuestra').hide();
            
        $('.hora_inicio').select2();

        $('.idcancha').select2();
        
        $('.idcliente').select2();

    });
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('change','.hora_inicio',function(e){
            e.stopPropagation();
            
            inicio = $('#hora_inicio option:selected').text();
            fin = '01:00';
            console.log(inicio);

              
              inicioMinutos = parseInt(inicio.substr(3,2));
              inicioHoras = parseInt(inicio.substr(0,2));
              
              
              finMinutos = parseInt(fin.substr(3,2));
              finHoras = parseInt(fin.substr(0,2));

              transcurridoMinutos = finMinutos + inicioMinutos;
              transcurridoHoras = finHoras + inicioHoras;
              
              console.log(transcurridoMinutos);
              console.log(transcurridoHoras);

              if (transcurridoMinutos > 59) {
                transcurridoHoras++;
                transcurridoMinutos = transcurridoMinutos - 60 ;
              }
              
              if (transcurridoHoras != 24) {
                horas = transcurridoHoras.toString();
                minutos = transcurridoMinutos.toString();
              }

              if(transcurridoHoras == 24){
                horas = "0";
                minutos = transcurridoMinutos.toString();
              }

              if (horas.length < 2) {
                horas = "0"+horas;
              }
              
              if (minutos.length < 2) {
                minutos = "0"+minutos;
              }

            document.getElementById("hora_fin").value = horas+":"+minutos;

 



        });

    });
</script>