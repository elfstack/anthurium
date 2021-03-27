<template>
  <div>
    <a-card :title="notification.title" :loading="isLoading">
      {{ notification.description }}
    </a-card>
  </div>
</template>

<script>
  import notification from "../../api/user/notification";

  export default {
    name: "Message",
    data () {
      return {
        notification: {},
        isLoading: true
      }
    },
    watch: {
      '$route.params.id': 'loadData'
    },
    mounted() {
     this.loadData(this.$route.params.id)
    },
    metaInfo () {
      return {
        title: this.notification.title ?? 'loading...'
      }
    },
    methods: {
      loadData (id) {
        this.isLoading = true
        notification.show(id).then(({data}) => {
          this.notification = data.notification
          this.isLoading = false
        })
      }
    }

  }
</script>

<style scoped>

</style>
