<template>
  <a-form-model v-model="data" :wrapper-col="wrapperCol" :label-col="labelCol">
    <a-form-model-item label="Stage" prop="data.stage" style="width: 100%">
      <a-select :options="dataCollectionStageOptions" v-model="data.stage" />
    </a-form-model-item>

    <a-form-model-item label="Form" prop="data.form" placeholder="Stage">
      <form-selector v-model="data.form" />
    </a-form-model-item>

    <a-form-model-item :wrapper-col="btnWrapperCol">
      <a-button type="primary" @click="toDataCollectionCreate">Create</a-button>
    </a-form-model-item>
  </a-form-model>
</template>

<script>
  import form from "../../../../common/mixins/form"
  import FormSelector from '../../../components/FormSelector'

  export default {
    name: "ActivityDataCollectionForm",
    mixins: [form],
    props: {
      activity: {
        required: false,
        type: Object
      }
    },
    components: {
      'form-selector': FormSelector
    },
    data() {
      return {
        data: {
          form: null,
          stage: null
        },
        dataCollectionStageOptions: [
          { value: 'enroll', label: 'Enroll' },
          { value: 'admitted', label: 'Admitted' },
          { value: 'arrived', label: 'Arrived' },
          { value: 'before-leave', label: 'Before Leave' },
          { value: 'left', label: 'Left' }
        ]
      }
    },
    methods: {
      toDataCollectionCreate () {
        this.$router.push({
          name: 'admin.data-collection.create',
          query: {
            form_id: this.data.form.id,
            activity_id: this.activity.id,
            stage: this.data.stage,
            redirect: this.$route.path
          }
        })
      }
    }
    }
</script>

<style scoped>

</style>
