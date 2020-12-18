@extends('admin._partials._master')
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Profile</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>THIS MONTH ORDERS COMPLETED</small></h6>
                        <h4 class="m-t-0 text-info">{{ $thisMonthOrderCompleted }}</h4></div>
                    <div class="spark-chart">
                        <div id="monthchart"><canvas width="60" height="35" style="display: inline-block; width: 60px; height: 35px; vertical-align: top;"></canvas></div>
                    </div>
                </div>
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>LAST MONTH ORDERS COMPLETED</small></h6>
                        <h4 class="m-t-0 text-primary">{{ $lastMonthOrderCompleted }}</h4></div>
                    <div class="spark-chart">
                        <div id="lastmonthchart"><canvas width="60" height="35" style="display: inline-block; width: 60px; height: 35px; vertical-align: top;"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30"> <img src="https://upload.wikimedia.org/wikipedia/commons/6/67/User_Avatar.png" class="img-circle" width="150">
                        <h4 class="card-title m-t-10">{{ auth()->user()->name }}</h4>
                        <h6 class="card-subtitle">{{ auth()->user()->role->title }}</h6>
                    </center>
                </div>
                <div>
                    <hr> </div>
                <div class="card-body"> <small class="text-muted">Email address </small>
                    <h6>{{ auth()->user()->email }}</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab" aria-selected="true">Reset Password</a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="settings" role="tabpanel">
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    {{$errors->first('oldPasswordError')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                </div>
                            @endif

                            @if(session()->has('success'))
                                    <div class="alert alert-success">
                                        {{session()->get('success')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                    </div>
                            @endif
                            <form class="form-horizontal form-material" method="post" action="{{ route('reset.password') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="col-md-12">Old Password</label>
                                    <div class="col-md-12">
                                        <input name="oldPassword" type="password" value="" class="form-control form-control-line" required="required" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">New Password</label>
                                    <div class="col-md-12">
                                        <input name="newPassword" type="password" value="" class="form-control form-control-line" required="required" minlength="5"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success">Reset Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>

@endsection
@section('footer')

@endsection
