export default {
  index () {
    return window.axios.get('/user_groups');
  }
}
