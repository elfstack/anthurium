import index from "../listing";

export default {
    questions (id) {
        return window.axios.get(`/forms/${id}/questions`)
    },
    saveResponse (id, response) {
      return window.axios.post(`/data-collection/${id}/response`, response)
    }
}
