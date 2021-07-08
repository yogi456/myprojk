<?php $__env->startSection('content'); ?>
    <business-window oq1="<?php echo e($subscriberGeneratedId); ?>" oq2="<?php echo e($subscriberId); ?>" oq3="<?php echo e($activeThemeId); ?>" oq4="<?php echo e($websiteId); ?>" oq5="<?php echo e($refererUrl); ?>" ></business-window>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.iframe', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>