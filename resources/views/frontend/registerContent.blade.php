@extends('frontend.defaultContent')
@section('content')


	<section id="hero" class="d-flex align-items-center inner-header">
  <div class="container">
    <h1>Registration</h1>
     </div>
	</section>
	<span id="display_msg"></span>
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
                <strong><a href="{{ url('/') }}" title="Home" class="text-secondary"><i class="fa fa-home"></i></a></strong> <span class="ml-2"> &gt; </span> <span class="ml-2">Registration</span>
            </div>
        </div>
    </div>
	<!-- End: Breadcrumb -->
	<section class="form-sec">
	<div class="container">
	<div class="row">
	{!! Form::open(array('route' => 'members.store','method'=>'POST', 'id' => 'frm_member_registration','autocomplete' => 'off')) !!}
	<div class="col">
	<label>First Name</label>
	{!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control', 'id' => 'first_name', 'maxlength' => '35')) !!}
	</div>
	<div class="col">
	<label>Last Name</label>
	{!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control', 'id' => 'last_name', 'maxlength' => '35')) !!}
	</div>
	@if (isset($disabled))
		<div class="col">
		<label>Email</label>
		 {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control', 'readonly' => true, 'id' => 'email')) !!}
		</div>
	@else
		<div class="col">
		<label>Email</label>
		 {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control', 'id' => 'email', 'maxlength' => '60')) !!}
		</div>
	@endif		
	
	<div class="col">
	<label>Password</label>
	{!! Form::password('password', array('class'=>'form-control', 'id'=>'password', 'placeholder' => 'Password', 'minlength' => '6','maxlength' => '35')) !!}
	</div>
	<div class="col">	 
	{!! Form::checkbox('agree', 1, '') !!}&nbsp;I agree to the <a href="{{ route('termsandcondition') }}">Terms and Conditions</a>.
	</div>
	<div class="col"></div>
	<div class="col">	 
	{!! Form::checkbox('agreeprivp', 1, '') !!}&nbsp;I agree to the <a href="{{ route('privacypolicy') }}">Privacy Policy</a>.
	</div>
	<div class="col"></div>
	<div class="col">
	 <button type="submit" class="btn btn-primary">Submit</button>
	</div>
	 {!! Form::close() !!}
	</div>
	</div>
	</section>
	<script>
	    //AJAX URL
	    var postRegistrationUrl  = "{{ route('members.store') }}";
	    var token 			     = "{{ csrf_token() }}";    
	</script>	
	
@endsection	 
