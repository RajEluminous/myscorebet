@php	 
	if(isset($arrMetaVals) && count($arrMetaVals)>0) {
		$metaTitle = $arrMetaVals['meta_title']; 	
		$metaKeywords = $arrMetaVals['meta_keywords'];
		$metaDescription = $arrMetaVals['meta_description'];	
	} else {
		$metaTitle = "UK Betting Sites England | Football Score Predictor England - Myscorebet";
		$metaKeywords = "best football prediction site of the Year, best football prediction site in the world, best football betting sites UK.";
		$metaDescription = "Welcome to one of the best betting sites in UK, Free football Score predictions and betting tips for today and weekend's football matches. Myscorebet is the best Football Predictor in England.";
	}
@endphp
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="stylesheet" href="{{ asset('public/frontend') }}/css/bootstrap.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{{ asset('public/frontend') }}/css/font-awesome.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{{ asset('public/frontend') }}/css/style.css" type="text/css" media="screen" />
<title>{{ $metaTitle }}</title>
<meta name="title" content="{{ $metaTitle }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="description" content="{{ $metaDescription }}">
<link href="{{ asset('public/frontend') }}/images/1533546995.ico" rel="icon" type="image/x-icon">
</head>
<body class="sky-header">

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
 @yield('content')
<footer>
<div class="container">
<div class="row">
 
<div class="col-md-12">
<h3>About Us</h3>
<p>At Myscorebet, we offer you an option to bet on premier league scores without the risk of losing money.
When you register for free, you get a chance to predict the scores for every football match played in the English Premier League.
For each correct predicted score, you will get a point.
Every month there will be a winner (or winners*) with most points who will get a cash prize of 100 pounds!
Over the whole season, the user (or users*) who have earned the maximum points will get a bumper prize of 2500 pounds!!</p>
<p>*Please see <a href="{{ route('termsandcondition') }}">Terms and Conditions</a>.</p>
</div>
</div>
</div>
</footer>
<section id="copy-right">
<div class="container">
<div class="row">
<div class="col-md-12">
<a href="https://twitter.com/myscorebet" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>   <a href="https://www.facebook.com/Myscorebet-1717883041599708/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a><br>

<p>{{ env('APP_NAME')}} 2018 | All Rights Reserved | <a href="mailto:info@myscorebet.com">info@myscorebet.com</a></p>
<p>MYSCOREBET is part of SCRATCH4ITCH LTD, registered in England and Wales, Company number: 08724800 </p>
</div>
</div>
</div>
</section>

<script type="text/javascript" src="{{ asset('public/frontend') }}/js/jquery-3.3.1.min.js"></script> 
<script type="text/javascript" src="{{ asset('public/frontend') }}/js/bootstrap.min.js"></script> 
<script src="{{ asset('public/frontend') }}/js/jquery.validate.min.js"></script>
<script src="{{ asset('public/frontend') }}/js/additional-methods.min.js"></script>
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
