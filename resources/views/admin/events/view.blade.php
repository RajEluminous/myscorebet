<?php
 //If member data set  
 if(isset($arrMembers)) {
    $strMemebrStatus = ($arrMembers->isActive == "y") ? config('variables.STATUS_ACTIVE') : config('variables.STATUS_INACTIVE');
 }
?>        
@extends('admin.adminlayout')

@section('page-header')
  Member <small>View</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model($arrMembers, [
                'method' => 'put',
                'files' => true,
                'autocomplete' => 'off'
            ])
        !!}
        <div class="box-body" style="margin:10px;">
          {!! Form::myInput('text', 'first_name', 'First Name*', ['readonly']) !!}
          {!! Form::myInput('text', 'last_name', 'Last Name*', ['readonly']) !!}
          {!! Form::myInput('text', 'email', 'Email*', ['readonly']) !!}
          {!! Form::myInput('text', 'isActive', 'Staus*', ['readonly'], $strMemebrStatus) !!}
        </div>
        <div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
          <a class="btn btn-warning " href="{{ route(ADMIN.'.members.index') }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
      	</div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
