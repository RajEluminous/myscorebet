@extends('frontend.defaultContent')
@section('content')
	<section id="hero" class="d-flex align-items-center inner-header">
	  <div class="container">
		<h1>Privacy Policy</h1>
		 </div>
	</section>
	<!-- Breadcrumb -->
	 <div class="alert alert-secondary breadcrum">
        <div class="container">
            <div class="row">
                <strong><a href="{{ url('/') }}" title="Home" class="text-secondary"><i class="fa fa-home"></i></a></strong> <span class="ml-2"> &gt; </span> <span class="ml-2">Privacy Policy</span>
            </div>
        </div>
    </div>
	<!-- End: Breadcrumb -->  
	<section class="form-sec">
	<div class="container">
	<div class="row">
	  <p>1. <a href="https://www.myscorebet.com">www.myscorebet.com</a> will only store your name, email id, password and predicted scores, Myscorebet will not ask or store any other details for a user.</p>
	  <p>2. You will receive updates on the events, sub events and your activities on Myscorebet through emails, these emails may contain advertising material.</p>
	  <p>3. You consent to Myscorebet collecting your name and email address and storing them until you have deleted your account.</p>
	  <p>4. You can delete your account any time and all your personal data will be removed from Myscorebet, once you delete the account you will no longer be able to log in or access parts of <a href="https://www.myscorebet.com">www.myscorebet.com</a>.</p>
	  <p>5. In case you have deleted your account, you will need to register again to access certain areas of Myscorebet.</p>
	  <p>6. If you are a prize winner, Myscorebet will initially notify you over email and may need to gather further details like telephone number, adrress or bank details to transfer the prize money, these details will not be held or stored by Myscorebet and will be used for one time activity. You consent tho this information being asked of you in case you are a prize winner.</p>
	  <p>7. If you share your login details to Myscorebet with others and if these details are being misused by the people with whom you have shared the details then Myscorebet may not be liable for any damages caused.</p>
	  <p>8. If there is any security breach or hacking attack on Myscorebet then Myscorebet will notify immediately about any imapct it may cause to your data or personal details.</p>	 
	 <p>
	 	<a class="btn btn-info " onclick="window.history.back();" style="width:100px;"><i class="fa fa-btn fa-back"></i>Back</a>
	 </p>
	</div>
	</div>
	</section>
@endsection	 
