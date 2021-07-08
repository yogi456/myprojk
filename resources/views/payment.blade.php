@extends('layouts.app')

@section('content')

  <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Payment Processing .....</h4>
              
            </div>
          </div>
        </div>
      </div>
    </div>






<button id="rzp-button1" style="display: none;">Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "rzp_test_4i8iorT0xoLbjL", // Enter the Key ID generated from the Dashboard
    "amount": "{{$data_payment->price}}00", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "Irefill Payment by {{$userdata->name}}",
    "description": "Irefill Payment by {{$userdata->name}}  Rs {{$data_payment->price}}",
    "image": "{{url('img/logo.png')}}",
    //"order_id": "order_9A33XWu170gUtm", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
   "callback_url": "{{url('paymentSubmit')}}",
    "prefill": {
        "name": " {{$userdata->name}}",
        "email": "dummy@gmail.com",
        "contact": "{{$userdata->phone}}"
    },
    "notes": {
        "address": "Irefill"
    },
    "theme": {
        "color": "#F2184F"
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}

 @if($data_payment->payment_status==0)


  document.getElementById('rzp-button1').click();

 @endif



</script>   


@endsection
