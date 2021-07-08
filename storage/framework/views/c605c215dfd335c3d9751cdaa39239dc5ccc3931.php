

<?php $__env->startSection('content'); ?>

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
    <?php if(empty(Session::get('access'))): ?>
<div class="send-message">
      <div class="container">
        <div class="row">
         
          <div class="col-md-8">

            <div class="contact-form">
              <form id="sell" action="<?php echo e(url('statistics')); ?>" method="post">
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
                <?php if($msg!=''): ?> 
                <?php echo e($msg); ?>

                <?php endif; ?>
               </div>
            </div>
          </div>
          <div class="col-md-4">
            <?php if(!empty(Session::get('access'))): ?>
       
             <?php endif; ?>
           
          </div>
        </div>
      </div>
    </div>
   <?php endif; ?>

 
  <?php if(!empty(Session::get('access'))): ?>

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
              <?php if($statistics): ?>
                <?php $__currentLoopData = $statistics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <tr>
                     <td><?php echo e($st->qrcode); ?></td>
                     <td><?php echo e($st->productname); ?></td>
                     <td><?php echo e($st->quantityml); ?></td>
                     <td><?php echo e($st->bottle); ?></td>
                     <td><?php echo e($st->username); ?> <br> <?php echo e($st->phone); ?> <br> <?php echo e($st->gender); ?> <br> <?php echo e($st->dob); ?> </td>
                     <td><?php echo e($st->price); ?></td>
                     <td><?php echo e($st->razorpay_payment_id); ?></td>
                     <td><?php echo e($st->percent); ?></td>
                     <td><?php echo e($st->created_at); ?></td>


                   </tr>
                 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
             </tbody>

          </table>
         
          </div>
         
        </div>
      </div>
    </div>

         <?php endif; ?>

      <script>


     
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>