<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <event-link-visitor v-bind:eventdata="<?php echo e($scheduleevents); ?>" v-bind:getevent="<?php echo e($geteventid); ?>"></event-link-visitor>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>