@extends('layouts.app')

@section('content')
<!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01" style="background-image:url(../images/1.jpg)">
          <div class="text-content">
<!--             <h4 class="heading">Best Offer</h4>
            <h2 class="sub-heading">New Arrivals On Sale</h2> -->
          </div>
        </div>
        <div class="banner-item-02" style="background-image:url(../images/2.jpg)">
          <div class="text-content">
          <!--   <h4 class="heading">Flash Deals</h4>
            <h2 class="sub-heading">Get your best products</h2> -->
          </div>
        </div>
        <div class="banner-item-03" style="background-image:url(../images/3.jpg)">
          <div class="text-content">
            <!-- <h4 class="heading">Last Minute</h4>
            <h2 class="sub-heading">Grab last minute deals</h2> -->
          </div>
        </div>
      </div>
    </div>
   
    <div class="best-features">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2 class="heading">Refill process</h2>
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content texts">
    
               <ul class="featured-list">
                <li><a href="#">Scan QR code using camera</a></li>
                <li><a href="#">Login/register</a></li>
                <li><a href="#">Do you need bottle?</a></li>
                <li><a href="#">Select your brand and quantity</a></li>
                <li><a href="#">Pay online</a></li>
                <li><a href="#">Place the bottle inside the refilling chamber</a></li>
                <li><a href="#">Wait for refill</a></li>
                <li><a href="#">Collect the bottle</a></li>
                <li><a href="#">Hola, you contributed towards better fututre</a></li>
              </ul> 
              <a href="{{url('about')}}" class="filled-button">Read More</a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="right-image">
           <img src="{{ asset('img/logo.png')}}" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>


   <div class="best-features">
      <div class="container">
  <div class="row" style="border:none;">
          <div class="col-md-12">
            <div class="section-heading">
              <h2 class="heading">Benefits</h2>
            </div>
          </div>
          <div class="col-md-12">
            <p class="sub-heading"> Reduce plastic </p>
            <div class="left-content">
              <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.
By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.
            </p>
               
            </div>
          </div>


<div class="col-md-12">
            <p class="sub-heading"> Be economical </p>
            <div class="left-content">
              <p>Play smart, Only pay for the product not for packaging. Thus, saving your money and our environment.

            </p>
               
            </div>
          </div>




<div class="col-md-12">
            <p class="sub-heading"> Your contribution  </p>
            <div class="left-content">
              <p>Imagine you using replacing 10 plastic bottles with only 1 aluminium container, your this tiny effort could make an enormous impact towards refill revolution. 

            </p>
               
            </div>
          </div>





<div class="col-md-12">
            <p class="sub-heading">  At your fingertips  </p>
            <div class="left-content">
              <p>irefill, brings you an easy to use technology wherein you have to just scan our QR code or log in to our site, choose brand, quantity & go through payment options.


            </p>
               
            </div>
          </div>


<div class="col-md-12">
            <p class="sub-heading"> The Environment  </p>
            <div class="left-content">
              <p>Most of the plastic bottles end up in either land fills or sink deep into the ocean. Thus, emitting toxins directly into the environment leading to global warming. Also they play a major role in leaching the oceans, destroying an entire food chain of aquatic life.



            </p>
               
            </div>
          </div>




        </div>
 </div>
</div>



  <div class="best-features">
      <div class="container">
  <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2 class="heading">Plastic related content</h2>
            </div>
          </div>
          <div class="col-md-6">
            <p > Every year around the world we create more than 300 million tonnes of plastic – and half of this is single-use. One of the worst offenders are plastic bottles, with a million of them sold every minute around the world–a figure that’s expected to grow by 20% by 2021.</p>

          </div>

           <div class="col-md-6"  >
            <p style="font-style: italic;font-weight: bold;"> 79 per cent of the plastic made in the world enters our land, water and environment as   waste; some of it also enters our bodies through the food chain, says the CSE analysis</p>

          </div>

        </div>

   <div class="filters-content">
                <div class=" grid">
                    <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        
                        <div class="down-content">
                          <!-- <a href="#"><h4>Tittle goes here</h4></a>
                          <h6>$18.25</h6> -->
                          <p>3.3 Million 
                            Metric tonnes 
                            per year
                            Plastic waste generated by India
                            </p>
                          <!-- <ul class="stars">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                          </ul>
                          <span>Reviews (12)</span> -->
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        
                        <div class="down-content">

                          <p>40% 
Plastic enters in land, water & environment as waste. 
                            </p>
                          
                        </div>
                      </div>
                    </div>


                    <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        
                        <div class="down-content">

                          <p>60% Recycled 

                            </p>
                          
                        </div>
                      </div>
                    </div>
                </div>
                <div class="r grid">

                    <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        
                        <div class="down-content">

                          <p>8 million tonnes of plastic waste entering the ocean every year


                            </p>
                          
                        </div>
                      </div>
                    </div>


                    <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        
                        <div class="down-content">

                          <p>The total plastic in the ocean amounts to 150 million tonnes 

                            </p>
                          
                        </div>
                      </div>
                    </div>



                    <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        
                        <div class="down-content">

                          <p>Plastic packaging accounts for 62% of all items recovered in the coastal clean-up efforts

                            </p>
                          
                        </div>
                      </div>
                    </div>
           </div>

           <div class=" grid">


                    <div class="col-lg-4 col-md-4 all des">
                      <div class="product-item">
                        
                        <div class="down-content">

                          <p>In 2014, there was 1 kg of plastic in the ocean for every 5kg of fish, and by 2050 there will be more plastic than fish 


                            </p>
                          
                        </div>
                      </div>
                    </div>


                  </div>
                </div>

      </div>

    </div>


@endsection
