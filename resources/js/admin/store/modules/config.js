import config from "../../../api/admin/config";

const state = () => ({
    name: '',
    permissions: {},
    configs: {},
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
    },
    setConfigGroup( state, configs ) {
      Object.assign(state.configs, configs)
    }
}

const actions = {
    getConfig({ commit }) {
        return config.show().then(({data}) => {
            commit('setConfig', data)
            commit('setLoaded', true)
        })
    },
    async getValue({ commit, state }, key) {
      if (state.configs[key]) return state.configs[key]

      const group = key.split('.')[0]
      const configs = await config.group(group)
      commit('setConfigGroup', configs)

      return configs[key]
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
