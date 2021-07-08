@extends('layouts.registers')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-9 mx-auto">

            <div class="row registration-form-wrap">
                <div class="col-sm-12 mx-auto">
                    <form id="finalform" class="registration-form" action="{{ url('/finalSave') }}" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-9">
                                <h2>Remove Free Chat 24/7 Live Branding</h2>
                                <ul>
                                    {{ csrf_field() }}
                                    <li class="form-group">
                                        <p>Change your transcript and ticket email "From" field to an email address of your choice.</p>
                                        <input type="text" class="form-control" name="fromEmail" placeholder="From: enter your preferred email"/>
                                    </li>
                                    <li class="form-group">
                                        <p>Change your email footer text and URL from ours to yours.</p>
                                        <div class="row">
                                            <span class="col-6 pr-1"><input type="text" class="form-control" name="footer_text" placeholder="Email Footer Text"/></span><span class="col-6 pl-1"><input type="text" name="footer_url" class="form-control"  placeholder="Email Footer URL "/></span>
                                        </div>
                                    </li>
                                    <li class="form-group">
                                        <p>Change our name at the bottom of your chat window to yours</p>
                                        <input type="text" class="form-control" name="chat_window_bottom" placeholder="Name on chat window"/>
                                    </li>
                                    <li class="form-group">
                                        <p>Change the logo on our software to yours</p>
                                        <div class="row">
                                            <div class="col-6 pr-1">
                                                <input type="text" class="form-control" name="software_logo_name" placeholder="Name on chat window"/>
                                            </div>
                                            <div class="col-6 align-self-center pl-1 browse-file">
                                                <label id="#bb"> Browse [150 px w  125 px h]
                                                    <input id="software_logo" type="file" id="File"   size="60"  name="software_logo" />
                                                </label> 
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-3 ">
                                <div class="row">
                                    <div class="col step-last-right pt-3 ">
                                        <div class="sl-right-inner">
                                            <div class="form-group">
                                                <select id="inputState" class="form-control" style="">
                                                    <option selected>$108 / Annually</option>
                                                    <option>...</option>
                                                </select>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div class="form-group">
                                                <select id="inputState" class="form-control" style="">
                                                    <option selected>Credit Card</option>
                                                    <option>...</option>
                                                </select>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control"  placeholder="Name on card "/>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-7 pr-1">
                                                        <input type="text" class="form-control" placeholder="Exp"/>
                                                    </div>
                                                    <div class="col-5 pl-1">
                                                        <input type="text" class="form-control" placeholder="CVC"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-block bg-blue btn-activate">Submit</a>
                                            <div class="text-center mt-5">
                                                <img src="{{url('/images/https.png')}}" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input id="submitUserHide" type="submit" class="btn btn-success float-right btn-submit" value="Submit" name="asava">
                    </form>
                </div>
            </div>
            <div class="row registration-navigation">
                <div class="col">
                    <a class="btn btn-default float-left btn-prev"  href="http://chatapp.freechat247live.com/step4">Previous</a>
                    <input id="submitUser" type="button" class="btn btn-success float-right btn-submit" value="Submit" name="sava">
                </div>
            </div>
        </div>

    </div>
</div>


<script>
    $(document).ready(function () {
        $("#submitUserHide").hide();
        $("#submitUser").click(function () {
            $("#submitUserHide").trigger('click');
        });
         $(document).on("click", "#prevStep", function (event) {
        event.preventDefault();
       window.location.href = "http://dev.local.com/freechat/step4";
        });
    });

</script>
@endsection
