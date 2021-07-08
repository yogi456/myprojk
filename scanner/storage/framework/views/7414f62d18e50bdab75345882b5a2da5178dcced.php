<?php $__env->startSection('content'); ?>
    <bot-window-preview oq1="<?php echo e($subscriberGeneratedId); ?>" oq2="<?php echo e($subscriberId); ?>" oq3="<?php echo e($activeThemeId); ?>" oq4="<?php echo e($websiteId); ?>" oq5="<?php echo e($refererUrl); ?>" oq6="<?php echo e($botId); ?>"></bot-window-preview>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web-iframe', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>