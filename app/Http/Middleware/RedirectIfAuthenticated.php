<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            $redirectId = DB::table('subscriber_invitees')->where('user_id', $user->id)->pluck('login_default_view');
//            print_r($redirectId);exit;
            if ($user->role_id == 5) {
                return redirect('collaboration');
            }
            if($redirectId[0] == '1'){ //Reports/Features
                return redirect('/reports');
            }elseif ($redirectId[0] == '2'){ //Inbox
                return redirect('/conversation-hub');
            }elseif ($redirectId[0] == '3'){ //Contacts
                return redirect('/contact');
            }elseif ($redirectId[0] == '4'){ //Team Messaging
                return redirect('/collaboration');
            }else{  //in case of not found or new one added
                return redirect('/reports');
            }
//            return redirect('/reports');
        }

        return $next($request);
    }
}
