import $ from 'jquery';
import store from './chat-window-subscriber.js';
import VeeValidate from 'vee-validate';
require('./bootstrap');



window.Vue = require('vue');
Vue.use(VeeValidate);
Vue.use(require('vue-moment'));
Vue.use(require('moment-timezone'));
Vue.component('business-window', require('./components/chat-components/iframe/business.vue'));
Vue.component('non-business-window', require('./components/chat-components/iframe/nonbusiness.vue'));
Vue.component('bot-window-preview', require('./components/chat-components/iframe/BotPreview.vue'));
Vue.component('trigger-iframe', require('./components/triggerIframe.vue'));
Vue.component('iframe-branding', require('./components/addons-components/iframe/IframeBranding.vue'));
const app = new Vue({
    store,
    el: '#app'
});
