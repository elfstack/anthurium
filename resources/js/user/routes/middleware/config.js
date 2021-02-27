import store from "../../store"

export default async function loadConfigs (to, from, next) {
  await store.dispatch('config/loadConfigs')
}
