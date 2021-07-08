<template> 
    <div class="row align-items-center flex-row-reverse">
        <div class="col-auto ml-auto register-main-right text-center">
            <!--<img class="img-fluid" v-bind:src="siteUrl+'images/rg-bg-gray.png'" alt=""/>-->
            <video class="mw-100" preload="metadata" autoplay playsinline muted loop>
                <source v-bind:src="siteUrl+'video/save_agent_v3.mp4'" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="col register-main-left ">
            <h2 class="regis-step-title fw-600 mb-4 pb-2 lh-1-25">Help us add defaults and chat availability</h2>
            <div class="register-main-body">
                <div class="form-group row">
                    <label for="" class="col-12 col-form-label text-left">Country</label>
                    <div class="col-12 notranslate">
                        <select v-validate="'required'" class="form-control dd-abs-menu" v-model="help_Type.country_name" name="country" >
                            <option value="">Select</option>
                            <option  v-bind:value="count.id" v-for="(count,index) in getcountry">{{count.name}}</option>
                        </select>
                        <!-- <span class="text-danger fs-14 lh-1-5 mt-2">{{ errors.first('country') }}</span> -->
                        <span class="text-danger colore-red">{{ errors.first('country')?'Country required':'' }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-12 col-form-label text-left">Time Zone</label>
                    <div class="col-12 notranslate">
                        <select v-validate="'required'" class="form-control dd-abs-menu" v-model="help_Type.time_zone" name="time zone" >
                            <option value="">Select</option>
                            <option  v-bind:value="zone.id" v-for="(zone,index) in gettimezone">{{zone.timezone}}</option>
                        </select>
                        <!-- <span class="text-danger fs-14 lh-1-5 mt-2">{{ errors.first('time zone') }}</span> -->
                        <span class="text-danger colore-red">{{ errors.first('time zone')?'Time Zone required':'' }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-12 col-form-label text-left">Your audience is:</label>
                    <div class="col-12 notranslate">
                        <div class="form-group row align-items-center">
                            <div class="col-auto">
                                <label class="switch pull-right"><input  v-validate="'required'" name="audience" value="1" v-model="help_Type.audience" type="radio" checked><span class="slider round"></span></label>
                            </div>
                            <label for="" class="col-auto col-form-label text-left min-w-0">B2B</label>
                        </div>
                        <div class="form-group row align-items-center">
                            <div class="col-auto">
                                <label class="switch pull-right"><input v-validate="'required'"  name="aud" value="2" v-model="help_Type.audience" type="radio" checked><span class="slider round"></span></label>
                            </div>
                            <label for="" class="col-auto col-form-label text-left min-w-0">B2C</label>
                        </div>
                        <div class="form-group row align-items-center">
                            <div class="col-auto">
                                <label class="switch pull-right"><input  v-validate="'required'" name="aud" value="3" v-model="help_Type.audience" type="radio" checked><span class="slider round"></span></label>
                            </div>
                            <label for="" class="col-auto col-form-label text-left min-w-0">Both</label>
                        </div>
                        <!-- <span class="text-danger fs-14 lh-1-5 mt-2">{{ errors.first('audience') }}</span> -->
                           <span class="text-danger colore-red">{{ errors.first('audience')?'Audience required':'' }}</span>
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn bg-black text-white mr-3" @click.prevent="chatHelpus">Next</button>
                        <a v-bind:href="siteUrl+'chat-feature/'+userid" class="btn border border-black ">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import {siteUrl, site_root} from './../../Utitlity.js';
    export default {
        name: "step-two",
        data() {
            return {
                siteUrl: site_root,
                help_Type: {
                    country_name: '',
                    time_zone: '',
                    audience: '',
                    d_id: this.detailid,
                    u_id: this.userid,
                    web_id:this.websiteid

                },
                gettimezone: '',
                getcountry: ''

            }
        },
        watch: {

        },
        computed: {

        },
        components: {

        },
        methods: {
            chatHelpus() {
                var $this = this;
                $this.$validator.validate().then(valid => {
                    if (valid) {
                        $this.help_Type.device_type = $this.getDeviceType()
                        axios.post($this.siteUrl + 'chat-help-us', $this.help_Type
                                ).then(function (response) {

                            if (response.data.status == 1) {
                                window.location.href = $this.siteUrl + "feature-interested/" + $this.userid + '/' + $this.detailid+'/'+$this.websiteid;
                            }

                        }).catch(function (error) {
                            console.error(error.message);
                        });
                    }
                });
            },
			 getChatHelpUs() {
                var $this = this;
                axios.post($this.siteUrl + 'get-chat-help-us', {d_id: this.detailid}
                ).then(function (response) {
                    if (response.data.status == 1) {
                        $this.help_Type.time_zone = response.data.record.timezone;
                        $this.help_Type.country_name = response.data.record.country;
                        $this.help_Type.audience = response.data.record.audience;
                    }

                }).catch(function (error) {
                    console.error(error.message);
                });
            },
            getTimezonelist() {
                var $this = this;
                axios.get($this.siteUrl + 'get-timezone'
                        ).then(function (response) {
                    if (response.data.status == 1) {
                        $this.gettimezone = response.data.gettime;
                        $this.getcountry = response.data.country;
                        setTimeout(function () {
                            $('select').selectpicker('refresh')
                        }, 1000);
                    }
  
                }).catch(function (error) {
                    console.error(error.message);
                });
            },
              getchatHelpusData() {
                var $this = this;
                axios.get($this.siteUrl + 'chatHelpusData'
                        ).then(function (response) {
                  //console.log(response.data)
                     if(response.data.country!=0){
                      $this.help_Type.country_name=response.data.country
                    }
                     if(response.data.timezone!=0){
                     $this.help_Type.time_zone=response.data.timezone
                     }
                   if(response.data.audience!=0){
                     $this.help_Type.audience=response.data.audience
                     }
                }).catch(function (error) {
                    console.error(error.message);
                });
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
            this.getTimezonelist();
            this.getchatHelpusData();
        },
        props: ['userid', 'detailid','websiteid']
    }
</script>

