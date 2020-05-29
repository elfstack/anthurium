import index from '../listing'

export default {
    index (paramBag) {
        return index(paramBag, '/activities')
    },
    show (id) {
        return window.axios.get(`/activities/${id}`)
    },
    update (id, activity) {
        return window.axios.patch(`/activities/${id}`, activity)
    },
    participants (id, paramBag) {
        return index(paramBag, `/activities/${id}/participants`)
    },
    statistics (id) {
        return window.axios.get(`/activities/${id}/statistics`)
    },
    updateParticipationStatus (id, status) {
        return window.axios.patch(`/participation/${id}`, {
            status: status
        })
    }
}
