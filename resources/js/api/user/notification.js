import index from "../listing";

export default {
  index (paramBag) {
    return index(paramBag, '/notifications')
  },
  show (id) {
    return window.axios.get(`/notifications/${id}`)
  }
}
