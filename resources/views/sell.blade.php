@extends('layouts.app')

@section('content')

   <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Product Information</h4>
              
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
              <h2>We need some otner information from your side.</h2>
            </div>
          </div>
          <div class="col-md-8">
            <div class="contact-form">
              <form id="sell" action="{{url('sellSubmit')}}" method="post">
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-sm-12">
                   	<label>Do You need Aluminium Bottle?</label>
                    <fieldset>
                  
                      <select class="form-control" id="bottle" name="bottle" required="required" onchange="checkprice()">
                      	 
                      	 <option value="0">No</option>
                      	 <option value="1">Yes</option>

                      </select>
                    </fieldset>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                  	  	<label>Select the Product</label>
                    <fieldset>
                        <select class="form-control" name="product_id" required="required" onchange="loadQuantity(this.value)" >
                      	 
                      	 <option value="">Select</option>
                      	@foreach($products as $p)
                         <option value="{{$p->id}}">{{$p->name}}</option>
                      	@endforeach

                      </select>
                    </fieldset>
                  </div>


                  <div class="col-lg-12 col-md-12 col-sm-12">
                  	  	<label>Select the Product</label>
                    <fieldset>
                        <select class="form-control" id="quantityoption" name="quantity_id" required="required" onchange="quantitycheck(this.value)" >
                      	 <option value="">Select Quantity</option>                      
                      </select>
                    </fieldset>
                  </div>

               
                  <input type="hidden" id="bottle_price" name="bottle_price" value="0">
                  <input type="hidden"  id="product_price" name="product_price" value="0">
                   <div class="col-lg-12 col-md-12 col-sm-12">
                     <h4>Total Cart Value : <span id="totalprice"></span></h4>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="filled-button">Pay</button>
                    </fieldset>
                  </div>
                </div>
              </form>
              <div id="returnres"> </div>
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


     function  checkprice(argument) {
     	var bottleop = $("#bottle :selected").val();

      if(bottleop==1){
      $("#bottle_price").val('{{$setting->bottle_price}}');
      }else{
      	 $("#bottle_price").val('0')
      }
   
       
      var bottlePrice =   $("#bottle_price").val();
      var product_price =   $("#product_price").val();

        $("#totalprice").html(parseInt(bottlePrice)+  parseInt(product_price));

     }



     function loadQuantity(proid) {

            $.ajax({
                type: 'get',
                url: '{{url("loadQuantity")}}/'+proid,
                
                success: function (data) {
                  $("#quantityoption").html(data)
                }
            });
        } 
  
       function quantitycheck(id){
       	  $.ajax({
                type: 'get',
                url: '{{url("quantityData")}}/'+id,
                
                success: function (data) {
                    var obj = JSON.parse(data);
                    $("#product_price").val(obj.price);  
                    checkprice();
                }
            });
       }


    </script>

@endsection
