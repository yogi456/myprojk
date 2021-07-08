<?php
namespace App\Http\Middleware;

use App\Model\SubscriberCompanyDetails;
use App\Model\SubscriberWebsite;
use App\User;
use Auth;
use Closure;

class CheckSteps {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
	   
		$userid = Auth::user()->parent_id;
		$step = 4;
		$formerStep = $step - 1;
		$user = User::find($userid);

        if($user){
       ///check 
		if ($user->signup_step > $formerStep) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			if ($user->signup_step == 1) { 
				$url = 'chat-feature/' . $userid;
			}


           $web = SubscriberWebsite::where('subscriber_id', $userid)->first();
		   $company = SubscriberCompanyDetails::where('subscriber_id', $userid)->first();

           if(!$web || !$company){

            	$url = 'chat-feature/' . $userid;

             }else{

				if ($user->signup_step == 2) {
					//help-us/{userid}/{detailid}/{websiteid}
					$url = 'help-us/' . $userid . '/' . $company->id . '/' . $web->id;
				}

				if ($user->signup_step == 3) {
					///feature-interested/{userid}/{detailid}
					$url = 'feature-interested/' . $userid . '/' . $company->id.'/'. $web->id;
				}
            }

			return redirect($url);
		}
	}
		return $next($request);
	}
}
