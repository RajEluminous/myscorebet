<?php

namespace App\Http\Middleware; 
use Closure;
use App\Member;
use Session;

class FrontendAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$boolValid = false;
		if(Session::has('cd_customer_id') && Session::has('cd_customer_name') && Session::has('cd_customer_email')) {
			$objMember = Member::find(Session::get('cd_customer_id'));
			if($objMember) {
				if(($objMember->isActive == 'y') && ($objMember->isDeletedByUser == 'n')) {
					$boolValid = true;
				}
				else {
					// flush login user values
					Session::flush();
					
					Session::forget('cd_customer_id');
					Session::forget('cd_customer_name');
					Session::forget('cd_customer_email');

					//For inactive status
					if($objMember->isActive == 'n') {
						return redirect('/')->with('success', trans('app.member_inactive_account'));
					}
					if($objMember->isDeletedByUser == 'y') {
						return redirect('/')->with('success', trans('app.member_deleted_account'));

					}
				}
			}
		}
	
		if($boolValid){
			return $next($request);
		}else{
			if ($request->ajax() || $request->wantsJson()) {
				return response('Unauthorized.', 401);
			} else {
				return redirect()->guest('/');
			}
		}	
         
    }
}
