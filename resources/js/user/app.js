import store from "./store";

require('./bootstrap');

import Vue from 'vue'
import AntDesign from 'ant-design-vue'
import VueMoment from "vue-moment";
import VueMeta from "vue-meta";
import config from "./utils/config";

import router from "./routes";

Vue.use(AntDesign)
Vue.use(VueMoment)
Vue.use(VueMeta)
Vue.use(config)

const app = new Vue({
    el: '#app',
    template: "<router-view />",
    store,
    router
})

Vue.prototype.$isLoggedIn = () => store.getters['user/isLoggedIn']
