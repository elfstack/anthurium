<template>
  <div>
    <a-page-header :title="form.title" @back="$router.go(-1)" style="background: #fff">
      <template slot="footer">
        <a-tabs default-active-key="show.data-collection" @change="changeTab">
          <a-tab-pane key="show" tab="Questions"/>
          <a-tab-pane key="show.data-collection" tab="Data Collection" />
        </a-tabs>
      </template>
    </a-page-header>

    <div class="p2">
    <a-row :gutter="[16, 16]">
      <a-col>
        <a-card class="card-dense">
          <a-table
            @change="handleChange"
            :pagination="listing.pagination"
            :loading="loading"
            :columns="columns"
            row-key="id"
            :data-source="data">
            <span slot="status" slot-scope="text, record">
              <a-tag v-if="record.is_archived">Archived</a-tag>
              <a-tag v-else-if="record.is_closed" color="red">Closed</a-tag>
              <a-tag v-else color="green">Open</a-tag>
            </span>

            <span slot="purpose" slot-scope="text, record">
              <template v-if="record.activity_id">
                <a-tag color="blue">Activity</a-tag>
                <a-tag>{{ record.meta.stage }}</a-tag>
                {{ record.activity.name }}
              </template>
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
  </div>
</template>

<script>
  import form from "../../../api/admin/form"
  import dataCollection from "../../../api/admin/dataCollection";
  import listing from "../../../common/mixins/listing"

  export default {
    name: "Show",
    mixins: [ listing ],
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.loadForm(to.params.id)
      })
    },
    beforeRouteUpdate(to, from, next) {
      this.loadForm(to.params.id)
      next()
    },
    data () {
      return {
        isLoading: true,
        isEditing: false,
        autoload: true,
        form: { },
        api: (paramBag) => {
          paramBag.filters.form_id = [ this.$route.params.id ]
          return dataCollection.index(paramBag)
        },
        columns: [
          { title: 'Status', scopedSlots: {customRender: 'status'}},
          { title: 'Purpose', scopedSlots: {customRender: 'purpose' }},
          {dataIndex: 'available_to', title: 'Available To', scopedSlots: {customRender: 'available_to'}},
          {dataIndex: 'response_count', title: 'Responses'},
          {dataIndex: 'action', title: 'Action', scopedSlots: {customRender: 'action'}}
        ]
      }
    },
    methods: {
      async loadForm (id) {
        form.show(id).then(({data}) => {
          this.form = data.form
          this.isLoading = false
        }).catch(error => {
          if (error.response.status === 404) {
            this.$router.replace({name: '404'})
          }
        })
      },
      changeTab (key) {
        this.$router.push({ name: 'admin.forms.' + key })
      }
    }
  }
</script>

<style scoped>

</style>
