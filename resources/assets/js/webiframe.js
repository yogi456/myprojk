import $ from "jquery"
import store from "./chat-window.js"
import VeeValidate from "vee-validate"
//import malihuScrollbar from "malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"
require("./bootstrap")

window.Vue = require("vue")
Vue.use(VeeValidate)
Vue.use(require("vue-moment"))
Vue.use(require("moment-timezone"))
/*
Vue.component("chat-window", () => import("./components/chat-components/iframe/chatwindow.vue" ))
Vue.component("test-chat-window", () => import("./components/chat-components/iframe/testchatwindow.vue" ))
Vue.component("event-link", () => import("./components/chat-components/event-link/EventLink.vue"))
Vue.component("event-link-visitor", () => import("./components/chat-components/event-link/EventLinkvisitor.vue" ))
Vue.component("event-cancel", () => import("./components/chat-components/event-link/Eventcancel.vue" ))

Vue.component("bot-window-preview", require("./components/chat-components/iframe/BotPreview.vue")) ///for preview bot component

Vue.component("loader", require("./components/LoaderComponent.vue"))*/
//import Vue from 'vue';
//import 'bootstrap/dist/css/bootstrap.css'
//import 'bootstrap-vue/dist/bootstrap-vue.css'
import BootstrapVue from "bootstrap-vue"
Vue.use(BootstrapVue)
const app = new Vue({
  store,
  el: "#app",
  mounted() {
    var thisObject = this
    thisObject.enableInterceptor()
  },
  data: {
    isLoading: false,
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
