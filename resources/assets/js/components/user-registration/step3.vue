<template>
    <div class="row align-items-center flex-row-reverse">
        <div class="col-auto ml-auto register-main-right text-center">
            <img class="img-fluid" v-bind:src="siteUrl + 'images/hero-home.jpg'" alt="" />
            <!--            <video class="mw-100" preload="metadata" autoplay playsinline muted loop>
                            <source v-bind:src="siteUrl+'video/features_display_720p.mp4'" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>-->
        </div>
        <div class="loader-overlay" v-show="!loaded">
            <span class="loading-icon">
                <img v-bind:src="siteUrl + 'images/loding-icon.svg'" width="52" />
            </span>
        </div>
        <div class="col  register-main-left">
            <h2 class="regis-step-title lh-1-25 fw-600 mb-3">Let us know the features you're interested in</h2>
            <p class="mb-4 regis-step-sub-text">With this information, our 24/7 live support team will tell you the easiest and fastest way to start generating more revenue and saving cost and management while providing premium support from all of our features.</p>
            <div class="register-main-body mw-100">
                <div class="form-group row mb-2 align-items-center notranslate">
                    <div class="col-6 mb-2" v-for="feature in interested_features">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label class="switch pull-right"><input name="" type="checkbox" v-model="feature.status" checked/><span class="slider round"></span></label>
                            </div>
                            <label for="" class="col-auto col-form-label text-left min-w-0">{{ feature.name }}</label>
                        </div>
                    </div>
                </div>
                <span class="text-danger">{{ errormassege }}</span>
                <div class="form-group row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn bg-black text-white mr-3" @click.prevent="interestFeature">Submit</button>
                        <a v-bind:href="siteUrl + 'help-us/' + userid + '/' + detail_id + '/' + websiteid" class="btn border border-black">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { siteUrl, site_root } from "./../../Utitlity.js";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    name: "step-third",
    data() {
        return {
            siteUrl: site_root,
            detail_id: this.detailid,
            user_id: this.userid,
            web_id: this.websiteid,
            interested_features: [
                { name: "Live Chat", status: false },
                { name: "Bots", status: false },
                { name: "WhatsApp", status: false },
                { name: "SMS Messaging", status: false },
                { name: "Facebook Messenger", status: false },
                { name: "CRM", status: false },
                { name: "Marketing Automation", status: false },
                { name: "Tickets", status: false },
                { name: "Knowledgebase Tools", status: false },
                { name: "Video Marketing", status: false },
                { name: "Team messaging", status: false },
                // {'name': 'Post Animated Design', 'status': false},
                // {'name': 'Video Marketing', 'status': false},
                // {'name': 'Email', 'status': false},
                //
                //                    {'name': 'Marketing Automation', 'status': false},
                //                    {'name': 'Knowledgebase Tools', 'status': false},
                //                    {'name': 'Team Messaging', 'status': false},
                //                    {'name': 'Customer Feedback Forum', 'status': false}
            ],
            errormassege: "",
            isValidate: false,
            interested_features_db: [],
            isChat: false,
            loaded: true,
        };
    },
    watch: {},
    computed: {},
    components: {},
    methods: {
        interestFeature() {
            var $this = this;
            $this.loaded = false;
            $this.checkValidation();

            if ($this.isValidate) {
                axios
                    .post($this.siteUrl + "interrested-feature", {
                        features: $this.interested_features,
                        d_id: $this.detailid,
                        u_id: $this.userid,
                        web_id: $this.websiteid,
                        device_type: $this.getDeviceType()
                    })
                    .then(function(response) {
                        if (response.data.status == 1) {
                            $this.isChat = $this.CheckChat();
                            if ($this.mobileCheck()) {
                                window.location.href = $this.siteUrl + "m-get-started";
                            } else if ($this.isChat) {
                                window.location.href = $this.siteUrl + "button-design?sub=get-started";
                            } else {
                                window.location.href = $this.siteUrl + "get-started?from=signup";
                            }
                        }
                    })
                    .catch(function(error) {
                        console.error(error.message);
                        $this.loaded = true;
                    });
            } else {
                $this.loaded = true;
                $this.errormassege = "Please select atleast one.";
            }
        },
        CheckChat() {
            var $this = this;
            for (var i = 0; i < $this.interested_features.length; i++) {
                if ($this.interested_features[i].name == "Live Chat" || $this.interested_features[i].name == "Bots") {
                    if ($this.interested_features[i].status == true) {
                        return true;
                    }
                }
            }
        },

        checkValidation() {
            this.interested_features.forEach((item) => {
                if (item.status) {
                    this.isValidate = true;

                    return false;
                }
            });
        },
        mobileCheck() {
            let check = false;
            (function(a) {
                if (
                    /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) ||
                    /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
                        a.substr(0, 4)
                    )
                )
                    check = true;
            })(navigator.userAgent || navigator.vendor || window.opera);
            return check;
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
        },
    },
    mounted: function() {
        var $this = this;
        axios
            .get($this.siteUrl + "interrested-feature-getdata")
            .then(function(response) {
                $this.interested_features_db = response.data;
                /// $this.interested_features = response.data
            })
            .catch(function(error) {
                console.error(error.message);
            });

        setTimeout(() => {
            for (var i = 0; i < $this.interested_features.length; i++) {
                for (var d = 0; d < $this.interested_features_db.length; d++) {
                    if ($this.interested_features_db[d].name == $this.interested_features[i].name) {
                        $this.interested_features[i].status = $this.interested_features_db[d].status;
                    }
                }
            }
        }, 2000);
    },
    props: ["userid", "detailid", "websiteid"],
};
</script>
