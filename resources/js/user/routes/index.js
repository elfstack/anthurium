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
            component: () => import('../layouts/App'),
            async beforeEnter (to, from, next) {
                await auth(to, from, next)
            },
            children: [
                {
                    path: '',
                    name: 'app.dashboard',
                    component: () => import('../pages/Dashboard/Dashboard')
                },
                {
                    path: 'user/:id(\\d+)',
                    component: () => import('../pages/User/Show'),
                    children: [
                        {
                            path: '',
                            name: 'app.user.profile',
                        },
                        {
                            path: 'participation',
                            name: 'app.user.participation'
                        }
                    ]
                },
                {
                    path: 'activities/',
                    component: { render: h => h('router-view') },
                    children: [
                        {
                            path: '',
                            name: 'app.activities.index',
                            component: () => import('../pages/Activities/Index')
                        },
                        {
                            path: ':id(\\d+)/',
                            name: 'app.activities.show',
                            component: () => import('../pages/Activities/Show')
                        }
                    ]
                },
                {
                  path: 'participations/:id',
                  component: () => import('../pages/Participations/Participation')
                },
                {
                    path: '404',
                    name: 'app.not-found',
                    component: () => import('../pages/Error/404')
                }
            ]
        }
    ]
})

export default router
