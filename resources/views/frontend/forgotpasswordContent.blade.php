@extends('frontend.defaultContent')
@section('content')
	<section id="hero" class="d-flex align-items-center inner-header">
	  <div class="container">
		<h1>Forgot Password</h1>
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
                <strong><a href="{{ url('/') }}" title="Home" class="text-secondary"><i class="fa fa-home"></i></a></strong> <span class="ml-2"> &gt; </span> <span class="ml-2">Forgot Password</span>
            </div>
        </div>
    </div>
	<!-- End: Breadcrumb -->
	<section class="form-sec">
	<div class="container">
	<div class="row">
	{!! Form::open(array('method'=>'POST', 'autocomplete' => 'off','id' => 'frm_member_forgotpassword')) !!}
	<div class="col">
	<label>Email</label>
	 {!! Form::email('fp_useremail', null, array('placeholder' => 'Email','class' => 'form-control', 'id' => 'fp_useremail', 'maxlength' => '60', 'pattern' => '[^@]+@[^@]+\.[a-zA-Z]{2,6}'  )) !!}
	</div>	 
	<div class="col">
	<button type="submit" class="btn btn-primary">Reset Password</button>
	</div>
	 {!! Form::close() !!}
	</div>
	</div>
	</section>
@endsection	 
