<?php $__env->startSection('content'); ?>
<div class="design-wrapper button-design-wrapper w-100">
    <master-chat-component-design v-bind:started="'<?php echo e($param); ?>'" v-bind:onloadthemeid="<?php echo e($onloadthemeid); ?>"></master-chat-component-design>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>