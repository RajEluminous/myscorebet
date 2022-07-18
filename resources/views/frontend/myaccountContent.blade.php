@extends('frontend.defaultContent')
@section('content')

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>

	<section id="hero" class="d-flex align-items-center inner-header">
	  <div class="container">
		<h1>My Account</h1>
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
                <strong><a href="{{ url('/') }}" title="Home" class="text-secondary"><i class="fa fa-home"></i></a></strong> <span class="ml-2"> &gt; </span> <span class="ml-2">My Account</span>
            </div>
        </div>
    </div>
	<!-- End: Breadcrumb -->	
	 	
	<section class="form-sec"> 
	  <!-- Change password -->
	  
	  <div class="container">
		<div class="row">
		  <div class="col-md-6">
			<h3 class="text-center">Change Password</h3>
			{!! Form::open(array('route' => 'myauth','autocomplete' => 'off','method'=>'POST', 'id' => 'frm_member_myaccount')) !!}
			  <div class="col">
				<label>Old Password</label>
				{!! Form::password('old_password', array('class'=>'form-control', 'id'=>'old_password', 'placeholder' => 'Password', 'minlength' => '6', 'maxlength' => '35')) !!}
			  </div>
			  <div class="col">
				<label>New Password</label>
				{!! Form::password('new_password', array('class'=>'form-control', 'id'=>'new_password', 'placeholder' => 'Password', 'minlength' => '6', 'maxlength' => '35')) !!}
			  </div>
			  <div class="col">
				<label>Confirm Password</label>
				{!! Form::password('confirm_password', array('class'=>'form-control', 'id'=>'confirm_password', 'placeholder' => 'Password', 'minlength' => '6', 'maxlength' => '35')) !!}
			  </div>
			  <div class="col">
				<button type="submit" class="btn btn-primary">Reset Password</button>
			  </div>
			{!! Form::close() !!}
		  </div>

		  <div class="col-md-6 my-result-sec">
			<h3>My Profile</h3>
			<table class="table table-bordered">			  
			  <tbody>
			  	@if($arrUserData)
				<tr>
				  <td><strong>Name</strong></td>
				  <td>{{ ucfirst($arrUserData->first_name) }} {{ ucfirst($arrUserData->last_name) }}</td>
				</tr>
				<tr>
				  <td>Email Id</td>
				  <td>{{ $arrUserData->email }}</td>
				</tr>
				<tr>
				  <td>Registration Date</td>
				  <td>{{ date('d-M-Y', strtotime($arrUserData->created_at)) }} </td>
				</tr>
				<tr>
				  <td colspan="2" align="center">
				  	<!-- Delete my account -->
				  	<a class="btn btn-custom-delete remove-record" data-toggle="modal" data-url="{!! URL::route('destroyMemberAccount', base64_encode(Session::get('cd_customer_id'))) !!}" data-id="{{ base64_encode(Session::get('cd_customer_id')) }}" data-target="#custom-width-modal" data-title="Delete my profile" data-msg="Are you sure? This will delete your account on Myscorebet forever, and it can never be restored. On deleting your account all your predictions and points will be permanently deleted.">Delete My Account</a>
				  </td>
				</tr>
				@endif 
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	  <!-- End:Change password -->
	
	  <!-- My Result -->
	  <div class="container">
		<div class="row">
		  <div class="col-md-12">
			<h2 class="mt-5 result-heading col-12 brt-5">Result</h2>
            @php
	            $i = 1; 
	            $intTotalPoi = 0;
            @endphp
            @if ($arrPredictions)
                @foreach ($arrPredictions as $eventKey => $eventData)

			    <h3 class="mb-0 result-subheading col-12">{{ $eventKey }}</h3>
                <div class="col-md-12 listing result">
                    <div class="upcoming">
                        @foreach ($eventData['subevent_data'] as $arrEventDetails)

                        <div class="up-sec d-flex flex-wrap">
                            <aside class="col-sm-2"><img src="{{ url('public/') . config('variables.images.public') .$arrEventDetails['logo_team1'] }}" alt=""> <strong>{{ $arrEventDetails['name_team1'] }}</strong></aside>
                            
                            <aside class="text-secondary col-sm-1"><strong>{{ $arrEventDetails['pred_score_team1'] }}</strong><strong>Predicted</strong></aside>
                            
                            <aside class="text-success col-sm-1"><strong>{{ (isset($arrEventDetails['score_team1'])) ? $arrEventDetails['score_team1'] : '-' }}</strong><strong>Actual</strong></aside>
                            <section class="col-sm-1">
                                <h4>VS</h4></section>
                            <aside class="col-sm-2"> <img src="{{ url('public/') . config('variables.images.public') .$arrEventDetails['logo_team2'] }}" alt=""> <strong>{{ $arrEventDetails['name_team2'] }}</strong></aside>
                            
                            <aside class="text-secondary col-sm-1"><strong>{{ $arrEventDetails['pred_score_team2'] }}</strong><strong>Predicted</strong></aside>
                            
                            <aside class="text-success col-sm-1"><strong>{{ (isset( $arrEventDetails['score_team2'])) ? $arrEventDetails['score_team2'] : '-' }}</strong><strong>Actual</strong></aside>
                            <aside class="text-primary col-sm-1 points"><strong>
                                @if($arrEventDetails['point']!='1')
                                    {{ '- ' }}
                                @else
                                    {{ $arrEventDetails['point'] }}
                                    @php
                                    	$intTotalPoi++;
                                    @endphp
                                @endif
                            </strong><strong>Points</strong></aside>
                            <aside class="text-success col-sm-1">
                                @php
                                //Check expired date are same or not
                                $strExpiredTimeValid = '';
                                $strGetTime 		 =  date('Y-m-d H:i:s', strtotime($arrEventDetails['expiry_datetime']));
                                $strExpiredTimeValid = ($strGetTime >= date('Y-m-d H:i:s')) ? '': '1';
                                @endphp

                                @if($strExpiredTimeValid!='1')
                                	<!-- Delete memeber prediction -->
								  	<a class="btn btn-danger btn-sm remove-record" data-toggle="modal" data-url="{!! URL::route('deleteMemberPrediction', base64_encode($arrEventDetails['user_prediction_id'])) !!}" data-id="{{ base64_encode($arrEventDetails['user_prediction_id']) }}" data-target="#custom-width-modal" data-title="Delete prediction" data-msg="Are you sure? On deleting your prediction will be permanently deleted." title="{{ trans('app.delete_title') }}"><i class="fa fa-trash"></i></a> 
                                @endif
                            </aside>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                @else
                    <h5 class="text-center">No predictions found</h5>
                @endif
                <ul class="list-group col-12 p-0">
                    <li class="list-group-item d-flex justify-content-end align-items-center">
                        <strong>Total Points</strong><h5 class="mb-0"><span class="badge badge-success badge-pill ml-3">{{ $intTotalPoi }}</span></h5>
                    </li>
                </ul>
		   </div>
		</div>
	  </div>
	  <!-- End: My Result -->
	</section> 
    <!-- Add delete model -->
    @include('frontend.includes.delete_record');
@endsection	 
