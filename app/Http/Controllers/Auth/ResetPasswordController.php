<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Hash;
use DB;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/reports';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showResetForm(Request $request, $token = null)
    {


           $link = false;
           $all_token = DB::table('password_resets')->get();
           foreach ($all_token as $key => $value) {
               if(Hash::check( $token, $value->token)){
                $request->email = $value->email;
                $link = true;
               }
           }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email,'link'=> $link]
        );
    }
}
