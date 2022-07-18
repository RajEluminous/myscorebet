@extends('admin.adminlayout')

@section('page-header')
  Sub Event <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model($objSubevent, [
                'action' => ['Admin\SubeventController@update', $objSubevent->id],
                'method' => 'put',
                'files' => true,
                'autocomplete' => 'off'
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          @include('admin.subevents.form')
        </div>

        <div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" onclick="return validateSubEvent();" class="btn btn-info" id="fp_btn_update" style="width:100px;">{{ trans('app.update_button') }}</button>
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

    //Validate subevents
    function validateSubEvent() {
      var strGetStatus  = $('#status').val();
      var strScoreTeam1 = $('#score_team1').val();
      var strScoreTeam2 = $('#score_team2').val();
      if(strGetStatus=='c') {
        if(confirm('If you proceed with cancelling the match, all user\'s predicted score will be revoked. Are you sure you want to cancel this match?')) {
            return true;
        }
        return false;
      }

      //If score are not empty
      if((strScoreTeam1 && strScoreTeam2)) {
        if(confirm('Have you rechecked and provided actual scores for both teams? As after this, all winners will be notified by email. Are you sure? ')) {
            return true;
        }
        return false;
      }
    }
  </script>
@stop