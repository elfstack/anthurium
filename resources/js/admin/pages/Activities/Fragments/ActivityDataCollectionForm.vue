<template>
  <a-form-model :wrapper-col="wrapperCol" :label-col="labelCol" v-model="data">
    <a-form-model-item label="Stage" prop="data.stage">
      <a-select :options="dataCollectionStageOptions" v-model="data.stage" />
    </a-form-model-item>

    <a-form-model-item label="Form" prop="data.form">
      <form-selector v-model="data.form" />
    </a-form-model-item>

    <a-form-model-item :wrapper-col="btnWrapperCol">
      <a-button type="primary">Create</a-button>
    </a-form-model-item>
  </a-form-model>
</template>

<script>
  import form from "../../../../common/mixins/form"
  import FormSelector from '../../../components/FormSelector'

  export default {
    name: "ActivityDataCollectionForm",
    mixins: [form],
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
          { value: 'left', label: 'Left' }
        ]
      }
    }
    }
</script>

<style scoped>

</style>
