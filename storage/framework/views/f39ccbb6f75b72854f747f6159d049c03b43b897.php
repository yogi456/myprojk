<?php $__env->startSection('content'); ?>
<div class="register-main-content ">
    <step-third userid="<?php echo e($userid); ?>" detailid="<?php echo e($detailid); ?>" websiteid="<?php echo e($websiteid); ?>"></step-third>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.registers', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>