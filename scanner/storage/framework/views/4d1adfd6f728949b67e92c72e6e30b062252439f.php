<?php $__env->startSection('content'); ?>
<div class="w-100">
    <code-component v-bind:started="'<?php echo e($param); ?>'"></code-component>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>