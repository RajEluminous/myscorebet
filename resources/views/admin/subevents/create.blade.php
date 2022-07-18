@extends('admin.adminlayout')

@section('page-header')
  Sub Event <small>new</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::open([
                'action' => ['Admin\SubeventController@store'],
                'files' => true,
                'autocomplete' => 'off'
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          @include('admin.subevents.form')
        </div>

      	<div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">Save</button>
          <a class="btn btn-warning " href="{{ route(ADMIN.'.subevents.index') }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
      	</div>

        {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
@section('js')
  <script type="text/javascript">
    //Set limit for 5 months from current date
    $('#expiry_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        showMeridian: 1,
        startView:2,
        startDate : new Date()
     });
  </script>
@stop