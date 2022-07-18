@extends('admin.adminlayout')

@section('page-header')
  Generate Report
@stop

@section('content')

@if (Session::has('message'))
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <ul class="list-unstyled">
          {{ session()->get('message') }}
        </ul>
    </div>
@endif
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::open([
                'action' => ['Admin\ReportController@index'],
                'files' => true,
                'autocomplete' => 'off'
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          <h4>Overall User Predictions</h4>
        </div>

        <div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
          <button type="submit" class="btn btn-info" style="width:100px;">Generate</button>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
@stop