<template>
  <a-layout>
    <a-page-header @back="$router.go(-1)" :title="userGroup.name"/>
    <div class="p2">
      <a-row :gutter="[16,16]">
        <a-col>
          <a-card>
            <a-statistic title="Members" :value="userGroup.users_count" />
          </a-card>
        </a-col>
      </a-row>
      <a-row :gutter="[16,16]">
        <a-col>
          <a-card title="Members">
            <members :user-group-id="userGroup.id" v-if="userGroup.id"/>
          </a-card>
        </a-col>
      </a-row>
    </div>
  </a-layout>
</template>

<script>
  import userGroup from "../../../api/admin/userGroup";
  import Members from "./Fragments/Members"

  export default {
    name: "Show",
    components: {
      'members': Members
    },
    beforeRouteEnter (to, from, next) {
      userGroup.show(to.params.id).then(({data}) => {
        next(vm => vm.userGroup = data.user_group)
      })
    },
    beforeRouteUpdate (to, from, next) {
      this.userGroup = {}
      userGroup.show(to.params.id).then(({data}) => {
        this.userGroup = data.user_group
        next()
      })
    },
    data() {
      return {
        userGroup: {}
      }
    }
  }
</script>

<style scoped>

</style>
