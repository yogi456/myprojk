<template> 
    <div id="step-1" class="step-5 ele-centered p-5 bg-white mw-1000">
        <div class="row console-head-row pt-0">
            <div class="col-12">
                <ul class="nav nav-tabs mt-0 mb-1 site-main-tabs" id="myTabOptions">
                    <li class="">
                        <a class="navbar-brand mr-0 py-0" href="#">Remove <span class="app-title">ngagge</span> Branding $12/mo</a>   
                    </li>                    
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col mx-auto ">
                <form id="finalform" class="registration-form" action="" enctype='multipart/form-data'  method="post">
                    <div class="border-gray p-5 rounded">
                        <div class="row m-0">
                            <div class="col pr-4 pb-5">
                                <div class="form-group row mb-3 pb-3">
                                    <label for="" class="col-auto col-form-label text-right">Email footer text</label>
                                    <div class="col">
                                        <input type="text" class="form-control" v-model="from_email" name="from_email" placeholder="Email Footer Text">
                                    </div>
                                </div>
                                <div class="form-group row mb-3 pb-3">
                                    <label class="col-auto col-form-label text-right pl-0">Email footer URL</label>
                                    <div class="col">
                                        <input type="text" class="form-control" v-model="email_footer_text" name="Email Footer URL" placeholder="Email Footer URL">
                                    </div>
                                </div>

                                <div class="form-group row mb-3 pb-3">
                                    <label  class="col-auto col-form-label text-right pl-0">Chat window text</label>
                                    <div class="col">
                                        <input type="text" class="form-control" v-model="name_of_chatwindow" name="name_of_chatwindow" placeholder="Name on chat window">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label  class="col-auto col-form-label text-right pl-0 pt-0 lh-1">Chat window logo</label>
                                    <div class="col dragdrop-file">
                                        <b-form-file name="software_logo" v-on:change="processFile"  v-model="file" :state="Boolean(file)" placeholder="Drag and drop or upload"></b-form-file>
                                    </div>
                                </div>
                            </div>                           
                        </div> 
                    </div>
                    <div class="row registration-navigation m-0 pb-0">
                        <div class="col px-0">
                            <a class="btn btn-lgrey float-left btn-prev text-white" href="http://chatapp.freechat247live.com/step5">Previous</a>
                            <input id="submitUser" type="submit" class="btn btn-success float-right btn-submit ml-3" value="Remove branding" name="sava">
                            <a class="btn btn-lgrey float-right btn-skip text-white" data-toggle="modal" data-target="#welcomePopup" href="http://localhost/freechatlive/step4">Skip</a>
                        </div>
                    </div>
                </form>                
            </div>
        </div>        
    </div>
</template>
<script>

    import {siteUrl, site_root} from './../../Utitlity.js';
    export default {
        name: "step-six",
        data() {
            return {
                siteUrl: site_root,
                file: '',
                cvc: '',
                expyear: '',
                expmonth: '',
                cardnumber: '',
                timeofsub: '',
                name_of_chatwindow: '',
                email_footer_url: '',
                email_footer_text: '',
                from_email: '',
                yearList: ['2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030']
            }
        },
        watch: {

        },
        computed: {

        },
        components: {

        },
        methods: {
            processFile() {


            }
        },
        mounted: function () {
//            $(document).ready(function () {
//                $("#submitUserHide").hide();
//                $("#submitUser").click(function () {
//                    $("#submitUserHide").trigger('click');
//                });
//                $(document).on("click", "#prevStep", function (event) {
//                    event.preventDefault();
//                    window.location.href = "http://dev.local.com/freechat/step4";
//                });
//                $('.registration-form select').selectpicker();
//            });

            setTimeout(function () {
                $('#finalform-form select').selectpicker();
            }, 100);
        },
    }
</script>

