@extends('frontend.defaultContent')
@section('content')
	<section id="hero" class="d-flex align-items-center inner-header">
	<div class="container">
		<h1>Reset Password</h1>
		 </div>
	</section>
	@if ($message = Session::get('danger'))
        <div class="alert alert-danger text-center">
            <p>{{ $message }}</p>
        </div>
    @endif
	<!-- Breadcrumb -->
	 <div class="alert alert-secondary breadcrum">
        <div class="container">
            <div class="row">
                <strong><a href="{{ url('/') }}" title="Home" class="text-secondary"><i class="fa fa-home"></i></a></strong> <span class="ml-2"> &gt; </span> <span class="ml-2">Reset Password</span>
            </div>
        </div>
    </div>
	<!-- End: Breadcrumb -->
	<section class="form-sec">
	<div class="container">
	<div id="err_pw" class="text-center error"></div>
	<div class="row">
	{!! Form::open(array('route' => 'newpassword', 'method'=>'POST', 'id' => 'frm_member_resetpassword','autocomplete'=>'off')) !!}
	<div class="col">
	<label>New Password</label>
		{!! Form::password('fp_new_password', array('class'=>'form-control', 'id'=>'fp_new_password', 'placeholder' => 'Password', 'minlength' => '6', 'maxlength' => '35')) !!}
	</div>
	<div class="col">
	<label>Confirm Password</label>
		{!! Form::password('fp_confirm_password', array('class'=>'form-control', 'id'=>'fp_confirm_password', 'placeholder' => 'Confirm Password', 'minlength' => '6', 'maxlength' => '35')) !!}
	</div>	 
	<div class="col">
	{{ Form::hidden('fp_user_id', (isset($userId)) ? $userId : '', array('id' => 'fp_user_id')) }}
	{{ Form::hidden('fp_reset_token', (isset($passToken)) ? $passToken : '', array('id' => 'fp_reset_token')) }}
	<button type="submit" class="btn btn-primary">Reset Password</button>
	</div>
	 {!! Form::close() !!}
	</div>
	</div>
  </section>
@stop