<?php $__env->startSection('content'); ?>
<div class="design-wrapper chat-scheduling-wrapper w-100">
    <!--<master-time-component></master-time-component>-->
    <plans v-bind:started="'<?php echo e($param); ?>'"></plans>
</div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>