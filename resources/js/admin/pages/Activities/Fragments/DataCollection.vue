<template>
  <div class="p2">
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card>
          <activity-data-collection-form :activity="activity"/>
        </a-card>
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
              <a-tag>{{ record.meta.stage }}</a-tag>
            </span>

            <span slot="available_to" slot-scope="text, record">
              {{ text | moment('LLL') }}
            </span>

            <span slot="action" slot-scope="text, record">
              <router-link :to="{ name: 'admin.data-collection.show', params: { id: record.id }}">View</router-link>
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
  import dataCollection from "../../../../api/admin/dataCollection";
  import ActivityDataCollectionForm from './ActivityDataCollectionForm'
  import { mapState } from 'vuex'

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
        api: (paramBag) => {
          paramBag.filters.activity_id = [this.activity.id]
          return dataCollection.index(paramBag)
        },
        columns: [
          {dataIndex: 'stage', title: 'Stage', scopedSlots: {customRender: 'stage'}},
          {dataIndex: 'form.title', title: 'Form'},
          {dataIndex: 'available_to', title: 'Available To', scopedSlots: {customRender: 'available_to'}},
          {dataIndex: 'response_count', title: 'Responses'},
          {dataIndex: 'action', title: 'Action', scopedSlots: {customRender: 'action'}}
        ]
      }
    },
    mounted () {
      this.loadData()
    },
    computed: {
      ...mapState({
        activity: state => state.activity.activity
      }),
    }
  }
</script>

<style scoped>

</style>
