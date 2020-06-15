export default {
    login (credential) {
        return window.axios.post('/login', credential)
    },
    logout () {
        return window.axios.get('/logout')
    },
    getCurrent () {
        return window.axios.get('/users/current')
    }
}
