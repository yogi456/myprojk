@extends('layouts.registers')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-9 mx-auto">

            <div class="row registration-form-wrap">
                <div class="col-sm-6 mx-auto">
                    <h2 class="text-center" style="width: 440px;margin-left: -35px;">Add Chat Code to Your Website</h2>
                    <p>Copy and paste this code on every page of your website just above the </body> tag</p>
                    <form class="registration-form">
                        <div class="form-group">
                            <textarea class="form-control" readonly="true" cols="10" rows="5">
                                    
                            </textarea>
                        </div>
                        <div class="form-group">
                            <p>or use one of these plugins</p>
                        </div>
                        <div class="form-group">
                            <select id="inputState" class="form-control">
                                <option selected>Plugins</option>
                                <option>...</option>
                            </select>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </div>
                        <div class="form-group">
                            <p>or copy and paste the code into an <a class="text-blue" href="">email</a> to your developer</p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row registration-navigation">
                <div class="col">
                    <a class="btn btn-default float-left btn-prev" id="prevStep" href="{{ url('/step3') }}">Previous</a>
                    <a class="btn btn-success float-right btn-next" href="{{ url('/step5') }}">Next</a>
                    <a class="btn btn-default float-right btn-skip" id="skipStep" href="">Skip</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $(document).on("click", "#skipStep", function (event) {
            event.preventDefault();

            window.location.href = "http://dev.local.com/freechat/step4";
        });
        $(document).on("click", "#prevStep", function (event) {
            event.preventDefault();
            window.location.href = "http://dev.local.com/freechat/step3";

        });

    });


</script>
@endsection
