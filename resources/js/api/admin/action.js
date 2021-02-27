import index from '../listing'

export default {
  index(paramBag, params) {
    return index(paramBag, '/actions', (query) => {
      query.pending = params['pending']
    })
  },
  show (id) {
    return window.axios.get(`/actions/${id}`)
  },
  update (id, result) {
    return window.axios.patch(`/actions/${id}`, {
      result: result
    })
  }
}
