import index from "../listing";

export default {
    show (id) {
        return window.axios.get(`/guests/${id}`)
    },
    participations (id, paramBag) {
        return index(paramBag, `/guests/${id}/participations`)
    },
    index (paramBag) {
        return index(paramBag, '/guests')
    }
}
