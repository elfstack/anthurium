import index from "../listing";

export default {
    show (id) {
        return window.axios.get(`/data-collection/${id}`)
    },
    questions (id) {
        return window.axios.get(`/forms/${id}/questions`)
    },
    index (paramBag) {
        return index(paramBag, '/data-collection')
    },
    create (data) {
        return window.axios.post('/data-collection', data)
    },
    indexAnswers (id, paramBag) {
      return index(paramBag, `/data-collection/${id}/answers`)
    },
    showAnswersByUserId (dataCollectionId, userId) {
      return window.axios.get(`/data-collection/${dataCollectionId}/users/${userId}/answers`)
    },
    showMemberFormAnswersByUserId (userId) {
      return window.axios.get(`/users/${userId}/member-form-answers`)
    }
}
