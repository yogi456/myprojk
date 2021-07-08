<div>
    <div id="email-signature" >
        <div class="col mt-3">
            <div class="email-sign-wrapper mt-5" style="padding: 20px;border-radius: 8px;border: 1px solid rgb(204, 204, 204);margin: 0 50px;max-width: 480px;position: fixed;">
                <div id='emailSignature' class="email-sign-inner">
                    <table style="width:100%;">
                        <tr>
                            <td style="max-width:135px;width:135px;padding-right:15px;margin-bottom: 15px;">
                                <span style="display:inline-block;overflow: hidden;">
                                    <?php if(isset($signature->mainPhotoType)): ?>
                                    <img id="emailSignImage" style="max-width:120px;height:auto;border-radius:<?php echo e($signature->mainPhotoType); ?>" src="<?php echo e(url($signature->mainPhotoAgent)); ?>" alt=""/>
                                    <?php endif; ?>
                                </span>
                            </td>
                            <?php if (isset($signature->linkColor->isActive)) { ?>
                                <td style="width:3px;height:100%;border-left: 3px solid <?php echo e($signature->linkColor->value->hex); ?>"></td>
                            <?php } ?>
                            <td style="padding: 0" >
                                <table style="width:100%;">
                                    <?php
                                     if (isset($signature->name->isActive)) { 
                                     if ($signature->name->isActive || $signature->title->isActive) { ?>
                                        <tr>
                                            <td style="padding-left:15px;font-size:14px;">
                                                <strong style="display:inline-block;line-height:1;font-size:<?php echo e($signature->fontSize); ?> px"><?php echo e($signature->name->value); ?></strong>
                                                <span  style="margin:0 5px;display: inline-block;color:transparent;border-right: 2px solid #ccc;line-height:1;">l</span>
                                                <strong style="display:inline-block;line-height:1;font-size:<?php echo e($signature->fontSize); ?> px"><?php echo e($signature->title->value); ?></strong>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                    ?>
                                    <?php 
                                     if (isset($signature->phone->isActive) || isset($signature->mobile->isActive) ) { 
                                    if ($signature->phone->isActive || $signature->mobile->isActive) { ?>
                                        <tr>
                                            <td style="padding-left:15px;font-size:14px;">
                                                <span style="display:inline-block;line-height:1;" >P:&nbsp;<?php echo e($signature->phone->value); ?></span>
                                                <span  style='margin:0 5px;display: inline-block;color:transparent;border-right:2px solid #ccc;line-height:1;'>l</span>
                                                <span  style="display:inline-block;line-height:1;">M:&nbsp;<?php echo e($signature->mobile->value); ?></span>
                                            </td>
                                        </tr>
                                    <?php } 
                                     }
                                    ?>
                                    <?php if (isset($signature->address->isActive)) { ?>
                                        <tr>
                                            <td style="padding-left:15px;font-size:14px;"><span style="display: inline-block;line-height: 1;"><?php echo e($signature->address->value); ?></span></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <?php if (isset($signature->company->isActive) ) { ?>
                                        <tr>
                                            <td style="padding-left:15px;font-size:14px;"><span style="display:inline-block;line-height:1;"><?php echo e($signature->company->value); ?></span></td>
                                        </tr>
                                    <?php }
                                    ?>
                                    <?php if (isset($signature->website->isActive) ) { ?>
                                        <tr>
                                            <td style="padding-left:15px;font-size:14px;"><span style="display:inline-block;line-height:1;"><?php echo e($signature->website->value); ?></span></td>
                                        </tr>
                                    <?php }
                                    ?>
                                    <?php 
                               if (isset($signature->logo->isActive) && $signature->logo->imgSrc != ''){
                                    if ($signature->logo->isActive && $signature->logo->imgSrc != '') { ?>
                                        <tr>
                                            <td style="padding-left:15px;font-size:14px;">
                                                <span>
                                                    <img style="max-width:180px;margin-top:5px;max-height: 40px;width:auto;height:auto;" src="<?php echo e(url($signature->logo->imgSrc)); ?>" alt=""/>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                    } }
                                    ?>

                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
