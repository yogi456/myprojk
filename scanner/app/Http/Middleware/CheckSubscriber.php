<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;
use App\User;
use App\Model\Company;

//use Illuminate\Support\Facades\Session;
//use Illuminate\Session\Store;

class CheckSubscriber {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::user()->parent_id == 0) {
            $subscriberData = User::where('id', Auth::user()->id)->first()->toArray();
            Auth::user()->detail_user_meta = Company::where('subscriber_id', Auth::user()->id)->get()->toArray();
            Auth::user()->subscriber_detail = $subscriberData;
        } else {
            $subscriberData = User::where('id', Auth::user()->parent_id)->first()->toArray();
            Auth::user()->detail_user_meta = Company::where('subscriber_id', Auth::user()->id)->get()->toArray();
            Auth::user()->subscriber_detail = $subscriberData;
            Auth::user()->user_role = DB::table('roles')->where('subscriber_id', Auth::user()->parent_id)->where('id', Auth::user()->system_role_id)->first();
        }

        if ($request->session()->has('onboardingGetStarted')) {
            if ($request->session()->get('onboardingGetStarted') == 1) {
                Auth::user()->onboardingGetStarted = 1;
            } else {
                Auth::user()->onboardingGetStarted = 0;
            }
        } else {
            Auth::user()->onboardingGetStarted = 0;
        }

        return $next($request);
    }

}
