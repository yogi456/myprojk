<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Model\Socialprovider\SocialProvider;
use App\Model\UserLoginLogs;
use App\Model\SubscriberInvitees;
use App\Model\SubscriberCompanyDetails;
use App\Http\Controllers\SmsRoutingController;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\CustomLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use File;
class AuthController extends Controller
{

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Obtain the user information from Social Provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        try {
            $socialUser = Socialite::driver('google')->stateless()->user();
        } catch (Exception $e) {
            return redirect('/');
        }

        if ($user = User::where('email', $socialUser->getEmail())->first()) {
            if ($user->id == $user->parent_id) {
                Auth::login($user);
                if (!$socialProvider = SocialProvider::where('provider_id', $socialUser->getId())->first()) {
                    $user->socialProviders()->create([
                        'provider_id' => $socialUser->getId(),
                        'provider' => 'google'
                    ]);
                }
                UserLoginLogs::Create([
                    'subscriber_id' => $user->id,
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
                $company = SubscriberCompanyDetails::where('subscriber_id', $user->id)->first();
                switch ($user->signup_step) {
                    case 1:
                        return redirect('/confirm/' . $user->id);
                        break;
                    case 2:
                        return redirect('/chat-feature/' . $user->id);
                        break;
                    case 3:
                        return redirect('/help-us/' . $user->id . '/' . $company->id);
                        break;
                    // case 4:
                    //     return redirect('/feature-interested/' . $user->id . '/' . $company->id);
                    //     break;

                    default:
                        return redirect('/reports');
                        break;
                }
            } else {
                return redirect('/');
            }
        } else {
            $user = $this->createNewUserWithProvider($socialUser);
            Auth::login($user);
            return view('pages.user.register-step1', ['userid' => $user->id]);
        }
    }
    /**
     * create new subscriber with provider
     */
    public function createNewUserWithProvider($socialUser)
    {
        // $usersController = new UsersController(url('/'));
        $generated_id = app(\App\Http\Controllers\UsersController::class)->random_num(9);
        $emailVerifyString = app(\App\Http\Controllers\UsersController::class)->getUniqueString();


      $path = public_path('images/subscriber/' . $generated_id);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        File::copy(public_path('images/subscriber/avatar.jpg'), public_path('images/subscriber/' . $generated_id . '/' . $generated_id . '.jpg'));

        //create new user and provider
        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName(),
                'displayName'=>substr(trim($socialUser->getName()),0,6),
                'avtar'=>$generated_id.'.jpg',
                'system_role_id' => 1,
                'status' => 1,
                'login_count' => 1,
                'is_available' => 1,
                'signup_step' => 2,
                'generated_id' => $generated_id,
                'email_veify_at' => date('Y-m-d H:i:s'),
                'emailVerifyString' => $emailVerifyString
            ]
        );

        $user->parent_id = $user->id;
        $user->save();        

        $subscriberinv = new SubscriberInvitees();
        $subscriberinv->agentname = $socialUser->getName();
        $subscriberinv->displayname=substr(trim($socialUser->getName()),0,6);
        $subscriberinv->email = $socialUser->getEmail();
        $subscriberinv->avatar=$generated_id.'.jpg';
        $subscriberinv->subscriber_id = $user->id;
        $subscriberinv->user_id = $user->id;
        $subscriberinv->table_type = 1;
        $subscriberinv->status = 1;
        $subscriberinv->is_activated = 1;
        $subscriberinv->status_on_login = 1;
        $subscriberinv->login_default_view = 1;
        $subscriberinv->save();

        $user->socialProviders()->create([
            'provider_id' => $socialUser->getId(),
            'provider' => 'google'
        ]);

        //create contact as super-admin
                $subscriber=SubscriberInvitees::where('subscriber_id',1)->where('email',$user->email)->first();
                if($subscriber){
                    if($subscriber->is_deleted){
                        $subscriber->is_deleted=0;
                    }
                    $subscriber->contact_id=$user->id;
                    $subscriber->save();
                    $this->addCustomfieldValue($subscriber->id,$type="Subscriber");
                }else{
                       $add_contact=DB::table('subscriber_invitees')->insertGetId([
                            'agentname' => $user->name,
                            'displayname' => $user->displayname,
                            'email' => $user->email,
                            'subscriber_id' => 1,
                            'user_id' => 0,
                            'contact_id'=>$user->id,
                            'table_type' => 2,
                            'created_at' => Carbon::now(),
                            'update_at' =>Carbon::now()
                        ]);
                      // dd($add_contact);
                        app(\App\Http\Controllers\UsersController::class)->addCustomfieldValue($add_contact,$type="Subscriber");
                }
        
        app(\App\Http\Controllers\UsersController::class)->saveOtherDependencies($user->id);
        app(\App\Http\Controllers\UsersController::class)->InsertDefaultSegments($user);
        //create chat routing for ticket 
         $smsRoutingController = new SmsRoutingController();
         $smsRoutingController->createRouting($user, 4);

        return $user;
    }
}
