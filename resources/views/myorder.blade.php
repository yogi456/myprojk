@extends('layouts.app')

@section('content')

       <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>My Orders</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  

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
                 <!-- <th>User Detail</th> -->
                  <th>Price</th>
                  <th>Payment id</th>
                   <th>Fill Status</th>
                  <th>Time</th>
                  <th>Status</th>
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
                    <!--  <td>{{$st->username}} <br> {{$st->phone}} <br> {{$st->gender}} <br> {{$st->dob}} </td> -->
                     <td>{{$st->price}}</td>
                     <td>{{$st->razorpay_payment_id}}</td>
                     <td>{{$st->percent}}</td>
                     <td>{{$st->created_at}}</td>
                     <td><a href="{{url('/final-status')}}/{{$st->id}}">Check</td>


                   </tr>
                 
                @endforeach
              @endif
             </tbody>

          </table>
         
          </div>
         
        </div>
      </div>
    </div>


      <script>


     
    </script>

@endsection
