@extends('admin.adminlayout')

@section('page-header')
  Event <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model($objEvent, [
                'action' => ['Admin\EventController@update', $objEvent->id],
                'method' => 'put',
                'files' => true,
                'autocomplete' => 'off'
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          @include('admin.events.form')
        </div>

        <div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" id="fp_btn_update" style="width:100px;">{{ trans('app.update_button') }}</button>
          <a class="btn btn-warning " href="{{ route(ADMIN.'.events.index') }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
      	</div>

      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop