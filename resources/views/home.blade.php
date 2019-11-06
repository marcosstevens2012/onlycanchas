@extends('layouts.admin')

@section('content')

                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="dashboard-tile detail tile-red">
                            <div class="content">
                                <h1 class="text-left timer" data-from="0" data-to="180" data-speed="2500"> </h1>
                                <p>Clientes</p>
                            </div>
                            <div class="icon"><i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dashboard-tile detail tile-turquoise">
                            <div class="content">
                                <h1 class="text-left timer" data-from="0" data-to="56" data-speed="2500"> </h1>
                                <p>Turnos Padle</p>
                            </div>
                            <div class="icon"><i class="fa fa-comments"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dashboard-tile detail tile-blue">
                            <div class="content">
                                <h1 class="text-left timer" data-from="0" data-to="32" data-speed="2500"> </h1>
                                <p>Turnos Futbol</p>
                            </div>
                            <div class="icon"><i class="fa fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dashboard-tile detail tile-purple">
                            <div class="content">
                                <h1 class="text-left timer" data-to="105" data-speed="2500"> </h1>
                                <p>Ingresos</p>
                            </div>
                            <div class="icon"><i class="fa fa-bar-chart-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="content">
            <div class="row">
                <div class="col-md-offset-1 col-md-2" id="events" >
                    <h2 id="calender-current-day"></h2>
                    <h3 id="calender-current-date"></h3>
                    
                </div>
                <div class="col-md-8" id="cal">
                    <div class="full-cal-header">
                        <div class="pull-left">
                            <div class="btn-group ">
                                <button class="btn btn-info" id="cal-prev"><i class="fa fa-angle-left"></i></button>
                                <button class="btn btn-info" id="cal-next"><i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                    <div class="pull-right">
                        <div data-toggle="buttons-radio" class="btn-group">
                            <button class="btn btn-primary active" type="button" id="change-view-month">Mes</button>
                            <button class="btn btn-primary " type="button" id="change-view-week">Semana</button>
                            <button class="btn btn-primary" type="button" id="change-view-day">Dia</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    </div>
                    <div id='calendar'></div>
       
                    </div>
      
      </div>

@endsection


