<template>
  <a-descriptions title="User Info" :column="1">
    <a-descriptions-item label="Username">
      {{ user.name }}
    </a-descriptions-item>

    <a-descriptions-item label="User Group">
      <a-tag>{{ user.user_group.name }}</a-tag>
    </a-descriptions-item>

    <a-descriptions-item label="Registered At">
      {{ user.created_at | moment('LL') }}
    </a-descriptions-item>
  </a-descriptions>
</template>

<script>
  import user from "../../../api/user/user"

  export default {
    name: "Profile",
    beforeRouteEnter(to, from, next) {
      user.show(to.params.id).then(({data}) => {
        next(vm => vm.user = data.user)
      })
    },
    beforeRouteUpdate(to, from, next) {
      this.user = null
      user.show(to.params.id).then(({data}) => {
        this.user = data.user
        next()
      })
    },
    data() {
      return {
        user: null
      }
    }
  }
</script>

<style scoped>

</style>
