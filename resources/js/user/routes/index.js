import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/login',
            name: 'Login'
        },
        {
            path: '/',
            component: () => import('../layouts/App')
        }
    ]
})

export default router
