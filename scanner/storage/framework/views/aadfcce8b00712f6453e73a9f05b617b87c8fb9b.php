<?php $__env->startSection('content'); ?>
<div class="design-wrapper  w-100">
    <conversation-hub></conversation-hub>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-related-js'); ?>
<script src="<?php echo e(asset('js/components/conversation-hub.js')); ?>"></script>
<script src="<?php echo e(asset('js/split.min.js')); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>