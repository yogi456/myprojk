
<template> 
    <div class="step-container flex-grow-1 d-flex w-100">
        <div class="row registration-form-wrap features-form-wrap" style="min-width: 0 !important;">
            <div class="col-12 mw-1100 mx-auto p-5 d-flex flex-column">
                <div class="mw-500 mx-auto mt-5">
                    <div class="text-center mb-0">
                        <h3 class="check-wether text-center mb-5 lh-1-5 fs-26">Check to see whether your <span class="app-title">ngagge</span> code was installed properly</h3> 
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-12 col-form-label text-left pt-0">Enter the URL  where you installed out chat code</label>
                        <div class="col-12 align-self-center pr-3">
                            <input type="text" class="form-control" name="url" placeholder="https:\\yourwebsite.com">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn btn-orange btn-block" v-on:click="saveStepThree">Verify your installation</button>
                    </div>  
                </div>
            </div>
            <div class="col mx-auto step2-hired-sec step-4-1 px-5 justify-content-center flex-column bg-light h-100 pt-0">
                <div class="step-wrap">                   
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:60%">
                        <span class="sr-only">60% Complete</span>
                    </div>                       
                </div>
                <div class="visitor-text-wrp d-flex">
                    <p class="visitor-text suggesation animated infinite fadeIn delay-1s mb-5 pos-rel">
                        Provide marketing, sales and support via live chat, email, SMS and AV conferencing from your 'industry-best' conversation page
                        <span class="hire-visitor-arrow slack-img animated infinite fadeIn delay-2s mt-5"> 
                            <img   v-bind:src="siteUrl+'/images/visitor-arrow.png'" alt="payment_type"/>
                        </span>
                    </p>
                </div> 
                <div class="step1-help-img text-center">
                    <div class="step2-help-wrp">                       
                        <img class="step1-help-img" style="max-width: 700px;" v-bind:src="siteUrl+'/images/step-4-1-right.jpg'" alt="payment_type"/>
                    </div> 
                </div> 
            </div>
            <div class="col mx-auto step2-hired-sec  step-4-2 px-5 justify-content-center flex-column bg-light h-100 pt-0">
                <div class="step-wrap">                   
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:60%">
                        <span class="sr-only">60% Complete</span>
                    </div>                       
                </div>
                <div class="visitor-text-wrp d-flex">
                    <p class="visitor-text suggesation animated infinite fadeIn delay-1s mb-5 pos-rel">Easily segment your stored conversations into email and SMS playbooks for lead nurturing, onboarding, sales, retention, and customer recovery

                        <span class="hire-visitor-arrow slack-img animated infinite fadeIn delay-2s mt-5"> 
                            <img   v-bind:src="siteUrl+'/images/visitor-arrow.png'" alt="payment_type"/>
                        </span>
                    </p>
                </div> 
                <div class="step1-help-img text-center">
                    <div class="step2-help-wrp">                       
                        <img class="step1-help-img" style="max-width: 700px;" v-bind:src="siteUrl+'/images/step-4-2-right.jpg'" alt="payment_type"/>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</template>
<script>

    import {siteUrl, site_root} from './../../Utitlity.js';


    export default {
        name: "step-four",
        data() {
            return {
                siteUrl: site_root,
                rolelist: '',
                role: '',
                rows: [{email: '', role: ''}],
                roleArr: [],
                emails: '',
                emailsArr: [],
                rows: [{agentname: '', email: ''}, {agentname: '', email: ''}],

            }
        },
        watch: {

        },
        computed: {

        },
        components: {

        },
        methods: {
            addMoreInvitee() {
                var lastindex = {agentname: '', email: ''};
                this.rows.push(lastindex);
                setTimeout(function () {
                    $('#addEditComAgent select').selectpicker('refresh');
                }, 1000);
            },
            removeInviteeColumn(index) {
                this.rows.splice(index, 1);
            },
            uploadInviteeCSV() {
                $('#holderOfInviteeCSV input').trigger('click');
            },
            openUploadInviteeCSV() {
                $('.btn-instruct').trigger('click');
            },
            addrows() {
                this.rows.push({email: '', role: ''});
            },
            RemoveRow(index) {
                this.rows.splice(index, 1);
            },

            saveStepThree() {
                var thisObject = this;
                axios.post(thisObject.siteUrl + 'step3', {rowsArr: thisObject.rows})
                        .then(function (response) {
                            if (response.data == 'success') {

                                window.location.href = thisObject.siteUrl + "step5";
                            } else {

                                alert('error');
                            }
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });


            },

        },
        mounted: function () {

            var thisObject = this;
            setInterval(function () {
                jQuery('.step-4-1').toggleClass('d-none');
                jQuery('.step-4-2').toggleClass('d-flex');
            }, 8000);
            axios.post(thisObject.siteUrl + 'getRoles')
                    .then(function (response) {
                        thisObject.rolelist = response.data;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
            setTimeout(function () {
                $('.registration-form select').selectpicker('refresh');
            }, 2000);



        },
    }
</script>

