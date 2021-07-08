<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;

class ScannerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function scanner()
    {   
        return view('scanner');
    }


    public function home()
    {   
   


  if(Session::has('redirectTo'))
   {
      $redirect =  Session::get('redirectTo');
     Session::flush();
      return redirect('user-registration/'.$redirect);   
         die; 
   }


    return view('home');

    
    }
    

     public function concept()
    {   
        return view('concept');
    }
    
     public function about()
    {   
        return view('about');
    }
    
     public function contact()
    {   
        return view('contact');
    }
    
      
    public function termsConditions(){
     return view('termsCondition');   
    }

  public function privacyPolicy(){
     return view('privacyPolicy');   
    }





}
