<?php $__env->startSection('content'); ?>



<div class="design-wrapper w-100 knowledgebase-wrapper">
    <master-knowledgebase-component username="<?php echo e(Auth::user()->name); ?>" ></master-knowledgebase-component>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>