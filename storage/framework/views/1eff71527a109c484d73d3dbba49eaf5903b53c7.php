<?php $__env->startSection('content'); ?>
<div class="register-main-content ">
    <step-one userid="<?php echo e($userid); ?>"></step-one>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.registers', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>