import Vue from 'vue'
import VueRouter from 'vue-router'
import auth from './middleware/auth'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/login',
      // TODO: rename to admin.login
      name: 'Login',
      component: () => import('../pages/Login')
    },
    {
      path: '/reset-password',
      name: 'admin.reset-password',
      component: () => import('../pages/Auth/ResetPassword')
    },
    {
      path: '/password-reset/:token/:email',
      name: 'admin.password-reset',
      component: () => import('../pages/Auth/PasswordReset')
    },
    {
      path: '/',
      component: () => import('../layouts/App'),
      async beforeEnter(to, from, next) {
        await auth(to, from, next)
      },
      children: [
        {
          path: '',
          name: 'admin.dashboard',
          component: () => import('../pages/Dashboard/Index')
        },
        {
          path: 'profile',
          name: 'admin.profile',
          component: () => import('../pages/AdminUsers/Profile')
        },
        {
          path: 'activities/',
          component: {render: h => h('router-view')},
          children: [
            {
              path: '',
              name: 'admin.activities.activities',
              component: () => import('../pages/Activities/Index'),
              meta: {
                keepAlive: true
              }
            },
            {
              path: 'create',
              name: 'admin.activities.create'
            },
            {
              path: ':id(\\d+)/',
              component: () => import('../pages/Activities/Show'),
              children: [
                {
                  path: '',
                  component: () => import('../pages/Activities/Fragments/Overview'),
                  name: 'admin.activities.show.overview'
                },
                {
                  path: 'budget-expense',
                  component: () => import('../pages/Activities/Fragments/BudgetExpense'),
                  name: 'admin.activities.show.budget-expense'
                },
                {
                  path: 'data-collection',
                  component: () => import('../pages/Activities/Fragments/DataCollection'),
                  name: 'admin.activities.show.data-collection'
                },
                {
                  path: 'itinerary',
                  component: () => import('../pages/Activities/Fragments/Itinerary'),
                  name: 'admin.activities.show.itinerary'
                },
                {
                  path: 'participants',
                  component: () => import('../pages/Activities/Fragments/Participants'),
                  name: 'admin.activities.show.participants'
                },
                {
                  path: 'settings',
                  component: () => import('../pages/Activities/Fragments/Settings'),
                  name: 'admin.activities.show.settings'
                }
              ]
            },
          ]
        },
        {
          path: 'users/',
          component: {render: h => h('router-view')},
          children: [
            {
              path: '',
              name: 'admin.members.index',
              component: () => import('../pages/Users/Index')
            },
            {
              path: 'membership',
              name: 'admin.members.membership',
              component: () => import('../pages/Users/Membership')
            },
            {
              path: 'membership/data-collection/:id',
              name: 'admin.members.membership.data-collection.show',
              component: () => import('../pages/DataCollection/Show')
            },
            {
              path: 'application',
              name: 'admin.members.application',
              component: () => import('../pages/Users/Application')
            },
            {
              path: 'create',
              name: 'admin.members.create',
              component: () => import('../pages/Users/Create')
            },
            {
              path: ':id(\\d+)/',
              component: () => import('../pages/Users/Show'),
              children: [
                {
                  path: '',
                  name: 'admin.members.show.account',
                  component: () => import('../pages/Users/Fragments/Account')
                },
                {
                  path: 'membership',
                  name: 'admin.members.show.membership',
                  component: () => import('../pages/Users/Fragments/Membership')
                },
                {
                  path: 'participation',
                  name: 'admin.members.show.participation',
                  component: () => import('../pages/Participants/Show'),
                  meta: {
                    participantType: 'user'
                  }
                }
              ]
            }
          ]
        },
        {
          path: 'data-collection/',
          component: {render: h => h('router-view')},
          children: [
            {
              path: ':id(\\d+)/',
              name: 'admin.data-collection.show',
              component: () => import('../pages/DataCollection/Show')
            },
            {
              path: 'create',
              name: 'admin.data-collection.create',
              component: () => import('../pages/DataCollection/Create')
            }
          ]
        },
        {
          path: 'forms/',
          component: {render: h => h('router-view')},
          children: [
            {
              path: '',
              name: 'admin.forms.index',
              component: () => import('../pages/Forms/Index')
            },
            {
              path: ':id(\\d+)/',
              component: {render: h => h('router-view')},
              children: [
                {
                  path: '',
                  name: 'admin.forms.show',
                  component: () => import('../pages/Forms/Show.vue')
                },
                {
                  path: 'data-collection',
                  name: 'admin.forms.show.data-collection',
                  component: () => import('../pages/Forms/DataCollection')
                },
                {
                  path: 'answers/:answersId(\\d+)',
                  name: 'admin.forms.show.answers',
                  component: () => import('../pages/Forms/Answers.vue')
                }
              ]

            }
          ]
        },
        {
          path: 'user-groups/',
          component: {render: h => h('router-view')},
          children: [
            {
              path: '/',
              name: 'admin.user-groups.index',
              component: () => import('../pages/UserGroups/Index')
            },
            {
              path: 'create',
              name: 'admin.user-groups.create',
              component: () => import('../pages/UserGroups/Create')
            },
            {
              path: ':id(\\d+)',
              name: 'admin.user-groups.show',
              component: () => import('../pages/UserGroups/Show')
            }
          ]
        },
        {
          path: 'manage-access/',
          component: {render: h => h('router-view')},
          children: [
            {
              path: 'admin-users/',
              component: {render: h => h('router-view')},
              meta: {
                permission: 'admin.admin-users'
              },
              children: [
                {
                  path: '/',
                  name: 'admin.manage-access.admin-users.index',
                  component: () => import('../pages/AdminUsers/Index')
                },
                {
                  path: ':id(\\d+)',
                  name: 'admin.manage-access.admin-users.show',
                  component: () => import('../pages/AdminUsers/Show')
                },
                {
                  path: 'create',
                  name: 'admin.manage-access.admin-users.create',
                  component: () => import('../pages/AdminUsers/Create')
                },
              ]
            },
            {
              path: 'roles/',
              component: {render: h => h('router-view')},
              meta: {
                permission: 'admin.roles'
              },
              children: [
                {
                  path: '/',
                  name: 'admin.manage-access.roles.index',
                  component: () => import('../pages/Roles/Index'),
                  children: [
                    {
                      path: ':id',
                      name: 'admin.manage-access.roles.index.show',
                      component: () => import('../pages/Roles/Show')
                    }
                  ]
                }
              ]
            },
            {
              path: 'audits/',
              component: {render: h => h('router-view')},
              meta: {
                permission: 'admin.audits'
              },
              children: [
                {
                  path: '/',
                  name: 'admin.manage-access.audits.index',
                  component: () => import('../pages/Audits/Index')
                }
              ]
            }
          ]
        },
        {
          path: 'site-settings/',
          component: {render: h => h('router-view')},
          meta: {
            permission: 'admin.settings'
          },
          children: [
            {
              path: 'site-info',
              name: 'admin.site-settings.site-info',
              component: () => import('../pages/Settings/Info')
            },
            {
              path: 'storage',
              name: 'admin.site-settings.storage',
              component: () => import('../pages/Settings/Storage')
            }
          ]
        },
        {
          path: '/403',
          name: '403',
          component: () => import('../pages/Error/403')
        },
        {
          path: '/not-found',
          name: '404',
          component: () => import('../pages/Error/404')
        },
        {
          path: '*',
          redirect: '/not-found'
        }
      ]
    },
  ]
})

export default router
