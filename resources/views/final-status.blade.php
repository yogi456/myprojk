@extends('layouts.app')

@section('content')

   <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Filling Status  : <span id="percent"></span>%</h4>
              
            </div>
          </div>
        </div>
      </div>
    </div>
<div class="send-message">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Detailed Information of the Order</h2>
            </div>
          </div>
          <div class="col-md-8">
            <div class="contact-form">
            
                <div class="row">

                   <div class="col-lg-12 col-md-12 col-sm-12">
                   	<label>Order Details </label>
                    <fieldset>
                      <p> Name  : {{$userdata->name}}</p>
                      <p> Phone : {{$userdata->phone}}</p>
                      <p> Price : INR {{$paymentdata->price}}</p>
                      <p> Razorpay : {{$paymentdata->razorpay_payment_id}}</p>
                          
                    </fieldset>
                  </div>

                </div>
              
            </div>
          </div>
          <div class="col-md-4">
            <!-- <ul class="accordion">
              <li>
                  <a>Accordion Title One</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Second Title Here</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Accordion Title Three</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Fourth Accordion Title</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
            </ul> -->
          </div>
        </div>
      </div>
    </div>


 
    <script>

   setInterval(function(){ 

    paymentdata('{{$paymentdata->id}}');
 }, 2000);

      function paymentdata(id) {

            $.ajax({
                type: 'get',
                url: '{{url("paymentdata")}}/'+id,
                
                success: function (data) {
                  var obj = JSON.parse(data);

                  $("#percent").html(obj.percent)
                }
            });
        } 
  

    </script>

@endsection
