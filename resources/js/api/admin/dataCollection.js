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
    indexResponses (id, paramBag) {
      return index(paramBag, `/data-collection/${id}/responses`)
    },
    showResponse (dataCollectionId, responseId) {
      return window.axios.get(`/data-collection/${dataCollectionId}/responses/${responseId}`)
    },
    showAnswersByUserId (dataCollectionId, userId) {
      return window.axios.get(`/data-collection/${dataCollectionId}/users/${userId}/answers`)
    },
    showMemberFormAnswersByUserId (userId) {
      return window.axios.get(`/users/${userId}/member-form-answers`)
    },
    listMemberFormDataCollection () {
      return window.axios.get('/data-collection?filter=purpose:member-application&orderBy=updated_at&direction=desc')
    }
}
