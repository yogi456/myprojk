<?php $__env->startSection('content'); ?>
<div class="collaboration-wrapper w-100 px-0">
    <master-collaboration-component default-thread-id="<?php echo e($defaultThreadId); ?>" oldest-unread-message-id="<?php echo e($oldestUnreadMessageId); ?>"></master-collaboration-component>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>