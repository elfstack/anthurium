export default {
    login (credential) {
        return window.axios.post('/login', credential)
    },
    logout () {
        return window.axios.get('/logout')
    },
    register (data) {
      return window.axios.post('/users', data)
    },
    getCurrent () {
        return window.axios.get('/users/current')
    }
}
