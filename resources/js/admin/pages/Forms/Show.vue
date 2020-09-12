<template>
  <div>
    <a-page-header title='Form' :sub-title="form.title" @back="$router.go(-1)" style="background: #fff">
      <template slot="extra">
        <router-link :to="{ name: 'admin.forms.show.questions', params: { id: $route.params.id } }">
          <a-button type="primary">Edit Questions</a-button>
        </router-link>
      </template>
    </a-page-header>

    <div class="p2">
    <a-row :gutter="[16, 16]">
      <a-col>
        <a-card
          title="Description"
          :loading="isLoading">
          {{ form.description }}
        </a-card>
      </a-col>
      <a-col>
        <a-card title="Answers">
          <a-table
            @change="handleChange"
            :pagination="listing.pagination"
            :loading="loading"
            :columns="columns"
            row-key="id"
            :data-source="data">
              <span slot="answerer" slot-scope="text, record">
                {{ record.answerer.name }}
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
  import form from "../../../api/admin/form"
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
        api: (paramBag) => form.indexAnswers(this.$route.params.id, paramBag),
        isLoading: true,
        columns: [
          {
            dataIndex: 'id',
            key: 'id',
            title: 'ID',
            sorter: true
          },
          {
            dataIndex: 'answerer',
            key: 'answerer',
            title: 'Answerer',
            scopedSlots: { customRender: 'answerer'}
          },
          {
            dataIndex: 'created_at',
            key: 'created_at',
            title: 'Submitted At'
          },
          {
            dataIndex: 'action',
            key: 'action',
            title: 'Action',
            scopedSlots: {customRender: 'action'}
          }
        ],
        form: { }
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
    }
  }
</script>

<style scoped>

</style>
