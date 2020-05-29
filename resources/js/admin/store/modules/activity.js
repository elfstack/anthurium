import activity from "../../../api/admin/activity";

const state = () => ({
    activity: {},
    statistics: {}
})

const mutations = {
    setActivity (state, activity) {
        state.activity = activity
    },
    updateActivity(state, activity) {
        for (const key in activity) {
            state.activity[key] = activity[key]
        }
    },
    setStatistics (state, statistics) {
       state.statistics = statistics
    },
    updateStatistics(state, prevStatus, newStatus) {
        state.statistics[prevStatus] -= 1
        state.statistics[newStatus] += 1
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
    },
    getStatistics ({ state, commit }, id) {
        return activity.statistics(state.activity.id).then(({ data }) => {
            commit('setStatistics', data.statistics)
        })
    },
    updateStatistics({ state, commit }, prevStatus, newStatus) {
        commit('updateStatistics', prevStatus, newStatus)
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
