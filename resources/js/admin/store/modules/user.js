import user from "../../../api/admin/user"

const state = () => {
    user: { }
}

const mutations = {
    setUser (state, user) {
        state.user = user
    }
}

const actions = {
    getUser ({ commit }, id) {
        return user.show(id).then(({ data }) => {
            commit('setUser', data.user)
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
