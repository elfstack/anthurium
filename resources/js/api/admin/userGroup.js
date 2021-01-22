export default {
  index (countUsers=false) {
    return window.axios.get('/user_groups', {
      params: {
        'count_users': countUsers
      }
    });
  }
}
