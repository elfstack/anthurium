import index from '../listing'

export default {
    index (paramBag) {
        return index(paramBag, '/activities')
    },
    show (id) {
        return window.axios.get(`/activities/${id}`)
    },
    participants (id, paramBag) {
        return index(paramBag, `/activities/${id}/participants`)
    },
    statistics (id) {
        return window.axios.get(`/activities/${id}/statistics`)
    },
    enroll (id, participant) {
        return window.axios.post(`/activities/${id}/enroll`, participant)
    }
}
