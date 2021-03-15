<template>
  <a-list
    :data-source="data"
    :loading="loading"
    :pagination="listing.pagination">
    <a-list-item slot="renderItem" slot-scope="item, index">
      <a-list-item-meta>
        <router-link slot="title" to="/">{{ item.user.name }}</router-link>
        <template #description>{{ item.created_at | moment('from') }}</template>
      </a-list-item-meta>
    </a-list-item>
  </a-list>
</template>

<script>
  import listing from "../../../../common/mixins/listing";
  import action from "../../../../api/admin/action";

  export default {
    name: "Application",
    mixins: [listing],
    data () {
      return {
        api: (pagination) => action.index(pagination, {
          pending: true
        })
      }
    }
  }

</script>

<style scoped>

</style>
