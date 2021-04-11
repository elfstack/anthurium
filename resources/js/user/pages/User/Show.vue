<template>
  <div>
    <h1 class="h2">{{ user.name }}</h1>
    <a-card :tab-list="tabList">
      <router-view/>
    </a-card>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import store from "../../store"

  // FIXME: this is a workaround for not getting current logged in user before enter
  const isSameUser = async (id) => {
    if (!store.getters['user/loaded']) {
      await store.dispatch('user/getUser')
    }

    return id === store.getters['user/user'].id
  }

  export default {
    name: "Show",
    metaInfo() {
      return {
        title: this.user.name
      }
    },
    data() {
      return {
        user: {},
        tabList: [
          {
            key: 'profile',
            tab: 'Profile'
          }
        ]
      }
    },
    beforeRouteEnter(to, from, next) {
      if (isSameUser(to.params.id)) {
        next(vm => vm.setUser(store.getters['user/user']))
      }
    },
    beforeRouteUpdate(to, from, next) {
      this.user = null
      if (isSameUser(to.params.id)) {
        this.setUser(this.$store.getters['user/user'])
        next()
      }
    },
    methods: {
      setUser(user) {
        this.user = user
      }
    }
  }
</script>

<style scoped>

</style>
