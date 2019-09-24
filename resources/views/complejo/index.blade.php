@extends ('layouts.admin')
@section ('content')
	<div class="row" id="crud">
                    <div class="col-md-12">
                        <!--breadcrumbs start -->
                        <ul class="breadcrumb">
                            <li><a href="#">Escritorio</a></li>
                            <li>Complejo</li>
                            <li class="active">Mis complejos</li>
                        </ul>
                        <!--breadcrumbs end -->

                    <h1 class="h1">Complejos<button type="button" class="nueva btn btn-primary btn-3d" href="javascript:void(0)" id="createNewProduct">Nueva</button></h1>
                </div>
     </div>

	<div class="row" >
                    <div class="col-md-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">Complejos</h3>
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
                                    <th>Direccion</th>
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

    <div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Nuevo Complejo</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" method="POST" id="complejoForm" role="form">
                        <input type="hidden" name="complejo_id" id="complejo_id">

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nombre" required="required" name="nombre" placeholder="Nombre">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Direccion</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required="required" id="direccion" name="direccion" placeholder="Direccion">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Telefono</label>
                            <div class="col-sm-10">
                                <input name="telefono" id="telefono" type="tel"  class="form-control" required="required"  value="{{old('telefono')}}" placeholder="Telefono" title="Ingrese un numero de telefono valido" pattern="[0-9]{9}">
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Asignar Usuario</label>
                            <div class="col-sm-10">
                                <select name="user" id="user"  class="user form-control select2-single" style="width:100%">
                                    <option>Seleccione Usuario</option>
                                    @foreach($users as $u)
                                    
                                    <option value="{{$u->id}}">{{$u->name}}</option>
                                    @endforeach
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
    <script src="{{asset('js/jquery.mask.js')}}"></script>


<script type="">
    $(document).ready(function() {  
        $('.tipo').select2();
    });

    
</script>

<script type="">

    $("#telefono").mask("9999999999");
</script>
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
        ajax: "{{ route('complejo.index') }}",
        columns: [
            {data: 'nombre', name: 'nombre'},
            {data: 'direccion', name: 'direccion'},
            {data: 'telefono', name: 'telefono'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        });

        
            $('#example').dataTable();
            $('#createNewProduct').click(function () {
                $('#saveBtn').val("create-product");
                $('#complejo_id').val('');
                $('#complejoForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
                });


        $('#saveBtn').click(function (e) {

            
            e.preventDefault();

            if($("#nombre").val() === ""){
                alert("Rellene todos los campos");
                }else{
                    $(this).html('Sending..');
            
                    $.ajax({
                          data: $('#complejoForm').serialize(),
                          url: "{{ route('complejo.store') }}",
                          type: "POST",
                          dataType: 'json',
                          success: function (data) {
                            
                              $('#complejoForm').trigger("reset");
                              $('#ajaxModel').modal('hide');
                              alert('guardado con exito');
                              table.draw();
                              
                         
                          },
                          error: function (data) {
                              console.log('Error:', data);
                              $('#saveBtn').html('Save Changes');
                          }
                    });

               }
            
        });

        $('body').on('click', '.deletecomplejo', function () {
     
        var complejoid = $(this).data("id");
        confirm("Seguro que desea suspender complejo?!");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('complejo.store') }}"+'/'+complejoid,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
            });
        });

        $('body').on('click', '.activecomplejo', function () {
     
        var complejoid = $(this).data("id");
        confirm("Seguro que desea suspender complejo?!");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('complejo.store') }}"+'/'+complejoid,
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

