@extends('admin.layouts.layout')
@section('title', 'Admin | Dashboard')
@section('content')
    <style>
        .card__1 h1,
        h4 {
            color: #000000b2;
        }

        .card__1 h4 {
            margin-bottom: 20px;
            text-transform: capitalize;
        }

        .card__1{
          padding: 50px 10px;
            border-radius: 10px;
        }
        .card__bg__1 {
            background: #ECF2FF;
        }
        .card__bg__2{
         background-color:  #2adfbb3d;
        }
        .card__bg__3{
          background-color: #FEF5E5;
        }
        .card__bg__4{
          background-color: #E6FFFA;
        }

        .card__1 button {
            margin: 0px auto;
            border: none;
            background: #5D87FF;
            padding: 7px 7px;
            border-radius: 5px;
            color: #fff;
        }
    </style>

      <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Registred User</div>
                                    <div class="stat-digit"> 
                                         {{ $userCount }}</div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Added Users</div>
                                    <div class="stat-digit"> 
                                         {{ $adduser }}</div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Random User</div>
                                    <div class="stat-digit"> 
                                         {{ $random_user }}</div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                   
                    <!-- /# column -->
                </div>

            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

@endsection
