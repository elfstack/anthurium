import Vue from 'vue'
import VueRouter from 'vue-router'
import auth from './middleware/auth'
import loadConfigs from './middleware/config'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/',
      component: () => import('../layouts/App'),
      async beforeEnter(to, from, next) {
        await auth(to, from, next)
      },
      children: [
        {
          path: '/login',
          name: 'app.login',
          component: () => import('../pages/Login')
        },
        {
          path: '/register',
          name: 'app.register',
          component: () => import('../pages/Register')
        },
        {
          path: '/reset-password',
          name: 'app.reset-password',
        },
        {
          path: '',
          name: 'app.dashboard',
          component: () => import('../pages/Dashboard/Dashboard')
        },
        {
          path: 'inbox',
          name: 'app.inbox',
          component: () => import('../pages/Inbox')
        },
        {
          path: 'inbox/message/:id',
          name: 'app.inbox.message',
          component: () => import('../pages/Message')
        },
        {
          path: 'user/:id(\\d+)',
          component: () => import('../pages/User/Show'),
          children: [
            {
              path: '',
              name: 'app.user.profile',
              component: () => import('../pages/User/Profile')
            },
            {
              path: 'participation',
              name: 'app.user.participation',
              component: () => import('../pages/User/Participation')
            }
          ]
        },
        {
          path: 'activities/',
          component: {render: h => h('router-view')},
          children: [
            {
              path: '',
              name: 'app.activities.index',
              component: () => import('../pages/Activities/Index')
            },
            {
              path: ':id(\\d+)/:participationId?',
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
          path: 'forms/:id',
          name: 'app.forms.show',
          component: () => import('../pages/DataCollection/Form')
        },
        {
          path: 'member-registration',
          name: 'app.member-registration',
          component: () => import('../pages/User/MemberRegistration')
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

router.beforeEach(async (to, from, next) => {
  await loadConfigs(to, from, next)
  next()
})

export default router
