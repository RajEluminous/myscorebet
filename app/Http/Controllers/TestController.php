<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TestController extends Controller
{
	// default call	
	public function index()
    {	 	
    	//send an email 
    	sendEmail(trim('eluminous.sse24@gmail.com'), 'Tester', 'Test mail', 'Test Message -'.date('d-m-Y h:i A'),"");

    	//send an email 
    	sendEmail(trim('eluminous_se35@eluminoustechnologies.com'), 'Tester', 'Test mail', 'Test Message -'.date('d-m-Y h:i A'),"");

		die;			 
	}	
}
