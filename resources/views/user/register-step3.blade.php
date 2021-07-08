@extends('layouts.registers')

@section('content')



<div class="container">
   
    <div class="row">
        <div class="col-md-9 mx-auto">
            <div class="row registration-form-wrap">
                <div class="col-sm-8 mx-auto">
                    <h2 class="text-center">Add Team Members</h2>
                    <form class="registration-form" name="aaa" method="post" action="{{ url('/step3') }}">
                        <div class="form-group">
                            
                            <?php if ( session()->get('roleEmail') != '') { ?>
                                <div id="appDiv" >
                                    <?php foreach (session()->get('roleEmail') as $key => $val) { ?>
                                        <div class="row mt-2">
                                            <div class="col-md-7">
                                                {{ csrf_field() }}
                                                <input type="email" value="<?php echo $val; ?>"  class="form-control" name="role_email[]"  aria-describedby="emailHelp" placeholder="Email Address">

                                            </div>
                                            <div class="col-md-4 pl-0">
                                                <div class="form-group mb-0">
                                                    <select name="role[]"  class="form-control">
                                                        <option>Role</option>

                                                        <?php foreach ($roles as $role) { ?>
                                                            <option value="<?php echo $role->id; ?>" <?php
                                                            if (session('roleId')[$key] == $role->id) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $role->role; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                </div>
                                            </div>

                                            <?php if ($key == 0) { ?>
                                                <div class="col-md-1 align-self-center pl-0">
                                                    <input type="button"  class="btn btn-info p1 add-row" value="Add">
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-1 align-self-center pl-0">
                                                    <input type="button"  class="btn btn-info p-1 delete-row" value="Remove">
                                                </div>

                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>

                            <?php } else { ?>

                                <div id="appDiv" >
                                    <div class="row">
                                        <div class="col-md-7">
                                            {{ csrf_field() }}
                                            <input type="email"   class="form-control" name="role_email[]" value=" {{ Session::get('email')}}"  aria-describedby="emailHelp" placeholder="Email Address">
                                        </div>
                                        <div class="col-md-4 pl-0">
                                            <div class="form-group mb-0">
                                                <select name="role[]"  class="form-control">
                                                    <option>Role</option>

                                                    <?php foreach ($roles as $role) { ?>
                                                        <option value="<?php echo $role->id; ?>" <?php if ($role->id == 1) {
                                                    echo "selected";
                                                } ?>><?php echo $role->role; ?></option>
    <?php } ?>
                                                </select>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-1 align-self-center pl-0">
                                            <input type="button"  class="btn btn-info p-1 add-row" value="Add">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-7">
                                            {{ csrf_field() }}
                                            <input type="email"   class="form-control" name="role_email[]"  aria-describedby="emailHelp" placeholder="Email Address">
                                        </div>
                                        <div class="col-md-4 pl-0">
                                            <div class="form-group mb-0">
                                                <select name="role[]"  class="form-control">
                                                    <option>Role</option>

                                                    <?php foreach ($roles as $role) { ?>
                                                        <option value="<?php echo $role->id; ?>"><?php echo $role->role; ?></option>
    <?php } ?>
                                                </select>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>


                                        </div>
                                        <div class="col-md-1 align-self-center pl-0">
                                            <input type="button"  class="btn btn-info p-1 delete-row" value="Remove">
                                        </div>
                                    </div>
                                </div>
<?php } ?>
                            <input type="submit" id="step5sa" class="btn btn-success float-right btn-next" value="Next">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row registration-navigation">
                <div class="col">
                    <!--<a class="btn btn-default float-left btn-prev" href="{{ url('/step3') }}">Previous</a>-->
                    <input type="button" id="step5" class="btn btn-success float-right btn-next" value="Next">
                    <a class="btn btn-default float-right btn-skip"  href="http://localhost/freechatlive/step4">Skip</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        $("#step5sa").hide();
        $(".add-row").click(function () {
            var markup = '<div class="row can-rem mt-2" ><div class="col-md-7"><input type="email" class="form-control" name="role_email[]"  aria-describedby="emailHelp" placeholder="Email Address"></div><div class="col-md-4 pl-0"><div class="form-group mb-0"><select name="role[]"  class="form-control"><option selected>Role</option><option value="1">Agent</option><option value="2">Administrator</option></select><i class="fa fa-angle-down" aria-hidden="true"></i></div></div><div class="col-md-1 align-self-center pl-0"><input type="button"  class="btn btn-info p-1 delete-row" value="Remove"> </div></div>';
            $("#appDiv").append(markup);
        });

        // Find and remove selected table rows

        $(document).on("click", ".delete-row", function () {
            $(this).parents(":eq(1)").remove();
        });
        $(document).on("click", "#step5", function () {
            $("#step5sa").trigger('click');
        });
        $(document).on("click", "#skipStep", function (event) {
            event.preventDefault();
            window.location.href = "http://dev.local.com/freechat/step4";
        });
    });
</script>
</div>

</div>


@endsection
