

<?php $__env->startSection('content'); ?>

       <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4 class="heading">contact us</h4>
              <h2 class="sub-heading">let’s get in touch</h2>
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
              <h2 class="sub-heading">Send us a Message</h2>
            </div>
          </div>
          <div class="col-md-8">
            <div class="contact-form">
              <form id="sell" action="<?php echo e(url('contactSubmit')); ?>" method="post">
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-sm-12">
                   	<label>Name</label>
                    <fieldset>
                           <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                    </fieldset>
                  </div>
                 

                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Email</label>
                    <fieldset>
                           <input name="email" type="email" class="form-control" id="email" placeholder="Email" required="">
                    </fieldset>
                  </div>
                 
                 <div class="col-lg-12 col-md-12 col-sm-12">
                      <label>Subject</label>
                    <fieldset>
                      <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                        <label>Message</label>
                    <fieldset>
                      <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required=""></textarea>
                    </fieldset>
                  </div>

                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="filled-button">Send Us a message</button>
                    </fieldset>
                  </div>
                </div>
              </form>
              <div id="returnres"> </div>
            </div>
          </div>
          <div class="col-md-4">
        <ul class="accordion">
              <li>
                  <a href="mailto:info@irefill.in">Email  <i class="fa fa-envelope"></i>  </a>
                  <div class="content">
                      <p> info@irefill.in</p>
                  </div>
              </li>

               <li>
                  <a href="tel:+919111177783">Phone  <i class="fa fa-phone"></i>  </a>
                  <div class="content">
                      <p> +919111177783</p>
                  </div>
              </li>
         </ul>
            
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


     
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>