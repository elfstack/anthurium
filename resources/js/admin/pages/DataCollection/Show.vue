<template>
  <div>
    <a-page-header title='Data Collection' @back="$router.go(-1)" style="background: #fff">
      <template slot="extra">
        <router-link :to="{ name: 'admin.forms.show.questions', params: { id: $route.params.id } }">
          <a-button disabled v-if="dataCollection.is_archived">Archived</a-button>
          <template v-else>
            <a-button icon="upload" type="primary" v-if="dataCollection.is_closed">Reopen</a-button>
            <a-button icon="issues-close" type="danger" v-else>Close</a-button>
            <a-button icon="download">Archive</a-button>
          </template>
        </router-link>
      </template>

      <template slot="tags">
        <a-tag color="blue">
          Running
        </a-tag>
      </template>

     <a-descriptions size="small" :column="2">
        <a-descriptions-item label="Flags">
          <a-tag v-if="dataCollection.is_re_submittable">Allow Resubmit</a-tag>
        </a-descriptions-item>
        <a-descriptions-item label="Effective at">
          2017-10-10 - 2027-01-01
        </a-descriptions-item>
      </a-descriptions>

      <a-card
        :loading="isLoading">
        <a-card-meta :title="dataCollection.form.title">
          <template slot="description">
            {{ dataCollection.form.description }}
          </template>
        </a-card-meta>
      </a-card>
    </a-page-header>

    <div class="p2">
    <a-row :gutter="[16, 16]">
      <a-col>
        <h3>Responses</h3>
        <a-card class="card-dense">
          <a-table
            :columns="columns"
            @change="handleChange"
            :pagination="listing.pagination"
            :loading="loading"
            row-key="id"
            :data-source="data">
              <span slot="user" slot-scope="text, record">
                {{ record.user.name }}
              </span>
              <span slot="submitted-at" slot-scope="text, record">
                {{ record.created_at | moment('LLL') }}
              </span>
              <span slot="action" slot-scope="text,record">
                <router-link
                  :to="{ name: 'admin.forms.show.answers', params: { id: $route.params.id, answersId: record.id }}">View</router-link>
              </span>
          </a-table>
        </a-card>
      </a-col>
    </a-row>
    </div>
  </div>
</template>

<script>
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
        api: (paramBag) => dataCollection.indexResponses(this.$route.params.id, paramBag),
        isLoading: true,
        columns: [
          {
            dataIndex: 'id',
            key: 'id',
            title: 'ID',
            sorter: true
          },
          {
            key: 'user.name',
            title: 'User',
            scopedSlots: { customRender: 'user'}
          },
          {
            dataIndex: 'created_at',
            key: 'created_at',
            title: 'Submitted At',
            scopedSlots: { customRender: 'submitted-at'}
          },
          {
            dataIndex: 'action',
            key: 'action',
            title: 'Action',
            scopedSlots: {customRender: 'action'}
          }
        ],
        dataCollection: {
          form: {}
        }
      }
    },
    methods: {
      async loadForm (id) {
        dataCollection.show(id).then(({data}) => {
          this.dataCollection = data.data_collection
          this.isLoading = false
        }).catch(error => {
          if (error.response.status === 404) {
            this.$router.replace({name: '404'})
          }
        })
      },
    }
  }
</script>

<style scoped>

</style>
