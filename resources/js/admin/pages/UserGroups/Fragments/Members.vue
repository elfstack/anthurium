<template>
  <a-table
    @change="handleChange"
    :pagination="listing.pagination"
    :loading="loading"
    :columns="columns"
    row-key="id"
    style="margin: -24px"
    :data-source="data">

    <span slot="action" slot-scope="text,record">
      <router-link :to="{ name: 'admin.members.show.account', params: { id: record.id }}">Details</router-link>
    </span>
  </a-table>
</template>

<script>
  import listing from "../../../../common/mixins/listing";
  import user from "../../../../api/admin/user";

  export default {
    name: "Members",
    mixins: [listing],
    props: {
      userGroupId: {
        required: true,
        type: Number
      }
    },
    data() {
      return {
        api: (paramBag) => {
          paramBag.filters.user_group_id = [this.userGroupId]
          return user.index(paramBag)
        },
        columns: [
          {
            dataIndex: 'id',
            key: 'id',
            title: 'ID',
            sorter: true
          },
          {
            dataIndex: 'name',
            key: 'name',
            title: 'Name'
          },
          {
            dataIndex: 'email',
            title: 'Email'
          }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
