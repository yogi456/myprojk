<?php $__env->startSection('content'); ?>
<div class="w-100">
    <routing-component routings-data="<?php echo e($routings); ?>" websites-data="<?php echo e($websites); ?>" departments-data="<?php echo e($departments); ?>"></routing-component>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>