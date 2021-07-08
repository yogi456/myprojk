<?php $__env->startSection('content'); ?>
<div class="row flex-column">
    <header class="pt-3">
        <div class="container-fluid py-4 mw-1400">
            <div class="row align-items-center mx-0">
                <div class="col-auto rig-logo">
                    <a href="/"><img src="<?php echo e(asset('/images/ngagge-logo.png')); ?>" alt=""></a>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid mw-1400 mt-5 center-box-wrap">
        <div class="row">
            <div class="col mx-auto mw-560">
                <h2 class="fs-48 fw-600 mb-4 pb-2 mt-5 text-center">Welcome <?php echo e($agentname); ?></h2>
                <div class="login-wrap px-5">
                   
                        <?php if (isset($errormsg)) { ?>
                             <div class="row">
                            <div class="text-center">
                                <strong> <?php echo $errormsg; ?></strong>
                            </div>
                           </div>
                        <?php } ?>
                         <div class="row">
                        <div class="col login-form-part ">
                            <form id="login-form" class="m-0 form-app-default" role="form" method="POST" action="<?php echo e(url('/setinvitee')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                    <label for="" class="fw-600 fs-16">Password</label>
                                    <input type="password" id="password" class="form-control" name="password" r name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                    <input type="hidden" name="inviteeId" value="<?php echo $inviteeId; ?>">

                                    <?php if($errors->has('email')): ?>
                                    <span class="help-block"><strong><?php echo e($errors->first('email')); ?></strong></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                    <label for="" class="fw-600 fs-16">Confirm Password</label>
                                    <input id="confirm_password" type="password" class="form-control" name="confirm_password" required="">
                                    <?php if($errors->has('password')): ?>
                                    <span class="help-block"><strong><?php echo e($errors->first('password')); ?></strong></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group row mx-0">
                                    <div class="col-auto mt-1 pl-0">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" name="status" value="1" >
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col text-gray pr-0 text-acc-agrmnt">
                                        <p class="text-black fs-14">I have read and agree to <span class="app-title">ngagge</span>'s <a href="https://www.ngagge.com/terms" class="text-primary" target="_blank">Terms of Service</a>, <a href="https://www.ngagge.com/terms" class="text-primary" target="_blank">Privacy</a> and <a href="https://www.ngagge.com/terms" class="text-primary" target="_blank">Cookie Policies</a>.</p>
                                    </div>
                                </div>
                                <p class="fs-14 text-warning mb-3" id="invalid">Use 8 or more character's with mix letters, numbers & symbols.</p>
                                <p id="passmatch" class="fs-14 text-danger mb-3">Password does not match.</p>
                                <button id="login" type="submit" disabled  class="btn btn-block bg-black text-white fs-16 lh-1-5 py-3">Continue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var myInput = document.getElementById("password");
    var myInput1 = document.getElementById("confirm_password");

    document.getElementById("invalid").style.display = "none";
    document.getElementById("passmatch").style.display = "none";
    myInput.onblur = function () {
        validate();
    }

    myInput.onkeyup = function () {
        validate();
    }
    myInput1.onblur = function () {
        var myInput1 = document.getElementById("password");
        var myInput11 = document.getElementById("confirm_password");

        if (myInput1.value != myInput11.value) {
            document.getElementById("passmatch").style.display = "block";
        } else {
            document.getElementById("passmatch").style.display = "none";
        }
    }


    function validate() {
        var myInput = document.getElementById("password");
        var upperCaseLetters = /[A-Z]/g;
        var lowerCaseLetters = /[a-z]/g;
        var specialChars = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
        if (myInput.value.match(lowerCaseLetters) && myInput.value.match(specialChars) && (myInput.value.length >= 8)) {
            document.getElementById("invalid").style.display = "none";
        } else {
            document.getElementById("invalid").style.display = "block";
        }

    }


   $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $("#login").prop('disabled', false);
            }
            else if($(this).prop("checked") == false){
                  $("#login").prop('disabled', true);
            }
        });
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth-app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>