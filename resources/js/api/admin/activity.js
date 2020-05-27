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
    }
}
