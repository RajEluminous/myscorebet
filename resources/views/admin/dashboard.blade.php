@extends('admin.adminlayout')

@section('page-header')
    Dashboard <small>Home</small>
@stop

@section('content')
     <!-- Small boxes (Stat box) -->
      <div class="row">
       <!--  <div class="col-lg-3 col-xs-6"> -->
          <!-- small box -->
         <!--  <div class="small-box bg-aqua">
            <div class="inner">
              <h3>0</h3>

              <p>Events</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div> -->
       <!--  </div> -->
      
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $intRegisteredMembers }}</h3>
              <p>Registered Active Users</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="{{ route(ADMIN.'.members.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

       <!--  <div class="col-lg-3 col-xs-6"> -->
          <!-- small box -->
         <!--  <div class="small-box bg-yellow">
            <div class="inner">
              <h3>0</h3>

              <p>Admin Users</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div> -->
      <!--   </div> -->
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $intEventCnt }}</h3>
              <p>Active Events</p>
            </div>
            <div class="icon">
              <i class="fa fa-calendar"></i>
            </div>
            <a href="{{ route(ADMIN.'.events.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
        <!-- ./col -->
      </div>
      <!-- /.row -->
@stop
