import index from "../listing";

export default {
  index (paramBag) {
    return index(paramBag, '/notifications')
  },
  show (id) {
    return window.axios.get(`/notifications/${id}`)
  },
  markSelectedAsRead (ids) {
    return window.axios.put('/notifications', {
      notification_ids: ids
    })
  },
  destroySelected (ids) {
    return window.axios.delete('/notifications', {
      data: {
        notification_ids: ids
      }
    })
  },
  destroy (id) {
    return window.axios.delete(`/notifications/${id}`)
  }
}
