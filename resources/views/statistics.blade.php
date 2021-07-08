@extends('layouts.app')

@section('content')

       <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Data Statistics</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if(empty(Session::get('access')))
<div class="send-message">
      <div class="container">
        <div class="row">
         
          <div class="col-md-8">

            <div class="contact-form">
              <form id="sell" action="{{url('statistics')}}" method="post">
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Code</label>
                    <fieldset>
                           <input name="code" type="text" class="form-control" id="code" placeholder="Please Enter Code" required="">
                    </fieldset>
                  </div>
                 
                 <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="filled-button">Verify</button>
                    </fieldset>
                  </div>
                </div>
              </form>
              <div id="returnres">
                @if($msg!='') 
                {{$msg}}
                @endif
               </div>
            </div>
          </div>
          <div class="col-md-4">
            @if(!empty(Session::get('access')))
       
             @endif
           
          </div>
        </div>
      </div>
    </div>
   @endif

 
  @if(!empty(Session::get('access')))

  <div class="send-message">
      <div class="container">
        <div class="row">
         
          <div class="col-md-12">
          <table class="table table-bordered">
             <thead>
                <tr>
                  <th>Machine</th>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Bottle</th>
                  <th>User Detail</th>
                  <th>Price</th>
                  <th>Payment id</th>
                   <th>Fill Status</th>
                  <th>Time</th>
                </tr>
             </thead>

             <tbody>
              @if($statistics)
                @foreach($statistics as $st)
                   <tr>
                     <td>{{$st->qrcode}}</td>
                     <td>{{$st->productname}}</td>
                     <td>{{$st->quantityml}}</td>
                     <td>{{$st->bottle}}</td>
                     <td>{{$st->username}} <br> {{$st->phone}} <br> {{$st->gender}} <br> {{$st->dob}} </td>
                     <td>{{$st->price}}</td>
                     <td>{{$st->razorpay_payment_id}}</td>
                     <td>{{$st->percent}}</td>
                     <td>{{$st->created_at}}</td>


                   </tr>
                 
                @endforeach
              @endif
             </tbody>

          </table>
         
          </div>
         
        </div>
      </div>
    </div>

         @endif

      <script>


     
    </script>

@endsection
