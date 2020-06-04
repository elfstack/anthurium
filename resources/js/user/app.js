import store from "./store";

require('./bootstrap');

import Vue from 'vue'
import AntDesign from 'ant-design-vue'
import VueMoment from "vue-moment";
import VueMeta from "vue-meta";

import router from "./routes";

Vue.use(AntDesign)
Vue.use(VueMoment)
Vue.use(VueMeta)

const app = new Vue({
    el: '#app',
    template: "<router-view />",
    store,
    router
})
