import Vue from 'vue'
import VueRouter from 'vue-router'
import auth from './middleware/auth'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/login',
            name: 'app.login',
            component: () => import('../pages/Login')
        },
        {
            path: '/reset-password',
            name: 'app.reset-password',
        },
        {
            path: '/',
            async beforeEnter (to, from, next) {
                await auth(to, from, next)
            },
            component: () => import('../layouts/App')
        }
    ]
})

export default router
