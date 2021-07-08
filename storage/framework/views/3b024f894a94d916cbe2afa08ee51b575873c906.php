<?php $__env->startSection('content'); ?>
<div class="design-wrapper integration-wrapper w-100">
    <integration-component return-msg="<?php echo e($blade['msg']); ?>"  ></integration-component>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>