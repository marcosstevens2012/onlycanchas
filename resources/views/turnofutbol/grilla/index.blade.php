@extends ('layouts.admin')
@section ('content')
    <div class="row" id="crud">
                    <div class="col-md-12">
                        <!--breadcrumbs start -->
                        <ul class="breadcrumb">
                            <li><a href="#">Escritorio</a></li>
                            <li>Turno</li>
                            <li class="active">Grilla</li>
                        </ul>
                        <!--breadcrumbs end -->

                    <h1 class="h1">Grilla de Turnos Futbol<button type="button" class="nueva btn btn-primary btn-3d" href="javascript:void(0)" id="createNewTurno">Nuevo</button></h1>
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
                
                
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                               
                        
                          
                          <div class="panel-body">
                                            <div class="form-group col-lg-4 col-sm-4 col-md-8 col-xs-12">
                                                        <h4>Fecha esp.</h4>
                                                        <div >
                                                            <input  type="date" class="form-control " name="fecha" id="fecha" value="{{$fechaact}}">
                                                        </div>
                                            </div>
                                            
                                            <div class="form-group col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                                                  <h4>Buscar</h4>
                                              <span class="input-group-btn"><button onclick="buscar();"  class="btn btn-primary">Buscar</button></span>
                                            </div>


                                            <div class="form-group col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                                                  <h4>Nuevo Turno</h4>
                                              <a href="{{url('turnofutbol/turno/create')}}"><button class="btn btn-success" type="button">Nuevo</button></a>
                                            </div>
                                            


                            </div>  
                                                    
                    </div> 
              
               
 
    
    
    
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
                   

                        <div class="col-sm-4 col-md-2 ">
                         
                          
                            <h3>CANCHA 1</h3>
                           
                                    @foreach($horarios as $h)
                                        
                                            <div class="row">
                                              <div class="col-sm-12 col-md-12">
                                                  <button class="cancha1 btn btn-block btn-success btn-lg" value="{{$h->hora}}" id="cancha1">{{$h->hora}}</button>
                                              </div>
                                            </div>
                                           
                                    @endforeach

                              
                                    
                                   
                        
                          </div>
                           <div class="col-sm-4 col-md-2">
                         
                          
                            <h3>CANCHA 2</h3>
                           
                                    @foreach($horarios as $h)
                                        
                                            <div class="row">
                                              <div class="col-sm-12 col-md-12">
                                                  <button class="cancha2 btn btn-block btn-success btn-lg" value="{{$h->hora}}" id="cancha2">{{$h->hora}}</button>
                                              </div>
                                            </div>
                                           
                                    @endforeach

                              
                                    
                                   
                        
                          </div>
                           <div class="col-sm-4 col-md-2">
                         
                          
                            <h3>CANCHA 3</h3>
                           
                                    @foreach($horarios as $h)
                                        
                                            <div class="row">
                                              <div class="col-sm-12 col-md-12">
                                                  <button class="cancha3 btn btn-block btn-success btn-lg" value="{{$h->hora}}" id="cancha3">{{$h->hora}}</button>
                                              </div>
                                            </div>
                                           
                                    @endforeach

                              
                                    
                                   
                        
                          </div>
                           <div class="col-sm-4 col-md-2">
                         
                          
                            <h3>CANCHA 4</h3>
                           
                                    @foreach($horarios as $h)
                                        
                                            <div class="row">
                                              <div class="col-sm-12 col-md-12">
                                                  <button class="cancha4 btn btn-block btn-success btn-lg" value="{{$h->hora}}" id="cancha4">{{$h->hora}}</button>
                                              </div>
                                            </div>
                                           
                                    @endforeach

                              
                                    
                                   
                        
                          </div>
                           <div class="col-sm-4 col-md-2">
                         
                          
                            <h3>CANCHA 5</h3>
                           
                                    @foreach($horarios as $h)
                                        
                                            <div class="row">
                                              <div class="col-sm-12 col-md-12">
                                                  <button class="cancha5 btn btn-block btn-success btn-lg" value="{{$h->hora}}" id="cancha5">{{$h->hora}}</button>
                                              </div>
                                            </div>
                                           
                                    @endforeach

                              
                                    
                                   
                        
                          </div>
                     

                </div>
              </div>
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






<script type="text/javascript">
  

    

       function buscar() {  
      
        fecha=document.getElementById("fecha").value;
        console.log(fecha);

        
         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 1, 'fecha':fecha},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  
                  v=null;
                  console.log(data);
                  i = 0;

                  $(".cancha1").each(function(){


                  $(this).text($(this).val());
                  $(this).removeClass("btn-danger");
                  $(this).addClass("btn-success");

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 1){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                          
                      }
                    }   
                });
               }
                
                
            });

         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 2, 'fecha':fecha},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  
                  
                  console.log(data);
                  i = 0;

                  $(".cancha2").each(function(){
                 $(this).text($(this).val());
                  $(this).removeClass("btn-danger");
                  $(this).addClass("btn-success");

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 4){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                           
                      }
                    }   
                });
               }
                
                
            });

         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 3, 'fecha':fecha},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  
                  
                  console.log(data);
                  i = 0;

                  $(".cancha3").each(function(){
                  $(this).text($(this).val());
                  $(this).removeClass("btn-danger");
                  $(this).addClass("btn-success");

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 5){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                           
                      }
                    }   
                });
               }
                
                
            });

         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 4, 'fecha':fecha},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  
                  
                  console.log(data);
                  i = 0;

                  $(".cancha4").each(function(){
                  $(this).text($(this).val());
                  $(this).removeClass("btn-danger");
                  $(this).addClass("btn-success");

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 7){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                           
                      }
                    }   
                });
               }
                
                
            });
         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 5, 'fecha':fecha},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  i = 0;

                  $(".cancha5").each(function(){
                  $(this).text($(this).val());
                  $(this).removeClass("btn-danger");
                  $(this).addClass("btn-success");

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 8){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                           
                      }
                    }   
                });
               }
                
                
            });
        };
</script>

 <script type="text/javascript">
  

    

      $(document).ready(function() {
          

         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 1},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  
                  v=null;
                  console.log(data);
                  i = 0;

                  $(".cancha1").each(function(){


                 

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 1){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                           
                      }
                    }   
                });
               }
                
                
            });

         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 2},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  
                  
                   v=null;
                  console.log(data);
                  i = 0;

                  $(".cancha2").each(function(){


                 

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 2){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                           
                      }
                    }   
                });
               }
                
                
            });
         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 3},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  
             v=null;
                  console.log(data);
                  i = 0;

                  $(".cancha3").each(function(){


                 
                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 3){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                           
                      }
                    }   
                });
               }
                
                
            });
         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 4},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  
             v=null;
                  console.log(data);
                  i = 0;

                  $(".cancha4").each(function(){


                  

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 4){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                           
                      }
                    }   
                });
               }
                
                
            });

         $.ajax({

                type:'get',
                url:'{!!URL::to('buscarTurnosFutbol')!!}',
                data:{'idcancha': 5},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                  v=null;
                  console.log(data);
                  i = 0;

                  $(".cancha5").each(function(){


                  

                  if (v != null) {
                      $(this).removeClass("btn-success");
                      $(this).addClass("btn-danger");
                      $(this).text($(this).val() + " "  + v);
                      v=null;
                  }  
                    if (i < data.length) {
                      if((data[i].hora_inicio) == $(this).val() && (data[i].idcancha) == 5){
                          $(this).removeClass("btn-success");
                          $(this).addClass("btn-danger");
                          $(this).text($(this).val() + " "  + data[i].nombre);
                         

                          v = (data[i].nombre);
                           i++;
                          
                      }
                    }   
                });
               }
                
                
            });

      

        });
        
     


</script>
