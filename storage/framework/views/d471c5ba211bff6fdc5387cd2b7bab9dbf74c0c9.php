<div id="app-iframe-p-d-oq">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <parent-iframe-oq iframsrc="<?php echo e($iframeUrl); ?>" deviceclass="<?php echo e($deviceClass); ?>" isleft="<?php echo e($isLeft); ?>" isright="<?php echo e($isRight); ?>"></parent-iframe-oq>
</div>
<?php if(isset($gtag)): ?>
<span id='gtag' style="display: none;"><?php echo e($gtag); ?></span>
<?php endif; ?>
<input type="hidden" id="ga_auto_detect" value="<?php echo e($auto_detect); ?>" />

<script src="<?php echo e(asset('js/components/webiframevisitorparent.js')); ?>" defer></script>
<input type="hidden" id="app_base_url" value="<?php echo e(url('')); ?>" />
<script src="<?php echo e(asset('js/custom-ga-tracker.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom-data-get.js')); ?>"></script>

