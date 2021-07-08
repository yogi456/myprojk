<template> 
    <div class="step-container flex-grow-1 d-flex w-100">
        <div class="row registration-form-wrap features-form-wrap" style="min-width: 0 !important;">
            <div class="col-12 mw-1100 mx-auto p-5 d-flex flex-column">
                <div class="text-center text-left d-flex mb-0">
                    <p>Check to see whether your <span class="app-title">ngagge</span> code was installated properly</p> 
                </div>
                <div class="clear p-2"> </div>
                <div class="text-center text-left d-flex mb-0">
                    <p>Enter the URL where you installed out chat code</p> 
                </div>
                <div class="border-gray  py-4 rounded notification-wrapper">
                    <input type="text" class="form-control" name="url" placeholder="https:\\yourwebsite.com">
                </div>
                <div class="clear p-2"> </div>
                <div class="clear p-2"> </div>
                <div class="left-col">
                    <button type="button" class="btn btn-orange">Your installtion was successful</button>
                    <button type="button" class="btn btn-orange ml-3" v-on:click="saveStepThree">Continue</button>
                </div>  
            </div>
            <div class="col mx-auto step2-hired-sec px-5 justify-content-center flex-column bg-light h-100 pt-0">
                <div class="step-wrap">                   
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                        <span class="sr-only">80% Complete</span>
                    </div>                       
                </div>
                <div class="visitor-text-wrp d-flex">
                    <p class="visitor-text suggesation animated infinite fadeIn delay-1s mb-5 pos-rel">Our 'Knowledge Base' tool saves valuable agent time, speeds up team training, and results in satisfied customers.  Yes, that's right. . ..more profit !                       
                        <span class="hire-visitor-arrow slack-img animated infinite fadeIn delay-2s mt-5"> 
                            <img   v-bind:src="siteUrl+'/images/visitor-arrow.png'" alt="payment_type"/>
                        </span>
                    </p>
                </div> 
                <div class="step1-help-img text-center">
                    <div class="step2-help-wrp">                       
                        <img class="step1-help-img" style="max-width: 700px;" v-bind:src="siteUrl+'/images/step-5-right.jpg'" alt="payment_type"/>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</template>
<script>

    import {siteUrl, site_root} from './../../Utitlity.js';
    import PopupCodeComponent from './../PopupCodeComponent.vue';
    import RemoveBrandingPopup from './../RemoveBrandingPopup.vue';


    export default {
        name: "step-fifth",
        data() {
            return {
                siteUrl: site_root,
                directHireOurProgrammer: false,
                sessions: ''
            }
        },
        watch: {

        },
        computed: {

        },
        components: {
            'popup-code-component': PopupCodeComponent,
            'remove-branding-popup': RemoveBrandingPopup,
        },
        methods: {
            openAllPluginModal: function () {
                $('#allPluginModal').modal('show');
            },

        },
        mounted: function () {
            $('#hireOurProgrammer').on('hidden', function () {
                this.directHireOurProgrammer = false;
            });
            $(document).ready(function () {
                $(document).on("click", "#skipStep", function (event) {
                    event.preventDefault();

                    window.location.href = "http://dev.local.com/freechat/step6";
                });
                $(document).on("click", "#prevStep", function (event) {
                    event.preventDefault();
                    window.location.href = "http://dev.local.com/freechat/step4";

                });

            });
            var thisObject = this;
            axios.post(thisObject.siteUrl + 'getsession', {getsession: 'getsession'})
                    .then(function (response) {
                        thisObject.sessions = response.data;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });

        },
        //  props:['username','useremail','usercompany','userwebsite']
    }
</script>
