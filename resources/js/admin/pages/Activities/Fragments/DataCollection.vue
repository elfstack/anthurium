<template>
  <div class="p2">
    <a-row :gutter="[16,16]">
      <a-col>
        <activity-data-collection-form />
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card class="card-dense">
          <a-table
            @change="handleChange"
            :pagination="listing.pagination"
            :loading="loading"
            :columns="columns"
            row-key="id"
            :data-source="data">
            <span slot="stage" slot-scope="text, record">
              <a-tag>{{ text }}</a-tag>
            </span>
          </a-table>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>
  import listing from "../../../../common/mixins/listing"

  import activity from "../../../../api/admin/activity"

  import ActivityDataCollectionForm from './ActivityDataCollectionForm'

  export default {
    name: "DataCollection",
    mixins: [listing],
    components: {
      'activity-data-collection-form': ActivityDataCollectionForm
    },
    data() {
      return {
        data: {
          form: null,
          stage: null
        },
        api: activity.dataCollection,
        columns: [
          {dataIndex: 'stage', title: 'Stage', scopedSlots: {customRender: 'stage'}},
          {dataIndex: 'form.title', title: 'Form'},
          {dataIndex: 'response.collected_response_count', title: 'Collected Response'},
          {dataIndex: 'action', title: 'Action'}
        ]
      }
    }
  }
</script>

<style scoped>

</style>
