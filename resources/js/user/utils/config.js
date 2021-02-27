import store from "../store";

export default  {
  install (Vue) {
     Vue.prototype.$config = this.get
  },

  get (key, defaultValue=null) {
    const val = store.getters['config/getConfig'](key)

    if (val == null) {
      return defaultValue
    }

    return val
  }
}
