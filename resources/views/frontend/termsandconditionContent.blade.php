@extends('frontend.defaultContent')
@section('content')
	<section id="hero" class="d-flex align-items-center inner-header">
	  <div class="container">
		<h1>Terms and Conditions</h1>
		 </div>
	</section>
	<!-- Breadcrumb -->
	 <div class="alert alert-secondary breadcrum">
        <div class="container">
            <div class="row">
                <strong><a href="{{ url('/') }}" title="Home" class="text-secondary"><i class="fa fa-home"></i></a></strong> <span class="ml-2"> &gt; </span> <span class="ml-2">Terms and Conditions</span>
            </div>
        </div>
    </div>
	<!-- End: Breadcrumb -->  
	<section class="form-sec">
	<div class="container">
	<div class="row">
	 <p>1. You need to be 16 or over to play the predictions draw on Myscorebet.</p>
	 <p>2. You must register with a valid email address to be able to take part in predicting the scores and prize draw.</p>
	 <p>3. You must have an active UK bank account to claim the winning prize.</p>
     <p>4. You need to have predicted at least one correct score to be eligible for the prize draw, if no user has predicted a correct score for a particular month then the prize will be void for that month.</p>
	 <p>5. If there are more than one but not more than ten users with highest score for the monthly draw or overall prize, the prize money will be equally divided amongst all the winners.</p>
     <p>6. If there are more than ten users with highest score for the monthly or overall prize then a lucky draw will be done to select the ten winners, lucky draw will be done by <a href="https://www.myscorebet.com">www.myscorebet.com</a> and will be final and binding.</p>
	 <p>7. Latest scores submitted before the expiry of an event or a sub-event will be considered for the draw.</p>
     <p>8. If the user fails to submit the scores before the expiry of the event or sub-event, his or her scores will not be recorded or considered for that draw.</p>
	 <p>9. Myscorebet will only store your username, email id, password and predicted scores, <a href="https://www.myscorebet.com">www.myscorebet.com</a> will not ask or store any other details for a user.</p>
	 <p>10. Your email address may be shared with other third parties or partners which can be used for advertising or send promotional content.</p>
	 <p>11. Myscorebet will contact you in case you are a prize winner and will advise you on how the prize can be claimed.</p>
     <p>12. In case you are a prize winner, you can claim the prize only in accordance with the Myscorebet's prize policy, the prize cannot be exchanged, transferred or changed.</p>
	 <p>13. By siging up you agree to receive emails from <a href="https://www.myscorebet.com">www.myscorebet.com</a> notifying you of your activities on the website, and you accept that from time to time these emails may contain advertising materials.</p>	
	 <p>
	 	<a class="btn btn-info " onclick="window.history.back();" style="width:100px;"><i class="fa fa-btn fa-back"></i>Back</a>
	 </p>
	</div>
	</div>
	</section>
@endsection	 
