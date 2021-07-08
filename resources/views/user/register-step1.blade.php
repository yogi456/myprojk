@extends('layouts.registers')

@section('content')

<div class="container step-2">
    <div class="row">
        <div class="col-md-9 mx-auto">

            <div class="row registration-form-wrap">
                <div class="col-sm-6 mx-auto">
                    <h2 class="text-center">Your Website</h2>
                    <form class="registration-form" >
                        <div class="form-group">
                            <?php // session_start(); ?>
                            <input type="text" class="form-control" value="<?php if (isset($_SESSION['companyname']) && $_SESSION['companyname'] != '') {
                                echo $_SESSION['companyname'];
                            } ?>" id="companyname" aria-describedby="emailHelp" placeholder="Company Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" value="<?php if (isset($_SESSION['websiteaddress']) && $_SESSION['websiteaddress'] != '') {
                                echo $_SESSION['websiteaddress'];
                            } ?>" class="form-control" id="websiteaddress" aria-describedby="emailHelp" placeholder="Website Address" required>
                        </div>
                        <div class="form-check">
                            <span>Chat Purpose:</span>
                            <label class="form-check-label">                                    
                                <input  name="chatPurpose" value="1" <?php if (isset($_SESSION['chatStatus']) && $_SESSION['chatStatus'] == '1') {
                                echo "checked";
                            } ?> type="checkbox" class="form-check-input">
                                <span>Sales</span>
                            </label>
                            <label class="form-check-label"> 
                                <input  name="chatPurpose" value="2" <?php if (isset($_SESSION['chatStatus']) && $_SESSION['chatStatus'] == '2') {
                                echo "checked";
                            } ?> type="checkbox" class="form-check-input">
                                <span>Support</span>
                            </label>
                            <label class="form-check-label"> 
                                <input  name="chatPurpose" value="3" <?php if (isset($_SESSION['chatStatus']) && $_SESSION['chatStatus'] == '3') {
                                echo "checked";
                            } ?> type="checkbox" class="form-check-input">
                                <span>Lead Generation</span>
                            </label>
                        </div>

                    </form>
                </div>
            </div>
            <div class="row registration-navigation">
                <div class="col">
                    <!--<a class="btn btn-default float-left btn-prev" href="{{ url('/register') }}">Previous</a>-->
                    <input type="button" onclick="sendStep2()" class="btn btn-success float-right btn-next"  value="Next" >
                    <a class="btn btn-default float-right btn-skip" href="">Skip</a>
                </div>
            </div>
        </div>
    </div>


</div>


<script>
    function sendStep2() {


        var companyname = $("#companyname").val();
        var websiteaddress = $("#websiteaddress").val();
        var chatStatus = $("input[name='chatPurpose']:checked").val();

        var _token = '<?php echo csrf_token() ?>';
        if (companyname != '' && websiteaddress != '' && chatStatus != undefined) {
            $.ajax({
                type: 'POST',
                url: 'http://dev.local.com/freechat/step1saave',
                data: {_token: _token, companyname: companyname, websiteaddress: websiteaddress, chatStatus: chatStatus},
                success: function (data) {
                    if (data == 'success') {
                        window.location.href = "http://dev.local.com/freechat/step2";
                    } else {
                        alert(data);
                    }
                }
            });
        } else {
            alert("Please Fill All Feilds");
        }
    }
</script>
@endsection
