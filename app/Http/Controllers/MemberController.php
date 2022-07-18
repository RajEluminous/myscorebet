<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: MemberController.php
# Created on : JULY 2018
# Purpose: Controller for memeber management at frontend
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Member;
use Hash;
use URL;
use App\Mail\CompanyVerificationEmails;
 
class MemberController extends Controller
{
    public function index()
    {		
		return view('frontend.registerContent');
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('frontend.registerContent');
        //return view('members.create'); //
    }
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        request()->validate([
            'first_name' => 'required',
            'email' => 'required',
			'password' => 'required',
        ]);
		
		$sql_mem = DB::table('members')
                     ->select(DB::raw('id,first_name,last_name,password'))
                     ->where([							
								['email','=',trim($request->email)]		
					  ])->first();
		 

		if(optional($sql_mem)->id==0){
			// for insert
            $strHashText = Hash::make(rand());
			$arrAppUser = Member::insertGetId([
				'first_name' => ucfirst(trim($request->first_name)),
				'last_name' => ucfirst(trim($request->last_name)), 
				'email' => $request->email ,
				'password' => Hash::make($request->password),
                'isEmailVerified' => $strHashText             			 
			]);

            //send verify mail to User
            $strCustomerName  = $request->first_name.' '.$request->last_name;
            $strCustomerMailSubject = config('emailcontents.emails.1.subject');
            $strCustomerMessage     = config('emailcontents.emails.1.message');
            $strCustomerMessage     = str_replace('[USER_NAME]',$strCustomerName, $strCustomerMessage);
            $strCustomerMessage     = str_replace('[USER_EMAIL]', $request->email, $strCustomerMessage);
            $strCustomerMessage     = str_replace('[USER_PASSWORD]', $request->password, $strCustomerMessage);
            $strCustomerMessage     = str_replace('[USER_ACTIVATION_URL]', URL::to('/verify-email/'.base64_encode($arrAppUser).'/'.base64_encode($strHashText)), $strCustomerMessage);
        
            $isSent = sendEmail($request->email, $strCustomerName, $strCustomerMailSubject,$strCustomerMessage,"");

            echo json_encode(array("type" => "success", "msg" => trans('app.user_register')));
		} else {
            echo json_encode(array("type" => "danger", "msg" => trans('app.user_exist')));
		}
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return view('members.show',compact('member'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        return view('members.edit',compact('member'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
	public function update(Request $request, $id)
    {    
        request()->validate([
            'first_name' => 'required',
            'email' => 'required' 
        ]);
		 		 
		if(!empty($request->password)) {
		    Member::where('id', $id)->update([
				'first_name' => $request->first_name,	
				'last_name' =>$request->last_name,  
				'password' => Hash::make($request->password)		
			]);	
		} else {
			Member::where('id', $id)->update([
				'first_name' => $request->first_name,	
				'last_name' =>$request->last_name 				 	
			]);	
		}	
		 
        return redirect()->route('members.index')->with('success', trans('app.memeber_update'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Member::destroy($id);
        return redirect()->route('members.index')
                        ->with('success', trans('app.member_destroy'));
    }
    /**
     * Check For Email Verification.
     *
     * @param  int  $userid
     * @param  int  $token
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail($userid,$emailToken)
    {
        if(isset($userid) && isset($emailToken)) {
            $objMember = Member::findOrFail(base64_decode($userid));

            if(isset($objMember)) {
                if($objMember->isEmailVerified !='' && $objMember->isActive=='n') {
                    if($objMember->isEmailVerified == base64_decode($emailToken)) {
                        Member::where('id', base64_decode($userid))->update([
                            'isEmailVerified' => NULL,   
                            'isActive' => 'y',
                            'updated_at' => date('Y-m-d H:i:s')                   
                        ]);
                        return redirect('/login')->with('success', trans('app.email_verified'));
                    }
                    else {
                        return redirect('/login')->with('danger', trans('app.email_not_verified'));
                    }
                }
                else if($objMember->isActive=='y') {
                    return redirect('/login')->with('success', trans('app.email_already_verified'));
                }
                else {
                     return redirect('/');
                }
            }
            return redirect('/');
        }
        return redirect('/');
    }
}