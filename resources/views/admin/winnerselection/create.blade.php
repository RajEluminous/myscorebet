@extends('admin.adminlayout')

@section('page-header')
  Last Month Winners <small>( {{ date("F",strtotime("-1 month")) }} )</small>
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
                'action' => ['Admin\WinnersController@saveLastMonthWinners'],
                'files' => true,
                'autocomplete' => 'off'
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Rank 1</label>
                    {!! Form::text('winner1', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[0]->username!='') ? stripslashes($arrWinners[0]->username) : '' : '', array('class'=>'form-control','id'=>'winner1','placeholder'=>'Rank 1', 'maxlength' => '70', 'onKeyUp' => 'checkCharter(this)' )) !!}
                </div>
                <div class="form-group">
                    <label>Rank 3</label>
                    {!! Form::text('winner3', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[2]->username!='') ? stripslashes($arrWinners[2]->username) : '' : '', array('class'=>'form-control','maxlength' => '70', 'id'=>'winner3','placeholder'=>'Rank 3', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>
                <div class="form-group">
                    <label>Rank 5</label>
                    {!! Form::text('winner5', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[4]->username!='') ? stripslashes($arrWinners[4]->username) : '' : '', array('class'=>'form-control','maxlength' => '70','id'=>'winner5','placeholder'=>'Rank 5', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>
                <div class="form-group">
                    <label>Rank 7</label>
                    {!! Form::text('winner7', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[6]->username!='') ? stripslashes($arrWinners[6]->username) : '' : '',  array('class'=>'form-control','maxlength' => '70','id'=>'winner7','placeholder'=>'Rank 7', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>
                <div class="form-group">
                    <label>Rank 9</label>
                    {!! Form::text('winner9', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[8]->username!='') ? stripslashes($arrWinners[8]->username) : '' : '',  array('class'=>'form-control','maxlength' => '70','id'=>'winner9','placeholder'=>'Rank 9', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>          
            </div>
            <!-- /.col -->
            <div class="col-md-6">
               <div class="form-group">
                    <label>Rank 2</label>
                    {!! Form::text('winner2', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[1]->username!='') ? stripslashes($arrWinners[1]->username) : '' : '', array('class'=>'form-control','maxlength' => '70','id'=>'winner2','placeholder'=>'Rank 2', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>  
                <div class="form-group">
                    <label>Rank 4</label>
                    {!! Form::text('winner4', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[3]->username!='') ? stripslashes($arrWinners[3]->username) : '' : '', array('class'=>'form-control','maxlength' => '70','id'=>'winner4','placeholder'=>'Rank 4', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>  
                <div class="form-group">
                    <label>Rank 6</label>
                    {!! Form::text('winner6', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[5]->username!='') ? stripslashes($arrWinners[5]->username) : '' : '', array('class'=>'form-control','maxlength' => '70','id'=>'winner6','placeholder'=>'Rank 6', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>  
                <div class="form-group">
                    <label>Rank 8</label>
                    {!! Form::text('winner8', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[7]->username!='') ? stripslashes($arrWinners[7]->username) : '' : '',  array('class'=>'form-control','maxlength' => '70','id'=>'winner8','placeholder'=>'Rank 8', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>  
                <div class="form-group">
                    <label>Rank 10</label>
                    {!! Form::text('winner10', (isset($arrWinners) and count($arrWinners)>=1) ? ($arrWinners[9]->username!='') ? stripslashes($arrWinners[9]->username) : '' : '', array('class'=>'form-control','maxlength' => '70','id'=>'winner10','placeholder'=>'Rank 10', 'onKeyUp' => 'checkCharter(this)')) !!}
                </div>  
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      	<div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">Save</button>
      	</div>

        {!! Form::close() !!}
    </div>
  </div>
</div>
@stop