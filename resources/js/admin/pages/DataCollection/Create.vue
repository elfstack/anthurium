<template>
    <div>
      <a-page-header title="Start Data Collection"></a-page-header>
      <div class="p2">
        <a-row :gutter="[16,16]">
          <a-col>
            <a-card
              :loading="isFormLoading">
              <a-card-meta :title="form.title">
                <template slot="description">
                  {{ form.description }}
                </template>
              </a-card-meta>
            </a-card>
          </a-col>
        </a-row>
        <a-row :gutter="[16,16]">
          <a-col>
            <a-card>
              <a-form-model :model="dataCollection"
                            ref="form"
                            :wrapper-col="wrapperCol"
                            :label-col="labelCol">
                <a-form-model-item prop="purpose" label="Purpose">
                  <a-input v-model="dataCollection.purpose" />
                </a-form-model-item>

                <a-form-model-item prop="available_to" label="Available To">
                  <a-date-picker
                    show-time
                    placeholder="Select Time"
                    @ok="updateAvailableTo"/>
                </a-form-model-item>

                <a-form-model-item prop="is_re_submittable" :wrapper-col="btnWrapperCol">
                  <a-checkbox v-model="dataCollection.is_re_submittable">
                    Allow Re-submit
                  </a-checkbox>
                </a-form-model-item>

                <a-form-model-item :wrapper-col="btnWrapperCol">
                  <a-button type="primary" @click="createDataCollection">Create</a-button>
                </a-form-model-item>
              </a-form-model>
            </a-card>
          </a-col>
        </a-row>
      </div>
    </div>
</template>

<script>
  import form from "../../../api/admin/form";
  import dataCollection from "../../../api/admin/dataCollection";

  import formMixin from "../../../common/mixins/form";

  export default {
    name: "Create",
    mixins: [formMixin],
    metaInfo: {
      title: 'Start Data Collection'
    },
    data () {
      return {
        isFormLoading: true,
        form: {},
        dataCollection: {}
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
       vm.setParameters(to.query)
      })
    },
    beforeRouteUpdate (to, from, next) {
      this.setParameters(to.query)
      next()
    },
    methods: {
      setParameters(query) {
        this.getFormData(query.form_id).then(this.assignFormId).then(() => {
          if (query.activity_id && query.stage) {
            this.dataCollection.purpose = `Activity:${query.activity_id}/${query.stage}`
            this.dataCollection.meta = {
              stage: query.stage
            }
            this.dataCollection.activity_id = Number.parseInt(query.activity_id)
          }
        })
      },
      getFormData (formId) {
        this.form = {}
        this.isFormLoading = true
        return form.show(formId).then(({data}) => {
          this.form = data.form
          this.isFormLoading = false
        })
      },
      createDataCollection () {
        this.$submit('form', dataCollection.create, this.dataCollection).then(({data}) => {
          this.$router.replace({name: 'admin.data-collection.show', params: { id: data.data_collection.id }})
        })
      },
      assignFormId () {
        this.dataCollection.form_id = this.form.id
      },
      updateAvailableTo (value) {
        console.log(value)
        this.dataCollection.available_to = value
      }
    }
  }
</script>

<style scoped>

</style>
