<?php
$intUserId = 0;
if(session()->has('cd_customer_id')) {
  $intUserId  = Session::get('cd_customer_id');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="stylesheet" href="{{ asset('public/frontend') }}/css/bootstrap.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{{ asset('public/frontend') }}/css/font-awesome.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{{ asset('public/frontend') }}/css/style.css" type="text/css" media="screen" />
<title>Best Football Prediction Site of the Year in UK - Myscorebet</title>
<meta name="title" content="Best Football Prediction Site of the Year in UK - Myscorebet">
<meta name="keywords" content="best football prediction site of the Year, best football prediction site in the world, best football betting sites UK.">
<meta name="description" content="Myscorebet is the best football Prediction Site of the Year in England. and also the best football prediction site in the world. Best Football betting Sites UK.">
<link href="{{ asset('public/frontend') }}/images/1533546995.ico" rel="icon" type="image/x-icon">
<meta name="description" content="Welcome to one of the best betting sites in UK, Free football Score predictions and betting tips for today and weekend's football matches. Myscorebet is the best Football Predictor in England.
"/>
</head>
<body>

<!-- Show GDPR div -->
<!-- @if(!isset($_COOKIE['myscorebet_cookie']))
  <section id="gdpr">
  <div class="container">
    <p>We use cookies to help us improve, promote, and protect our services. By continuing to use the site, you agree to our Privacy Policy.
      <a href="javascript:void(0);" id="accpetdata">Accept</a>
    </p>
  </div>
  </section>
@endif -->
<!-- END GDPR div -->

<nav id="main-nav" class="navbar navbar-expand-sm navbar-dark fixed-top">
  <div class="container"> <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('public/frontend') }}/images/logo.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse " id="navbarNav">
      <ul class="navbar-nav">
		@if(session()->has('cd_customer_id'))
        <li class="nav-item"> <a class="nav-link" href="{{ url('myaccount') }}">My Account</a> </li>
		<li class="nav-item active"> <a class="nav-link" href="{{ url('logout') }}">Logout<span class="sr-only">(current)</span></a> </li>	
		<li class="nav-item"> <a class="nav-link" href="{{ url('blog') }}">BLOG</a> </li>	
		@else
		<li class="nav-item active"> <a class="nav-link" href="{{ url('login') }}">Login<span class="sr-only">(current)</span></a> </li>
		<li class="nav-item"> <a class="nav-link" href="{{ url('register') }}">REGISTER &amp; PLAY</a> </li>
		<li class="nav-item"> <a class="nav-link" href="{{ url('blog') }}">BLOG</a> </li>
		@endif       
      </ul>
    </div>
  </div>
</nav>
<section id="hero" class="d-flex align-items-center">
  <div class="container">
    <h1>Predict Football Scores and win Money!!</h1> 
    <p>Are you crazy about football? <br> Did you always predict the correct scores but never dared to gamble for it?!<br> Now you can predict the scores and win money every month!!</p>
	  <p>Myscorebet offers you a chance to win money by predicting premier league scores for free!</p>
    @if(!session()->has('cd_customer_id'))
      <a class="green-btn" href="{{ url('/login') }}">Login or Register</a> 
    @endif
  </div>
</section>
@if ($message = Session::get('success'))
    <div class="alert alert-success text-center">
      <p>{{ $message }}</p>
    </div>
 @endif
<section id="main-sec">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="upcoming">
          <h2>Upcoming Matches</h2>
          @if(count($events) > 0)
            @foreach ($events as $item)
              <h3>{{ $item->event_name }}</h3>
              <?php
                //Get all sub event details
                $arrSubevents = getAllSubEvents($item->id);
              ?>
              <div id="err_score_{{$item->id}}" class="text-center error"></div>
              {!! Form::open(array('url' => URL::to('/save-predictions'), 'class' => 'form', 'id' => 'frm_userprediction_'.$item->id ,'autocomplete' => 'off' )) !!}
              {{ Form::hidden('fp_event_id', $item->id, array('id'=>'fp_event_id')) }}
              
              @if(count($arrSubevents) > 0)
                @foreach ($arrSubevents as $subEventItem)
                				
				@php $usrScore_1=''; $usrScore_2=''; @endphp  
				@foreach ($arrUsrPred as $usrPred)
				  @if($usrPred['id']==$subEventItem->id)
					  @php $usrScore_1= $usrPred['pred_score_team1'] @endphp 
					  @php $usrScore_2= $usrPred['pred_score_team2'] @endphp
				  @endif	  
				@endforeach
				
				
                {{ Form::hidden('fp_subevent_ids[]', $subEventItem->id, array('id' => 'fp_subevent_ids')) }}
                <div class="up-sec">
                  <aside> <img src="{{ url('public/') . config('variables.images.public') .$subEventItem->logo_team1 }}" alt=""> <strong>{{ $subEventItem->name_team1}}</strong>
                    {!! Form::text('pred_score_team1[]', $usrScore_1, array('onKeyUp' => 'checkDigit(this)','maxlength' => '2')) !!}
                  </aside>
                  <section>
                    <h4>VS</h4>
                    <!-- <span>{{ $strEventDay = (date('Y-m-d',strtotime($subEventItem->expiry_datetime)) == date('Y-m-d')) ? 'Today' : date('l ,d-m-Y',strtotime($subEventItem->expiry_datetime)) }}</span> -->
                    <!-- <h6>Veritas Stadion</h6> -->
                    <div class="timer">
                      <i class="fa fa-clock-o" aria-hidden="true"></i> Expires on (BST) {{date('d-m-Y H:i',strtotime($subEventItem->expiry_datetime))}}
                    </div>
                  </section>
                  <aside> <img src="{{ url('public/') . config('variables.images.public') .$subEventItem->logo_team2 }}" alt=""> <strong>{{ $subEventItem->name_team2}}</strong>
                    {!! Form::text('pred_score_team2[]', $usrScore_2, array('onKeyUp' => 'checkDigit(this)','maxlength' => '2')) !!}
                  </aside>
                </div>
                @endforeach
                <div class="col text-center">
                  @if(session()->has('cd_customer_id'))
                    <button type="submit" id="btn_{{ $item->id }}" onclick="return dataValidate({{ $item->id }});" class="btn black-btn">Submit</button>
                  @else
                    <a class="black-btn" href="{{ url('/login') }}">Login or Register</a>
                  @endif
                </div>
              @else
                <p><strong>No subevents found</strong></p>
              @endif
              {!! Form::close() !!}
            @endforeach
          @else
            <h3>Comming Soon</h3>
          @endif
        </div>
      </div>
      <div class="col-md-6">
        <div class="predictors">
        <h2>Last Matchday winners</h2>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Username</th>
            </tr>
          </thead>
          <tbody>
           @if($arrTopWinnersLastMonth)
              @foreach ($arrTopWinnersLastMonth as $key => $item)
                @if($item->username!='')
                <tr>
                  <td colspan="2">{{ stripslashes($item->username) }}</td>
                </tr>
                @endif
              @endforeach
           @else
              <tr>
                <td colspan="2">No records found</td>
              </tr>
           @endif  
          </tbody>
        </table>
        </div>
        <br>
        <div class="predictors">
          <h2> top predictors</h2>
          <h3>Current Month</h3>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Username</th>
                <th scope="col">Points</th>
              </tr>
            </thead>
            <tbody>
             @if(count($arrTopPredictionsCurrentMonth) > 0)
                @foreach ($arrTopPredictionsCurrentMonth as $item)  
                  <tr>
                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                    <td class="points">{{ $item->totalpoints }}</td>
                  </tr>
                @endforeach
             @else
                <tr>
                  <td colspan="2">No records found</td>
                </tr>
             @endif  
            </tbody>
          </table>
          <br>
          <h3>Overall</h3>
          <table class="table table-bordered no-margin">
            <thead>
              <tr>
                <th scope="col">Username</th>
                <th scope="col">Points</th>
              </tr>
            </thead>
            <tbody>
              @if(count($arrTopPredictions) > 0)
                @foreach ($arrTopPredictions as $item)
                  <tr>
                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                    <td class="points">{{ $item->totalpoints }}</td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="2">No records found</td>
                </tr>
              @endif
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
<div class="container">
<div class="row"> 
<div class="col-md-12">
<h3>About Us</h3>
<p>At Myscorebet, we offer you an option to bet on premier league scores without the risk of loosing money.
When you register for free, you get a chance to predict the scores for every football match played in the English Premier League.
For each correct predicted score, you will get a point.
Every month there will be a winner (or winners*) with most points who will get a cash prize of 100 pounds!
Over the whole season, the users (or users*) who have earned the maximum points will get a bumper prize of 2500 pounds!!</p>
<p>*Please see <a href="{{ route('termsandcondition') }}">Terms and Conditions</a>.</p>
</div>
</div>
</div>
</footer>
<section id="copy-right">
<div class="container">
<div class="row">
<div class="col-md-12">
<a href="https://twitter.com/myscorebet" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>   <a href="https://www.facebook.com/Myscorebet-1717883041599708/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>  <br>

<p>{{ env('APP_NAME')}} 2018 | All Rights Reserved | <a href="mailto:info@myscorebet.com">info@myscorebet.com</a></p>
<p>MYSCOREBET is part of SCRATCH4ITCH LTD, registered in England and Wales, Company number: 08724800 </p>
</div>
</div>
</div>
</section>

<script type="text/javascript" src="{{ asset('public/frontend') }}/js/jquery-3.3.1.min.js"></script> 
<script type="text/javascript" src="{{ asset('public/frontend') }}/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script type="text/javascript" src="{{ asset('public/frontend') }}/js/common.validation.js"></script>  
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("main-nav");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    $('.navbar').addClass("sticky");
  } else {
	$('.navbar').removeClass("sticky");
  }
}
</script>
</body>
</html>
