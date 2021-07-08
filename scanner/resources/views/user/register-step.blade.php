@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-9 mx-auto">
            <div class="row registration-form-wrap">
                <div class="col-sm-6 mx-auto">
                    <h2 class="text-center">Your Website</h2>
                    <form class="registration-form">
                        <div class="form-group">
                            <?php session_start(); ?>
                            <input type="text" value="<?php if (isset($_SESSION['name']) && $_SESSION['name'] != '') {
                                echo $_SESSION['name'];
                            } ?>" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Your name">
                        </div>
                        <div class="form-group">

                            <input type="email" value="<?php if (isset($_SESSION['email']) && $_SESSION['email'] != '') {
                                echo $_SESSION['email'];
                            } ?>" class="form-control" id="email" placeholder="Your email">
                        </div>
                        <div class="form-group">                               
                            <input type="password" value="<?php if (isset($_SESSION['password']) && $_SESSION['password'] != '') {
                                echo $_SESSION['password'];
                            } ?>" class="form-control" id="password" placeholder="Choose password">
                        </div>                          
                    </form>
                </div>
            </div>
            <div class="row ">
                <div class="col">
                    <div class="registration-navigation">
                        <input type="button" value="Next" class="btn btn-success float-right btn-next" onclick="sendStep1()"/>
                        <a class="btn btn-default float-right btn-skip" href="/">Skip</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function sendStep1() {

        var name = $("#name").val();
        var email = $("#email").val();
        var pass = $("#password").val();
        var _token = '<?php echo csrf_token() ?>';
        $.ajax({
            type: 'POST',
            url: 'http://chatapp.freechat247live.com/step1',
            data: {_token: _token, name: name, email: email, password: pass},
            success: function (data) {
                if (data == 0) {
                    alert("error");
                } else {
//                     window.location.replace("/newpage/page.php?id='"+ data +"'");
                    window.location.href = "http://chatapp.freechat247live.com/step2";
                }
            }
        });
    }
</script>
@endsection
