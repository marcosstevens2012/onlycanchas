@extends ('layouts.admin')
@section ('content')
	<div class="row" id="crud">
                    <div class="col-md-12">
                        <!--breadcrumbs start -->
                        <ul class="breadcrumb">
                            <li><a href="#">Escritorio</a></li>
                            <li>Usuarios</li>
                            <li class="active">Usuarios</li>
                        </ul>
                        <!--breadcrumbs end -->

                    <h1 class="h1">Usuario<button type="button" class="nueva btn btn-primary btn-3d" href="javascript:void(0)" id="createNewCliente">Nuevo</button></h1>
                </div>
     </div>

	<div class="row" >
                    <div class="col-md-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">Usuarios Registrados</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                          </div>
                          <div class="panel-body">
                            <table id="example" class="table data-table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>Telefono</th>
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
                    <h4 class="modal-title" id="myModalLabel"> Nuevo Usuario</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" id="clienteForm" role="form">
                        <input type="hidden" name="user_id" id="user_id">

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
                            <label for="inputPassword3" class="col-sm-2 control-label">Mail</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required="" id="mail" name="mail" placeholder="Mail">
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
                                <input type="text" class="form-control" required="" id="direccion" name="direccion" placeholder="Direccion">
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
        ajax: "{{ route('cliente.index') }}",
        columns: [
            {data: 'nombre', name: 'nombre'},
            {data: 'apellido', name: 'telefono'},
            {data: 'documento', name: 'documento'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        });

        
        //$('#example').dataTable();


        $('#createNewCliente').click(function () {
            $('#saveBtn').val("create-product");
            $('#user_id').val('');
            $('#userForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });


        $('#saveBtn').click(function (e) {

            
            e.preventDefault();
            $(this).html('Sending..');
            
            $.ajax({
                  data: $('#clienteForm').serialize(),
                  url: "{{ route('cliente.store') }}",
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
                    
                      $('#userForm').trigger("reset");
                      $('#ajaxModel').modal('hide');
                      swal('guardado con exito');
                      table.draw();
                      
                 
                  },
                  error: function (data) {
                      console.log('Error:', data);
                      $('#saveBtn').html('Save Changes');
                  }
            });
        });

        $('body').on('click', '.deleteuser', function () {
     
        var userid = $(this).data("id");
        confirm("Seguro que desea suspender user?!");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('users.store') }}"+'/'+userid,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
            });
        });

        $('body').on('click', '.activeuser', function () {
     
        var userid = $(this).data("id");
        confirm("Seguro que desea suspender user?!");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('users.store') }}"+'/'+userid,
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

