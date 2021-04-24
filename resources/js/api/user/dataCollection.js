import index from "../listing";

export default {
    show (id) {
        return window.axios.get(`/data-collection/${id}`)
    },
    index (paramBag) {
        return index(paramBag, '/data-collection')
    },
    saveResponse (id, response) {
      return window.axios.post(`/data-collection/${id}/response`, response)
    },
    showResponse (id) {
      return window.axios.get(`/data-collection-response/${id}`)
    }
}
