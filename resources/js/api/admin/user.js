import index from "../listing";

export default {
    show (id) {
        return window.axios.get(`/users/${id}`)
    },
    participations (id, paramBag) {
        return index(paramBag, `/users/${id}/participations`)
    },
    index (paramBag) {
        return index(paramBag, '/users')
    },
    update (id, data) {
        return window.axios.patch(`/users/${id}`, data)
    }
}
