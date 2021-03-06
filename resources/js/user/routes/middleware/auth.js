import store from "../../store";

export default async function auth (to, from, next) {
    if (['app.login', 'app.register', 'app.reset-password'].includes(to.name)) {
      next()
      return
    }

    if (!store.getters['user/loaded']) {
      await store.dispatch('user/getUser')
    }

    if (!store.getters['user/isLoggedIn']) {
      next({
        name: 'app.login',
        replace: true,
        query: {
          redirect: to.path
        }
      })
    }

    // if (!store.getters['config/loaded']) {
    //     await store.dispatch('config/getConfig')
    // }

    let hasRedirect = false

    to.matched.forEach(route => {
        if (route.meta.permission) {
            let can = store.getters['user/can'](route.meta.permission)
            if (!can) {
                hasRedirect = true
            }
        }
    })

    if (hasRedirect) {
        next({ name: '403', replace: true })
    } else {
        next()
    }
}
