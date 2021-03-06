import router from './routes'
import axios from 'axios'
import { debounce } from "lodash";
import { message } from "ant-design-vue";
import Vue from 'vue'
import store from "./store"

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

const instance = axios.create({
    baseURL: '/api',
    withCredentials: true,
    headers: {
        common: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    },
})

const action = debounce(function action (response) {
    switch (response.status) {
        case 401:
            if (router.currentRoute.name !== 'app.login') {
                store.dispatch('user/logout')
                message.warning('Logged out')
            }
            break;
        case 403:
            message.error('You don\'t have permission to do this')
            break;
        case 404:
            router.push({ name: 'app.not-found' })
            break;
        case 500:
            message.error(response.data.message ? response.data.message : 'Server error')
            break;
    }
}, 200)

instance.interceptors.response.use(undefined, error => {
    action(error.response)
    return Promise.reject(error)
})

window.axios = instance
Vue.prototype.axios = axios

export default instance

