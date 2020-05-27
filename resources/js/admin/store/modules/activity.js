import activity from "../../../api/admin/activity";

const state = () => ({
    activity: {}
})

const mutations = {
    setActivity (state, activity) {
        state.activity = activity
    },
    updateActivity(state, activity) {
        for (const key in activity) {
            state.activity[key] = activity[key]
        }
    }
}

const actions = {
    getActivity ({ commit }, id) {
        return activity.show(id).then(({ data }) => {
            commit('setActivity', data.activity)
        })
    },
    updateActivity ({ state, commit }, payload) {
        return activity.update(state.activity.id, payload).then(({ data }) => {
            commit('updateActivity', data.activity)
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
