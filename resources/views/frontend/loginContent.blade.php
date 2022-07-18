@extends('frontend.defaultContent')
@section('content')
	<section id="hero" class="d-flex align-items-center inner-header">
	  <div class="container">
		<h1>Login</h1>
		 </div>
	</section>
	@if ($message = Session::get('success'))
        <div class="alert alert-success text-center">
            <p>{{ $message }}</p>
        </div>
    @endif
	@if ($message = Session::get('danger'))
        <div class="alert alert-danger text-center">
            <p>{{ $message }}</p>
        </div>
    @endif
	<!-- Breadcrumb -->
	 <div class="alert alert-secondary breadcrum">
        <div class="container">
            <div class="row">
                <strong><a href="{{ url('/') }}" title="Home" class="text-secondary"><i class="fa fa-home"></i></a></strong> <span class="ml-2"> &gt; </span> <span class="ml-2">Login</span>
            </div>
        </div>
    </div>
	<!-- End: Breadcrumb -->
	<section class="form-sec">
	<div class="container">
	<div class="row">
	{!! Form::open(array('route' => 'author','autocomplete' => 'off','method'=>'POST', 'id' => 'frm_member_login')) !!}
	<div class="col">
	<label>Email</label>
	{!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control', 'id' => 'email', 'maxlength' => '60')) !!}
	</div>
	<div class="col">
	<label>Password</label>
	{!! Form::password('password', array('class'=>'form-control', 'id'=>'password', 'placeholder' => 'Password', 'maxlength' => '35')) !!}
	</div>
	<div class="col">
	<button type="submit" class="btn btn-primary">Login</button>
	</div>
	<div class="col">
		<p style="float: right;"><a href="{{ url('register') }}">Register</a> | <a href="{{ url('forgot-password') }}">Forgot password</a></p>
	</div>
	{!! Form::close() !!}
	</div>
	</div>
	</section>
@endsection	 
