@extends ('layouts.admin')
@section ('content')
	<div class="row" id="crud">
                    <div class="col-md-12">
                        <!--breadcrumbs start -->
                        <ul class="breadcrumb">
                            <li><a href="#">Escritorio</a></li>
                            <li>Canchas</li>
                            <li class="active">Mis Canchas</li>
                        </ul>
                        <!--breadcrumbs end -->

                    <h1 class="h1">Canchas<button type="button" class="nueva btn btn-primary btn-3d" href="javascript:void(0)" id="createNewProduct">Nueva</button></h1>
                </div>
     </div>

	<div class="row" >
                    <div class="col-md-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">Canchas</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                          </div>
                          <div class="panel-body">
                            <table id="example" class="table data-table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Deporte</th>
                                    <th>Tipo</th>
                                    <th>Capacidad</th>
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

    <div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> Form Modal</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" id="canchaForm" role="form">
                        <input type="hidden" name="cancha_id" id="cancha_id">

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Numero</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" required="" id="numero" name="numero" placeholder="Numero">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Capacidad</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" required="" id="capacidad" name="capacidad" placeholder="Capacidad">
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Deporte*</label>
                            <div class="col-sm-10">
                                <select name="deporte" id="deporte" class="deporte form-control"    >
                                    <option>Seleccione Deporte</option>
                                        <option value="Futbol">Futbol</option>
                                        <option value="Padle">Padle</option>
                                        <option value="Tenis">Tenis</option>
                                </select>
                            </div>
                        </div>
                        

                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Tipo</label>
                            <div class="col-sm-10">
                                <select name="tipo" id="tipo"  class="tipo form-control">
                                    <option>Seleccione Tipo</option>
                                    <option value="Cesped">Cesped</option>
                                    <option value="Piso">Piso</option>
                                </select>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="saveBtn" >Guardar</button>
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
        ajax: "{{ route('cancha.index') }}",
        columns: [
            {data: 'numero', name: 'numero'},
            {data: 'deporte', name: 'deporte'},
            {data: 'tipo', name: 'tipo'},
            {data: 'capacidad', name: 'capacidad'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        });

        
            $('#example').dataTable();
            $('#createNewProduct').click(function () {
                $('#saveBtn').val("create-product");
                $('#cancha_id').val('');
                $('#canchaForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
                });


        $('#saveBtn').click(function (e) {

            
            e.preventDefault();
            $(this).html('Sending..');
            
            $.ajax({
                  data: $('#canchaForm').serialize(),
                  url: "{{ route('cancha.store') }}",
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
                    
                      $('#canchaForm').trigger("reset");
                      $('#ajaxModel').modal('hide');
                      swal({
                          type: 'success',
                          title: 'Cancha Creada',//carga el titulo con lo q hay en el input notice
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
                      $('#saveBtn').html('Save Changes');
                  }
            });
        });

        $('body').on('click', '.deleteCancha', function () {
     
        var canchaid = $(this).data("id");
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

        $('body').on('click', '.activeCancha', function () {
     
        var canchaid = $(this).data("id");
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
