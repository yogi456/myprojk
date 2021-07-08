<template> 
    <div class="row">
        <div class="col mw-560 mx-auto">
            <h2 class="fs-48 fw-600 mb-4 pb-2 text-center">Create your account</h2>
            <div class="">
                <form id="formAppLogin" class="form-horizontal fs-16 mw-450 mx-auto" role="form" method="POST">
                    <div class="form-group mb-4">
                        <label for="" class="fw-600 fs-16">Full name</label>
                        <input v-validate="'required'" v-model="register_Type.name" type="text" name="full name" id="email" class="form-control fs-16" required>
                        <!-- <span class="text-danger lh-1-5 mt-2 fs-14">{{ errors.first('full name') }}</span> -->
                        <span class="text-danger colore-red">{{ errors.first('full name')?'Full name required':'' }}</span>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="fw-600 fs-16">Password</label>
                        <input v-validate="'required'" v-model="register_Type.password" type="password" name="password" id="password" class="form-control fs-16" required>
                        <!-- <span class="text-danger lh-1-5 mt-2 fs-14">{{ errors.first('password') }}</span> -->
                        <span class="text-danger colore-red">{{ errors.first('password')?'Password required':'' }}</span>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="fw-600 fs-16">Confirm Password</label>
                        <input v-validate="'required'" v-model="register_Type.confirmpass" type="password" name="confirm password" id="password" class="form-control fs-16" required>
                        <!-- <span class="text-danger lh-1-5 mt-2 fs-14">{{ errors.first('confirm password') }}</span> -->
                        <span class="text-danger colore-red">{{ errors.first('confirm password')?'Confirm Password required':'' }}</span>
                        <span class="text-danger lh-1-5 mt-2 fs-14">{{errormassege}}</span>
                    </div>
                    <div class="form-group d-flex mb-4">
                        <div class="col-auto mt-1 pl-0">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="status" v-model="register_Type.terms">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col text-gray pr-0 text-acc-agrmnt">
                            <p class="text-black fs-14">I have read and agree to <span class="app-title notranslate">ngagge</span>'s <a href="https://www.ngagge.com/terms" class="text-primary" target="_blank">Terms of Service</a>, <a href="https://www.ngagge.com/terms" class="text-primary" target="_blank">Privacy</a> and <a href="https://www.ngagge.com/terms" class="text-primary" target="_blank">Cookie Policies</a>.</p>
                        </div>
                        <span class="text-danger lh-1-5 mt-2 fs-14">{{ errors.first('terms') }}</span>
                    </div>

                    <div class="form-group d-flex mb-4" v-if="errormassege_terms">
                        <span class="text-danger lh-1-5 mt-2 fs-14">{{errormassege_terms}}</span>
                    </div>

                    <div class="form-group">                                
                        <a  class="btn btn-block bg-black text-white fs-16 lh-1-5 py-3" @click.prevent="register" :class="{disabled: btnDisabled}">{{btntext}}</a>
                        <!--<button type="submit" class="btn btn-block bg-black text-white fs-16 lh-1-5 py-3">Register</button>-->
                    </div>

                    <div class="form-group text-center seperator">
                        <span class="or-seperator fs-16">
                            Or
                        </span>
                    </div>
                    <!--  <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-sign-w-google text-black text-center py-2" >
                                                    <img v-bind:src="siteUrl+'/images/google-icon.png'" alt='google'style="max-height: 25px;" />
                                                    <span class="px-3 mx-auto fs-16 lh-1-75 my-1">Register with<img class="ml-3" v-bind:src="siteUrl+'/images/google-icon-text.png'" alt='google'style="max-height: 25px;" /></span>
                                                </button>
                                            </div>-->
                    <div class="form-group">
<!--                        <a class="btn-link d-flex align-items-center btn-sign-w-google text-center py-0" data-target="#signINNUPWithGoogleModal" data-toggle="modal"> 
                            <img v-bind:src="siteUrl+'/images/btn_google_dark_normal_ios@3x.png'" alt='google' style="max-height: 58px;margin:-3px;" />
                            <span class="flex-grow-1">Register with Google</span>
                        </a>-->
                        <a class="btn-link d-flex align-items-center btn-sign-w-google text-center py-0" v-bind:href="siteUrl+'/auth/google'"> 
                                            <img v-bind:src="siteUrl+'/images/btn_google_dark_normal_ios@3x.png'" alt='google' style="max-height: 52px;" />
                                            <span class="flex-grow-1">Register with <label class="notranslate m-0">Google</label></span>
                                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div id="signINNUPWithGoogleModal" role="dialog" aria-labelledby="signINNUPWithGoogleModal" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-middle mw-450">
                <div class="modal-content p-5">
                    <div class="modal-body">
                        <div class="p-5">
                            <form class="" name="" action="" method="post">
                                <div class="form-group row mb-0">
                                    <label  class="col-12 col-form-label modal-delete-text">This feature is currently subject to approval by Google. If you’re a Google developer, please proceed. </label>
                                    <div class="col-12 mt-4">
                                        <a class="btn-link d-flex align-items-center btn-sign-w-google text-center py-0" v-bind:href="siteUrl+'/auth/google'"> 
                                            <img v-bind:src="siteUrl+'/images/btn_google_dark_normal_ios@3x.png'" alt='google' style="max-height: 52px;" />
                                            <span class="flex-grow-1">Register with Google</span>
                                        </a>
                                    </div>
                                </div>    
                            </form>
                        </div>
                    </div>
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
                register_Type: {
                    name: '',
                    password: '',
                    confirmpass: '',
                    email_id: this.email,
                },
                errormassege: '',
                errormassege_terms: '',
                btntext: 'Register',
                btnDisabled: false,
            }
        },
        watch: {
        },
        computed: {
        },
        components: {
        },
        methods: {
            register() {
                var $this = this;
                $this.errormassege = ''
                $this.errormassege_terms = ''
                var verify = true;
                var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
                if (!regex.test($this.register_Type.password)) {
                    $this.errormassege = "Must be at least 8 characters, include at least one upper, lower case letter and one special character.";
                    verify = false;
                } else {
                    $this.errormassege = "";
                    verify = true;
                }
                if (verify) {
                    $this.$validator.validate().then(valid => {
                        if (valid) {
                            if ($this.register_Type.password != $this.register_Type.confirmpass) {
                                $this.errormassege = "Passwords don't match";
                            } else if (!$this.register_Type.terms) {
                                $this.errormassege_terms = "Please Accept Terms of Service, Privacy & Cookie Policy";
                            } else {

                                $this.register_Type.device_type = $this.getDeviceType()

                                $this.btnDisabled = true
                                $this.btntext = 'Loading...'
                                axios.post($this.siteUrl + 'register-type', $this.register_Type
                                        ).then(function (response) {
                                    $this.btntext = 'Register'
                                    if (response.data.status == 1) {
                                        window.location.href = $this.siteUrl + "confirm/" + response.data.user_id;
                                    } else {
                                        $this.errormassege = response.data.errormsg;
                                    }
                                }).catch(function (error) {
                                    console.error(error.message);
                                });
                            }
                            /*  if ($this.register_Type.password == $this.register_Type.confirmpass) {
                             axios.post($this.siteUrl + 'register-type', $this.register_Type
                             ).then(function (response) {
                             if (response.data.status == 1) {
                             window.location.href = $this.siteUrl + "confirm/" + response.data.user_id;
                             } else {
                             $this.errormassege = response.data.errormsg;
                             }
                             
                             }).catch(function (error) {
                             console.error(error.message);
                             });
                             } else {
                             $this.errormassege = "Passwords don't match";
                             }*/
                        }
                    });
                }
            },
            getDeviceType() {
            const ua = navigator.userAgent;
            if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
                return "tablet";
            }
            if (/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
                return "mobile";
            }
            return "desktop";
        }
        },
        mounted: function () {
        },
        props: ['email'],
    }
</script>
