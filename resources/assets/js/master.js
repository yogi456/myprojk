import $ from 'jquery';
//import jMouseWheel from 'jscrollpane/script/jquery.mousewheel.js';
//import jScrollPane from 'jscrollpane/script/jquery.jscrollpane.min.js';
import slickCarousel from 'slick-carousel/slick/slick.min.js';
//import malihuScrollbar from 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js';

import Vue from 'vue';
import VueCroppie from 'vue-croppie';
import VeeValidate from 'vee-validate';
import BootstrapVue from 'bootstrap-vue';

window.Vue = require('vue');
Vue.use(require('vue-moment'));
Vue.use(require('moment-timezone'));
Vue.use(VueCroppie);
Vue.use(VeeValidate, {
   fieldsBagName: 'vvFields'
});
Vue.use(BootstrapVue);

//Vue.component('app-header', require('./components/partials/header.vue'));
//Vue.component('app-sidebar', require('./components/partials/sidebar.vue'));
//Vue.component('app-footer', require('./components/partials/footer.vue'));
/*
Vue.component('app-header',() => import("./components/partials/header.vue"))
Vue.component('app-sidebar',() => import("./components/partials/sidebar.vue"))
Vue.component('app-footer',() => import("./components/partials/footer.vue"))*/