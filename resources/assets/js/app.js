/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import $ from "jquery"

//import jMouseWheel from "jscrollpane/script/jquery.mousewheel.js";
//import jScrollPane from "jscrollpane/script/jquery.jscrollpane.min.js";

//import chartjs from "chart.js/dist/Chart.js";
//import ChartDataLabels from "chartjs-plugin-datalabels";
//import intro from "intro.js/minified/intro.min.js";
//import Cropper from "cropperjs";
import slickCarousel from "slick-carousel/slick/slick.min.js"
//import malihuScrollbar from "malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js";
import VueCroppie from "vue-croppie"

import VeeValidate from "vee-validate"
import { StripeCheckout } from "vue-stripe"
import store from "./store.js"
import Vue2Filters from "vue2-filters"
import VueColumnsResizable from "vue-columns-resizable"


import VueQrcodeReader from "vue-qrcode-reader";

Vue.use(VueQrcodeReader);


Vue.use(VueColumnsResizable)
// window.Sortable = require('sorttable.js').default;
window.Popper = require("popper.js").default

require("./bootstrap")
window.Vue = require("vue")
Vue.use(require("vue-moment"))
Vue.use(require("moment-timezone"))
Vue.use(VueCroppie)
const dictionary = {
  en: {
    custom: {
      twillioimage: {
        ext: "We are accepting jpg,3ga,mp3,mp4,pdf,png,rtf,csv,jpeg Images.",
      },
    },
  },
}
Vue.use(VeeValidate, {
  fieldsBagName: "vvFields",
  dictionary,
})
Vue.use(Vue2Filters)


Vue.component("scanner-qr", () => import("./components/ScannerComponent.vue" /* webpackChunkName: "js/pages/email-confirm" */))


import Vue from "vue"
import BootstrapVue from "bootstrap-vue"
import { EventBus } from "./EventBus.js"
Vue.use(BootstrapVue)
const app = new Vue({
  store,
  el: "#app",
  mounted() {
    var thisObject = this
    thisObject.enableInterceptor()
    /*
         EventBus.$on('enable-interceptor', function (source) {
         thisObject.enableInterceptor();
         //console.log('enable-interceptor = ' + source);
         });
         EventBus.$on('disable-interceptor', function (source) {
         thisObject.disableInterceptor();
         //console.log('disable-interceptor = ' + source);
         });*/
  },
  data: {
    isLoading: true,
    axiosInterceptor: null,
    loadingCount: 0,
  },
  methods: {
    enableInterceptor() {
      this.axiosInterceptor = window.axios.interceptors.request.use(
        (config) => {
          if (config.showLoader !== undefined && config.showLoader === false) {
            return config
          }
          ++this.loadingCount
          if (this.loadingCount > 0) {
            this.isLoading = true
          }
          return config
        },
        (error) => {
          if (error.showLoader !== undefined && error.showLoader === false) {
            return Promise.reject(error)
          }
          this.isLoading = false
          return Promise.reject(error)
        }
      )
      window.axios.interceptors.response.use(
        (response) => {
          if (response.config.showLoader !== undefined && response.config.showLoader === false) {
            return response
          }
          --this.loadingCount
          if (this.loadingCount == 0) {
            this.isLoading = false
            setTimeout(function() {
              $("#app select").selectpicker("refresh")
            }, 500)
          }
          return response
        },
        (error) => {
          --this.loadingCount
          if (error.request.showLoader !== undefined && error.request.showLoader === false) {
            return Promise.reject(error)
          }
          if (this.loadingCount == 0) {
            this.isLoading = false
          }
          if (error.response.status === 401) {
            window.location = "/login"
          }
          return Promise.reject(error)
        }
      )
    },
    disableInterceptor() {
      window.axios.interceptors.request.eject(this.axiosInterceptor)
    },
  },
})
