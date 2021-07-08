<template>
    <div class="row flex-row-reverse">
        <div class="col-auto ml-auto register-main-right text-center">
            <video class="mw-100" preload="metadata" autoplay playsinline muted loop>
                <source v-bind:src="siteUrl+'video/bba_v6.mp4'" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="col register-main-left ">
            <h2 class="regis-step-title lh-1-25 fw-600 mb-5 pb-2">Let's set up your<br> chat feature </h2>
            <div class="register-main-body">
                <form  class="form-horizontal fs-14" role="form" method="POST">
                    <div class="form-group row">
                        <label for="" class="col-12 col-form-label text-left">Company</label>
                        <div class="col-12">
                            <input  v-validate="'required'" v-model="chat_Type.company_name" type="text" name="company" class="form-control"/>
                            <!-- <span class="text-danger fs-14 lh-1-5 mt-2">{{ errors.first('company') }}</span> -->
                            <span class="text-danger colore-red">{{ errors.first('company')?'Company required':'' }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-12 col-form-label text-left">Website</label>
                        <div class="col-12">
                            <input v-validate="'required'" v-model="chat_Type.website_name" type="url" placeholder="https://www.example.com"  name="website" class="form-control"/>
                            <!-- <span class="text-danger fs-14 lh-1-5 mt-2" v-if="!errormassege" >{{ errors.first('website')}}</span> -->
                            <span class="text-danger colore-red"  v-if="!errormassege">{{ errors.first('website')?'Website required':'' }}</span>
                        </div>
                        <span  class="text-danger fs-14 lh-1-5 mt-2 ml-3" v-if="errormassege">{{ errormassege }}</span>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-12 col-form-label text-left">Industry</label>
                        <div class="col-12">
                            <select v-validate="'required'" class="form-control dd-abs-menu" v-model="chat_Type.industries_name" name="industry" >
                                <option value="" disabled="">Select</option>
                                <option  v-bind:value="idtry.id" v-for="(idtry,index) in chat_Type.industry">{{idtry.industry}}</option>
                            </select>
                            <!-- <span class="text-danger fs-14 lh-1-5 mt-2">{{ errors.first('industry') }}</span> -->
                              <span class="text-danger colore-red"  v-if="!errormassege">{{ errors.first('industry')?'Industry required':'' }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-12 col-form-label text-left">Employees</label>
                        <div class="col-12">
                            <select  v-validate="'required'" class="form-control dd-abs-menu"  v-model="chat_Type.employee_name" name="employees" >
                                <option value="" disabled="">Select</option>
                                <option  v-bind:value="emp.id" v-for="(emp,index) in chat_Type.employee">{{emp.no_of_emp}}</option>
                            </select>
                            <!-- <span class="text-danger fs-14 lh-1-5 mt-2">{{ errors.first('employees') }}</span> -->
                             <span class="text-danger colore-red"  v-if="!errormassege">{{ errors.first('employees')?'Employees required':'' }}</span>
                        </div>
                    </div>
                    <div class="form-group row mt-5">
                        <div class="col-12">
                            <button type="submit" class="btn bg-black text-white"  @click.prevent="chatFeature">Next</button>
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
        name: "step-one",
        data() {
            return {
                siteUrl: site_root,
                chat_Type: {
                    company_name: '',
                    website_name: '',
                    industries_name: '',
                    employee_name: '',
                    industry: '',
                    employee: '',
                    user_id: this.userid,
                    detail_id: '',
                    web_id: ''

                },
                errormassege: ''

            }
        },
        watch: {

        },
        computed: {

        },
        components: {

        },
        methods: {
            chatFeature() {

                var $this = this;
                $this.errormassege = '';
                $this.$validator.validate().then(valid => {
                    if (valid) {
                        if ($this.validURL($this.chat_Type.website_name)) {
                            $this.chat_Type.device_type = $this.getDeviceType()
                            var obj = $this.chat_Type.website_name;
                            var str = obj.split("//");
                            if (!(str[0] == 'http:' || str[0] == 'https:')) {
                                str = 'http://' + str;
                                $this.chat_Type.website_name = str;
                            }
                            axios.post($this.siteUrl + 'chat-feature-type', $this.chat_Type,
                                    ).then(function (response) {

                                if (response.data.status == 1) {
                                     window.location.href = $this.siteUrl + "help-us/" + $this.userid + '/' + response.data.detail_id + '/' + response.data.web_id;
                                }

                            }).catch(function (error) {
                                console.error(error.message);
                            });

                        } else {
                            $this.errormassege = "Invalid Website format";
                        }
                    }
                });
            },
            getindustrydata() {
                var $this = this;
                axios.get($this.siteUrl + 'industry-employee'
                        ).then(function (response) {
                    if (response.data.status == 1) {
                        $this.chat_Type.industry = response.data.industry;
                        $this.chat_Type.employee = response.data.employee;
                        setTimeout(function () {
                            $('select').selectpicker('refresh')
                        }, 1000);
                    }

                }).catch(function (error) {
                    console.error(error.message);
                });
            },
            getRegisterDetails() {
                var $this = this;
                axios.get($this.siteUrl + 'get-details/' + $this.userid
                        )
                        .then(function (response) {
                            if (response.data.status == 1) {
                                $this.chat_Type.company_name = response.data.company.company_name;
                                $this.chat_Type.website_name = response.data.website.website_url;
                                $this.chat_Type.industries_name = response.data.company.industry;
                                $this.chat_Type.employee_name = response.data.company.num_of_employees;
                            }

                        }).catch(function (error) {
                    console.error(error.message);
                });
            },
            validURL(str) {
                var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
                        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
                        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
                        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
                return !!pattern.test(str);
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
        mounted() {
            this.getindustrydata();
            this.getRegisterDetails();

        },
        props: ['userid']
    }
</script>

