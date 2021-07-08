<?php $__env->startSection('content'); ?>
<div class="register-main-content ">
    <signup  email="<?php echo e($emailid); ?>"></signup>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.registers', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>