import Vue from 'vue'
import Vuex from 'vuex'
import adminUser from './modules/adminUser'
import activity from "./modules/activity"
import config from "./modules/config"

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        adminUser,
        activity,
        config
    }
})

export default store
