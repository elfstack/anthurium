import user from "../../../api/user/user";
import router from '../../routes'

const state = () => ({
    id: '',
    name: '',
    email: '',
    roles: [],
    avatar_url: '',
    is_member_application_form_filled: false,
    loaded: false
})

const getters = {
    user (state) {
        return state
    },
    loaded (state) {
        return state.loaded
    },
    can: (state, getters, rootState, rootGetters) => (permission) => {
        // setting up first
        const roles = rootGetters['config/permissions'][permission]
        if (!roles) {
            return false
        }
        const myRoles = state.roles

        let tmp = roles.concat(myRoles)

        return new Set(tmp).size < tmp.length
    },
    isLoggedIn (state) {
        return state.id !== ''
    }
}

const mutations = {
    setUser (state, user) {
        if (user === null) {
            state.id = ''
            state.name = ''
            state.email = ''
            state.roles = []
        } else {
            state.id = user.id
            state.name = user.name
            state.email = user.email
            state.roles = user.roles
            state.avatar_url = user.avatar_url
            state.is_member_application_form_filled = user.is_member_application_form_filled
        }
    },
    setLoaded (state, loaded) {
        state.loaded = loaded
    }
}

const actions = {
    login ({ commit, state, dispatch }, credential) {
      return user.login(credential).then(({data}) => {
            dispatch('getUser').then(() => {
              router.push(router.currentRoute.query.redirect || '/')
            })
        })
    },
    getUser({ commit }) {
        return user.getCurrent().then(({data}) => {
            commit('setUser', data.user)
            commit('setLoaded', true)
        }).catch(e => {
            if (e.response.status === 401) {
                commit('setUser', null)
                commit('setLoaded', true)
            }
        })
    },
    logout ({ commit }) {
        return user.logout().then(({data}) => {
            router.push('/login');
            commit('setUser', null)
            commit('setLoaded', false)
        })
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
