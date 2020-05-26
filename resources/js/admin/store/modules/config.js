import config from "../../../api/admin/config";

const state = () => ({
    name: '',
    permissions: {},
    loaded: false
})

const getters = {
    permissions (state) {
        return state.permissions;
    },
    loaded (state) {
        return state.loaded
    }
}

const mutations = {
    setConfig( state , payload) {
        state.name = payload.name
        state.permissions = payload.permissions
    },
    setLoaded( state, payload) {
        state.loaded = payload
    }
}

const actions = {
    getConfig({ commit }) {
        return config.show().then(({data}) => {
            commit('setConfig', data)
            commit('setLoaded', true)
        })
    },
    checkConfig({ commit }) {
        // TODO: check config for frontend
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
