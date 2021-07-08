<?php $__env->startSection('content'); ?>
<div class="register-main-content ">
    <confirm userid="<?php echo e($userid); ?>" email="<?php echo e($email); ?>"></confirm>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.registers', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>