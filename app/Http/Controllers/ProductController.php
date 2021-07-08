<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Session;
use DB;
use Mail;
use Auth;
class ProductController extends Controller
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
    public function userRegister($qrcode)
    {   

/*
   $array_session = array(
          'qrcode'=>$qrcode,
          'userdata'=>'',
          'product_id'=>'',
          'quantity'=>'',
          'bottle'=>false   //true yes false no,

                 );*/

   Session::put('qrcode', $qrcode);


  // $sessiondata =  Session::get('qrcode');

   if(!Auth::check()){
   Session::put('redirectTo', $qrcode);
     return redirect(url('login')) ;
   }

        return view('user-register');
    }     


  public function checknumber($number){

  $user = User::where('phone',$number)->first();

   if($user){
     $array = array('data'=>1,'user'=>$user);
   }else{
     $array = array('data'=>0,'user'=>$user);
   }

   return response(json_encode($array));
  }

      
public function userRegisterSubmit(Request $request)
    {   

     
  $user = User::where('phone',$request->phone)->first();

   if($user){
       User::where('id',$user->id)->update(['name'=>$request->name,'gender'=>$request->gender,'dob'=>$request->dob]);
        $user = User::where('id',$user->id)->first();
   }else{
   $user =     User::create(['name'=>$request->name,'phone'=>$request->phone,'gender'=>$request->gender,'dob'=>$request->dob]);
   }


  Session::put('userdata', $user);
  
  return redirect(url('/sell'));
   
    }

    

public function sell()
    {   

     $qrcode =  Session::get('qrcode');

   $setting = DB::table('setting')->first();
   $products = DB::table('products')->where('machinecode',$qrcode)->get();


     return view('sell',compact('setting','products'));
    }


public function loadQuantity($proid){

$quantity = DB::table('quantity')->where('product_id',$proid)->get();

    $return = '<option value="">Select Quantity</option>';

    foreach ($quantity as $key => $value) {
           $return .= '<option  value="'.$value->id.'">'.$value->quantity.' ml</option>';
    }

    echo $return;
}

public function quantityData($id){
    $quantity = DB::table('quantity')->where('id',$id)->first();

   return response(json_encode($quantity)); 
}



public function payment($id){

  $data_payment  = DB::table('payment')->where('id',$id)->first();  
    $userdata  = User::find($data_payment->user_id);  

   return view('payment',compact('data_payment','userdata'));
}

 public function sellSubmit(Request $request){

   $userdata =  Session::get('userdata');
   $qrcode =  Session::get('qrcode');


  $array= array(
    'user_id'=>$userdata->id,
    'qrcode'=>$qrcode,
    'product_id'=>$request->product_id,
    'quantity_id'=>$request->quantity_id,
    'bottle'=>$request->bottle,
    'price'=>$request->product_price+$request->bottle_price,
    'payment_status'=>0,

      );


   $id =  DB::table('payment')->insertGetId($array);

   Session::put('payment_id', $id);

  return redirect('payment/'.$id);
 }


public function paymentSubmit(Request $request){

  $payment_id =  Session::get('payment_id');

 
  $update = DB::table('payment')->where('id',$payment_id)->update(['payment_status'=>1,'razorpay_payment_id'=>$request['razorpay_payment_id']]);


   

  if($update){
      return redirect('final-status/'.$payment_id);
  }
  
}

  public function FinalSubmit($id){
   
     $paymentdata  = DB::table('payment')->where('id',$id)->first(); 
      $userdata  = User::find($paymentdata->user_id);  
     return view('final-status',compact('paymentdata','userdata'));
  }

  public function paymentdata($id){

  $paymentdata  = DB::table('payment')->where('id',$id)->first(); 
  return response(json_encode($paymentdata));
  }





   public function paymentdata_api(){

$paymentdata  = DB::table('payment')->where('status',0)->get(); 

return response(json_encode(array('status'=>200,'paymentdata'=>$paymentdata)));
   }


   public function update_status(Request $request){
   try {
      $update = DB::table('payment')->where('id',$request->id)->update(['percent'=>$request->percent,'status'=>$request->status]);

      if($update){
      return response(json_encode(array('status'=>200,'msg'=>'Updated ')));
      }else{
        return response(json_encode(array('status'=>201,'msg'=>'Error')));
      }
   } catch (Exception $e) {
      return response(json_encode(array('status'=>201,'msg'=>$e)));
   }
  
   }


 public function contactSubmit(Request $request){

     $receiverAddress ='';

  Mail::send('email.slotemail', ['name' => $request->name, 'email' => $request->email, 'subject' => $request->subject, 'msg' => $request->message], function($messages) use($receiverAddress) {
                $messages->to('atul1994namdeo@gmail.com')->subject("Irefill Contact Request");
                $messages->from(env('MAIL_FROM_ADDRESS'));
            });

  return redirect(url('contact'));

 }


public function statistics(Request $request){

  $msg = '';
  $statistics ='';
 $setting = DB::table('setting')->get();

  if( isset($request->code)){

   if($request->code==$setting[0]->code){
  
    Session::put('access', true);
    $msg = 'Code Matched';
  return view('statistics',compact('msg','statistics'));
   }else{
    $msg = 'Sorry Wrong Code';
  return view('statistics',compact('msg','statistics'));  
   }



  

  }


  $statistics = DB::table('payment')->select('payment.*','users.name as username','users.phone','users.gender','users.dob','products.name as productname','quantity.quantity as quantityml')
  ->join('users','payment.user_id','users.id')
  ->join('products','payment.product_id','products.id')
  ->join('quantity','payment.quantity_id','quantity.id')
  ->get();



 return view('statistics',compact('msg','statistics')); 
}

 public function myorders()
 {


 $statistics = DB::table('payment')->select('payment.*','users.name as username','users.phone','users.gender','users.dob','products.name as productname','quantity.quantity as quantityml')
  ->join('users','payment.user_id','users.id')
  ->join('products','payment.product_id','products.id')
  ->join('quantity','payment.quantity_id','quantity.id')
  ->where('payment.user_id',Auth::user()->id)
  ->get();



 return view('myorder',compact('statistics'));

 }





}



