export default {
  current () {
    // TODO: get all current participation
  },
  listUserParticipation(uid, params) {
    return window.axios.get(`users/${uid}/participations`, {
      params: params
    })
    //
  },
  show (id) {
    return window.axios.get('participations/' + id)
  },
  otp (id) {
    return window.axios.get(`participations/${id}/otp`)
  }
}
