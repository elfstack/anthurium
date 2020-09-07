import index from "../listing";

export default {
    show (id) {
        return window.axios.get(`/forms/${id}`)
    },
    questions (id) {
        return window.axios.get(`/forms/${id}/questions`)
    },
    index (paramBag) {
        return index(paramBag, '/forms')
    },
    create (data) {
        return window.axios.post('forms', data)
    },
    createQuestion (formId, data) {
      return window.axios.post(`forms/${formId}/questions`, data)
    },
    updateQuestion (formId, questionId, data) {
      return window.axios.patch(`forms/${formId}/questions/${questionId}`, data)
    },
    removeQuestion (formId, questionId) {
      return window.axios.delete(`forms/${formId}/questions/${questionId}`)
    },
    indexAnswers (formId, paramBag) {
      return index(paramBag, `/forms/${formId}/answers`)
    },
    showAnswers (formId, answersId) {
      return window.axios.get(`/forms/${formId}/answers/${answersId}`)
    },
    getAnswersByUserId (formId, userId) {
      return window.axios.get(`/forms/${formId}/users/${userId}/answers`)
    }
}
