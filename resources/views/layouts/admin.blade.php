<!DOCTYPE html>
<html>
  <head>

  	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PlayerOne</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}">
    <!-- Fonts from Font Awsome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- CSS Animate -->
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- Custom styles for this theme -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- Vector Map  -->
    <link rel="stylesheet" href="{{asset('plugins/jvectormap/css/jquery-jvectormap-1.2.2.css')}}">
    <!-- ToDos  -->
    <link rel="stylesheet" href="{{asset('plugins/todo/css/todos.css')}}">
    <!-- Morris  -->
    <link rel="stylesheet" href="{{asset('plugins/morris/css/morris.css')}}">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <!-- Feature detection -->
    <script src="{{asset('js/modernizr-2.6.2.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('/plugins/fullcalendar/css/fullcalendar.css')}}">
    <link rel="stylesheet" href="{{asset('/plugins/dataTables/css/dataTables.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('plugins/dataTables/css/dataTables.css')}}">    
    
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <script src="{{asset('js/sweetalert2.min.js')}}"></script>
  
  </head>
  <body >
    <section id="container">
        <header id="header">
            <!--logo start-->
            <div class="brand">
                <a href="index.html" class="logo"><span>Player</span>One</a>
            </div>
            <!--logo end-->
            <div class="toggle-navigation toggle-left">
                <button type="button" class="btn btn-default" id="toggle-left" data-toggle="tooltip" data-placement="right" title="Toggle Navigation">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="user-nav">
                <ul>
                    
                    <li class="profile-photo">
                        <img src="/img/avatar.png" alt="" class="img-circle">
                    </li>
                    <li class="dropdown settings">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      Usuario<i class="fa fa-angle-down"></i>
                    </a>
                        <ul class="dropdown-menu animated fadeInDown">
                            <li>
                                <a href="#"><i class="fa fa-user"></i> Profile</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-calendar"></i> Calendar</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge badge-danager" id="user-inbox">5</span></a>
                            </li>
                            <li>
                                <a href="{{url('/logout')}}" ><i class="fa fa-power-off"></i> Logout</a> 
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="toggle-navigation toggle-right">
                            <button type="button" class="btn btn-default" id="toggle-right">
                                <i class="fa fa-comment"></i>
                            </button>
                        </div>
                    </li>

                </ul>
            </div>
        </header>
        <!--sidebar left start-->
        <aside class="sidebar">
            <div id="leftside-navigation" class="nano">
                <ul class="nano-content">
                    <li class="active">
                        <a href="home"><i class="fa fa-dashboard"></i><span>Escritorio</span></a>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:void(0);"><i class="fa fa-cogs"></i><span>Turnos Futbol</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                        <ul>
                            
                            <li><a href="turnofutbol">Lista Turnos </a>
                            </li>
                            <li><a href="grillaturnofutbol">Grilla Turnos </a>
                            </li>
    
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:void(0);"><i class="fa fa-cogs"></i><span>Turnos Padle</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                        <ul>
                            
                            <li><a href="turno">Turnos</a>
                            </li>
                            <li><a href="grillaturno">Grilla Turnos </a>
                            </li>
                        
                        </ul>
                    </li>
                    <li class="">
                        <a href="cliente"><i class="fa fa-dashboard"></i><span>Clientes</span></a>
                    </li>

                    <li class="">
                        <a href="complejo"><i class="fa fa-dashboard"></i><span>Complejos</span></a>
                    </li>

                    <li class="">
                        <a href="cancha"><i class="fa fa-dashboard"></i><span>Canchas</span></a>
                    </li>

                    <li class="">
                        <a href="users"><i class="fa fa-dashboard"></i><span>Usuarios</span></a>
                    </li>
                    <li class="">
                        <a href="horarios"><i class="fa fa-dashboard"></i><span>Horarios</span></a>
                    </li>
                </ul>
            </div>

        </aside>





       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
    <section class="main-content-wrapper">
            <section id="main-content">
                <!--tiles start-->
                @yield('content')
            </section>
    </section>
        
    </section>
      <!--Fin-Contenido-->
    

    <script src="{{asset('/js/jquery-1.10.2.min.js')}}"></script>
    <!-- Calendar -->
    <script src="{{asset('/plugins/fullcalendar/js/jquery-ui-1.10.1.custom.min.js')}}"></script>
    <script src="{{asset('/plugins/fullcalendar/js/fullcalendar.min.js')}}"></script>
    <script src="{{asset('/plugins/fullcalendar/js/calendar.js')}}"></script>

    
    <script src="{{asset('/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/plugins/waypoints/waypoints.min.js')}}"></script>
    
    <!--Page Level JS-->
    <script src="{{asset('/plugins/countTo/jquery.countTo.js')}}"></script>
    <script src="{{asset('/plugins/weather/js/skycons.js')}}"></script>
    <!-- FlotCharts  -->
    <script src="{{asset('/plugins/flot/js/jquery.flot.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.resize.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.canvas.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.image.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.categories.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.crosshair.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.errorbars.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.fillbetween.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.navigate.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.pie.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.selection.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.stack.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.symbol.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.threshold.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.colorhelpers.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.time.min.js')}}"></script>
    <script src="{{asset('/plugins/flot/js/jquery.flot.example.js')}}"></script>
    <!-- Morris  -->
    <script src="{{asset('/plugins/morris/js/morris.min.js')}}"></script>
    <script src="{{asset('/plugins/morris/js/raphael.2.1.0.min.js')}}"></script>
    <!-- Vector Map  -->
    <script src="{{asset('/plugins/jvectormap/js/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('/plugins/jvectormap/js/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- ToDo List  -->
    <script src="{{asset('/plugins/todo/js/todos.js')}}"></script>

    <!--Page Leve JS -->
    <script src="{{asset('/js/application.js')}}"></script>
    
    <script src="{{asset('/plugins/dataTables/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('/plugins/dataTables/js/dataTables.bootstrap.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/select2.css')}}">
    <script src="{{asset('js/select2.js')}}"></script>

    <script src="{{asset('js/jquery.mask.js')}}"></script>
    
    <!--Load these page level functions-->
    <script>
        $(document).ready(function() {
            app.timer();
            app.map();
            app.weather();
            app.morrisPie();
        });
    </script>
    
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-46627904-1', 'authenticgoods.co');
        ga('send', 'pageview');

    </script>
    @yield('scripts')
    
  </body>
</html>

