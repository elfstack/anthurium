import config from "../../../api/admin/config";

const state = () => ({
  name: '',
  permissions: {},
  configs: {},
  updatedConfigs: {},
  loaded: false
})

function _keyHasPrefix (key, prefix) {
  const keyPrefix = key.split('.')[0]

  if (Array.isArray(prefix)) {
    return prefix.reduce((hasPrefix, prefix) => {
      console.log('reduce', hasPrefix)
      console.log('reduce', keyPrefix)
      console.log('reduce', prefix)
      return hasPrefix || keyPrefix === prefix
    }, false)
  } else {
    return keyPrefix === prefix
  }
}

const getters = {
  permissions(state) {
    return state.permissions;
  },
  loaded(state) {
    return state.loaded
  },
  getConfig: (state) => (key) => {
    if (state.configs[key]) return state.configs[key]
  },
  getConfigs: (state) => (prefix) => {
    const keys = Object.keys(state.configs).filter(key => _keyHasPrefix(key, prefix))

    console.log(keys)

    return keys.reduce((obj, key) => {
      return {
        ...obj,
        [key]: state.configs[key]
      }
    }, {})
  },
  hasUncommittedChanges (state) {
    return Object.keys(state.updatedConfigs).length !== 0
  }
}

const mutations = {
  setConfigs(state, payload) {
    state.name = payload.name
    state.timezone = payload.timezone
    state.permissions = payload.permissions

    state.configs = payload.configs
  },
  setConfig(state, {key, value}) {
    state.updatedConfigs[key] = value
  },
  updateConfigs (state, configs) {
    Object.assign(state.configs, configs)
  },
  setUpdatedConfigs (state, configs) {
    state.updatedConfigs = configs
  },
  setLoaded(state, payload) {
    state.loaded = payload
  },
}

const actions = {
  loadConfigs({commit}) {
    return config.show().then(({data}) => {
      commit('setConfigs', data)
      commit('setLoaded', true)
    })
  },

  async commitChanges({ state, commit }) {
    try {
      const response = await config.update(state.updatedConfigs)
      commit('updateConfigs', response.data.configs)
      commit('setUpdatedConfigs', {})
    } catch (e) {
      // TODO: handle failure and reject
    }
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
