<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Model\UserLoginLogs;
use Auth;
use App\Model\SubscriberInvitees;
use App\User;
use DB;
use Session;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated(Request $request, $user) {

   


      $redirect =  Session::get('redirectTo');

     if($redirect){ 
        Session::forget('redirectTo');
          return redirect('user-registration/'.$redirect);
            
     }else{
         return redirect('home');
     }


      /*
        if ($user->parent_id == 0) {
            $user->parent_id = $user->id;
        }
        UserLoginLogs::Create([
            'subscriber_id' => $user->parent_id,
            'user_id' => $user->id,
            'login_time' => date('Y-m-d H:i:s'),
            'logout_time' => date('Y-m-d H:i:s'),
            'login_status' => 1,
        ]);

        $subInvitee = SubscriberInvitees::where('user_id', $user->id)->first();

        DB::table('users')->where('id', $user->id)
                ->update([
                    'login_count' => $user->login_count + 1,
                    'is_logged_in' => 1,
                    'is_available' => ((isset($subInvitee->status_on_login) && $subInvitee->status_on_login == 2) ? 2 : 1),
                    'last_login_check' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        DB::table('user_availablity_log')->insert([
            'subscriber_id' => $user->parent_id,
            'user_id' => $user->id, 'is_available' => ((isset($subInvitee->status_on_login) && $subInvitee->status_on_login == 2) ? 2 : 1),
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        session(['oqtzoffset' => $request->oqtzoffset]);
        session(['currenttimezonedata' => $request->currenttimezonedata]);


    if($subInvitee->login_getstarted_default){

        if ($subInvitee && isset($subInvitee->login_default_view)) {
           $default_view = array('reports?sub=features', 'reports?sub=features', 'conversation-hub', 'contact', 'collaboration');
           return redirect($default_view[$subInvitee->login_default_view]);
        } else
            return redirect('reports?sub=features');

       }else{
        return redirect('get-started');
       }

*/
    }

    //  protected $redirectTo = '/reports';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request) {

        $credentials = $request->only($this->username(), 'password');
        $credentials['status'] = 1;
        return $credentials;
    }

    protected function sendFailedLoginResponse(Request $request) {
        $errors = [$this->username() => trans('auth.failed')];
        // Load user from database
        $user = \App\User::where($this->username(), $request->{$this->username()})->first();
        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password) && $user->status != 1) {
            $errors = [$this->username() => 'Your account is not active.'];
        }
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors($errors);
    }

}
