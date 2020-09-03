export default {
    show () {
        // TODO: consider changing to websocket later
        return window.axios.get('/config')
    },
    group (group) {
      return window.axios.get(`/config/${group}`)
    },
    update (configs) {
      return window.axios.patch('/config', configs)
    }
}
