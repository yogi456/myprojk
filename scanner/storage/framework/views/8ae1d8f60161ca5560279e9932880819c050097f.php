<?php $__env->startSection('content'); ?>
<div class="design-wrapper">
    <master-report-component></master-report-component>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-related-js'); ?>
<script src="<?php echo e(asset('js/components/report.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>