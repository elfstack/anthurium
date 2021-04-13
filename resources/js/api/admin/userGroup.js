export default {
  index (countUsers=false) {
    return window.axios.get('/user_groups', {
      params: {
        'count_users': countUsers
      }
    });
  },
  show (id) {
    return window.axios.get(`/user_groups/${id}`)
  },
  create (data) {
    return window.axios.post(`/user_groups`, data)
  }
}
