<?php

namespace App;

//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use App\Model\Socialprovider\SocialProvider;
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
        'name', 'email', 'phone', 'password', 'generated_id', 'unhash_password',
      'status','gender','dob'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    

}

