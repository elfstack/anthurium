import config from "../../../api/admin/config";

const state = () => ({
  configs: []
})

const getters = {
  getConfig: (state) => (key) => {
    if (state.configs[key]) return state.configs[key]
  },
}

const mutations = {
  setConfigs (state, payload) {
    state.configs = payload
  }
}

const actions = {
  loadConfigs ({ commit }) {
    config.show().then(({data}) => {
      commit('setConfigs', data)
    })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}

