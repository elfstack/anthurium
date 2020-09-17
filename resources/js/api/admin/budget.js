import index from '../listing'

export default {
  index (activityId, paramBag) {
    return index(paramBag, `/activities/${activityId}/budgets`)
  },
  create (activityId, budget) {
    return window.axios.post(`/activities/${activityId}/budgets`, budget)
  }
}
