<?php

namespace App;

//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Socialprovider\SocialProvider;
use Illuminate\Notifications\Notifiable;
use DB;
use Mail;

class User extends Authenticatable
{
       use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'displayName', 'email', 'login_count', 'password', 'generated_id', 'redirect_key', 'unhash_password',
        'company_name', 'website_address', 'chat_purpose', 'role_id', 'avtar', 'parent_id', 'status',
        'system_role_id', 'stripe_id', 'cal_email', 'calendar_access_token', 'calendar_refresh_token',
        'last_picked_chat', 'is_logged_in', 'is_available', 'last_login_check','signup_step','email_veify_at','trans_lang'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'stripe_id', 'password', 'remember_token', 'unhash_password', 'google2fa_secret', 'guest_token', 'cal_email', 'cal_file', 'cal_id', 'calendar_access_token', 'calendar_refresh_token', 'stripe_acc_id'
    ];


    public function detail_user_meta()
    {
        return $this->hasMany('App\Model\Company', 'subscriber_id', 'id')->orderBy('id');
    }

    //    public function cat_starred() {
    //        return $this->hasMany('App\Model\SBCatParticipated', 'user_id', 'id');
    //    }
    
    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function updateUsersAvaiblityData($subscriberId, $loginUserId)
    {
        $this->where('id', $loginUserId)->update([
            'is_logged_in' => 1,
            'last_login_check' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        $this->where(DB::raw('UNIX_TIMESTAMP(`last_login_check`)'), '<', DB::raw('UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - 30'))
            ->where('parent_id', $subscriberId)
            ->update([
                'is_logged_in' => 0
            ]);
    }
    /**
     * Ecrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }

    /**
     * Decrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function getGoogle2faSecretAttribute($value)
    {
        if ($value != '') {
            return decrypt($value);
        }
        return '';
    }

    public function sendPasswordResetNotification($token){
    // $this->notify(new MyCustomResetPasswordNotification($token)); //<--- remove this, use Mail instead like below

    $data = [
        $this->email
    ];

    Mail::send('emails.teammate.reset-password',  [
        'name'      => $this->name,
        'token' =>$this->token,
        'reset_url'     => route('password.reset', ['token' => $token]),


    ],  function($message) use($data){
                $message->subject('Reset Password Request');
                $message->to($data[0]);
        });
}
}

