<template> 
    <div class="row">
        <div class="col mw-560 mx-auto">
            <h2 class="fs-48 fw-600 mb-4 pb-3 border-bottom border-black">Confirm your email</h2>            
            <div class="fs-16">
                <p class="mb-3">We've sent an email to <label class="notranslate"><strong>{{email}}</strong></label></p>
                <p class="mb-3">Click the link in the email to confirm your address and start growing faster, reducing costs and providing premium support with <span class="app-title notranslate">ngagge</span> now.</p>
                <p class="mb-3">Can't see the email? Check your spam folder or</p>
                <a href='#' class="btn px-5 bg-black text-white" @click.prevent="resend">Resend</a>
                <div v-if="massege==true" class="alert alert-success" style="margin-top: 8px">
                    {{errormassege}}
                </div>
                <div v-if="status==500" class="alert alert-danger" style="margin-top: 8px">
                    {{errormassege}}
                </div>
                <div v-if="massege==true">
                    <span><strong style="font-size: 16px">You can resend mail in</strong> <span style="font-size: 16px"> 00:{{timer}}</span></span>   
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    import {siteUrl, site_root} from './../../Utitlity.js';
    export default {
        name: "step-third",
        data() {
            return {
                siteUrl: site_root,
                errormassege: '',
                massege: false,
                timer: 0,
                status:''
            }
        },
        watch: {

        },
        computed: {

        },
        components: {

        },
        methods: {
            resend() {
                var $this = this;
                if ($this.timer == 0) {
                    axios.post($this.siteUrl + 'resend-email/' + $this.userid,
                            ).then(function (response) {
                        if (response.data.status == 1) {
                            $this.massege = true;
                            $this.errormassege = "Email has been sent successfully.";
                            $this.timer = 60;
                            $this.countDownTimer();
                            setTimeout(() => {
                                $this.massege = false;
                            }, 60000);
                        }else{
                            $this.status=response.data.status;
                            $this.errormassege = "Email has been already verified.";
                             
                        }
                    }).catch(function (error) {
                        console.error(error.message);
                    });
                }

            },
            countDownTimer() {
                if (this.timer > 0) {
                    setTimeout(() => {
                        this.timer -= 1
                        this.countDownTimer()
                    }, 1000)
                }
            }
        },
        mounted: function () {

        },
        props: ['userid', 'email']
    }
</script>

