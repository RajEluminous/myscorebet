@extends('admin.adminlayout')

@section('page-header')
  Member <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model($arrMembers, [
                'action' => ['Admin\MemberController@update', $arrMembers->id],
                'method' => 'put',
                'files' => true,
                'autocomplete' => 'off'
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          @include('admin.members.form')
        </div>

        <div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" id="fp_btn_update" style="width:100px;">{{ trans('app.update_button') }}</button>
          <a class="btn btn-warning " href="{{ route(ADMIN.'.members.index') }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
      	</div>

      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
@section('js')
  <script>
    //To create new password
    $('#fp_btn_generate_new_pw').click(function(){
      $('#fp_txt_generate_new_pw').show();
    });

    //To check password valid or not
    $('#fp_btn_update').click(function(){
      var strNewPassword = $('#fp_txt_generate_new_pw').val();
      if(strNewPassword!='') {
        if(strNewPassword.length<5) {
          $('#fp_err_new_pw').html('Please enter at least 6 digits.');
        return false;
        }
      }      
    });
  </script>
@stop
