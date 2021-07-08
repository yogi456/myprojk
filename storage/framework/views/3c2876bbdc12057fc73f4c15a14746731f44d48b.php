<?php if ($from == "agentReschedule" || $from == "cancel") { ?>
    <strong>Your slot is canceled </strong>
<?php }
?>
<?php if ($from != "agentReschedule" && $from != "cancel") { ?>
    <strong>Your slot is booked </strong>
<?php }
?>

<p><?php echo e($Selectdate); ?></p>
<p><?php echo e($Selectdateevent); ?></p>
<?php if ($jitsilink != "") { ?>
    <strong>Link : <?php echo e($jitsilink); ?> </strong>
<?php }
?>
<?php if ($from == "visitor") { ?>
    <a class="btn btn-orange" href="<?php echo e(url('/event-link-visitor/'.$geteventcompany.'/'.$geteventlink.'/'.$eventid)); ?>">Rescheduled</a>
    <a class="btn btn-orange" href="<?php echo e(url('/event-cancel/'.$geteventcompany.'/'.$geteventlink.'/'.$eventid)); ?>">Cancel</a>
    <?php
}
?>

<?php echo $__env->make('emails.signature', array('signature' =>$ticketSignSett), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
