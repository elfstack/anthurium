<template>
  <a-table
    @change="handleChange"
    :pagination="listing.pagination"
    :loading="loading"
    :columns="columns"
    row-key="id"
    :data-source="data">

          <span slot="action" slot-scope="text,record">
              <router-link
                :to="{ name: 'admin.data-collection.create', query: { form_id: record.id }}">Use</router-link>
              <a-divider type="vertical"/>
              <router-link
                :to="{ name: 'admin.forms.show', params: { id: record.id }}">View</router-link>
          </span>

  </a-table>
</template>

<script>
  import form from "../../../api/admin/form";
  import listing from "../../../common/mixins/listing";

  export default {
    name: "FormIndex",
    mixins: [listing],
    data() {
      return {
        api: form.index,
        columns: [
          {
            dataIndex: 'title',
            title: 'Title'
          },
          {
            dataIndex: 'updated_at',
            title: 'Updated At',
            customRender: (text) => this.$moment(text).format('LLL')
          },
          {
            dataIndex: 'action',
            title: 'Action',
            scopedSlots: {customRender: 'action'}
          },
        ]
      }
    }
  }
</script>

<style scoped>

</style>
