export default {
  current () {
    // TODO: get all current participation
  },
  show (id) {
    return window.axios.get('participations/' + id)
  },
  otp (id) {
    return window.axios.get(`participations/${id}/otp`)
  }
}
