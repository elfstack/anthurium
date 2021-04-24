<template>
  <div>
    <h1 class="h2">{{ dataCollection.form.title }}</h1>
    <a-row :gutter="[16,16]" v-if="isSubmitted">
      <a-col>
        <a-alert type="success" message="Thank you for your response" v-if="isSubmitted"></a-alert>
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card style="white-space: pre-line">{{ dataCollection.form.description }}
        </a-card>
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]" v-for="question in dataCollection.form.questions" :key="question.id">
      <a-col>
        <question :question="question" ref="question" :disabled="!dataCollection.is_re_submittable"/>
      </a-col>
    </a-row>

    <a-row :gutter="[16,16]">
      <a-col>
        <a-button type="primary" @click="collectAnswer" :loading="isSubmitting" :disabled="isSubmitted && !dataCollection.is_re_submittable">Submit</a-button>
      </a-col>
    </a-row>

  </div>
</template>

<script>
  import dataCollection from "../../../api/user/dataCollection";
  import Question from "../../components/Question";

  export default {
    name: "Form",
    components: {
      'question': Question
    },
    beforeRouteEnter(to, from, next) {
      if (to.params.responseId) {
        dataCollection.showResponse(to.params.responseId).then(({data}) => {
          next(vm => {
            vm.isSubmitted = true
            vm.setData(data.data_collection_response.data_collection)
          })
        })
      } else {
        dataCollection.show(to.params.id).then(({data}) => {
          next(vm => {
            let hasResponse = data.hasOwnProperty('data_collection_response')
            vm.isSubmitted = hasResponse
            vm.setData(hasResponse ? data.data_collection_response.data_collection : data.data_collection)
          })
        })
      }
    },
    beforeRouteUpdate(to, from, next) {
      if (to.params.responseId) {
        dataCollection.showResponse(to.params.responseId).then(({data}) => {
          this.isSubmitted = true
          this.setData(data.data_collection_response.data_collection)
          next()
        })
      } else {
        this.dataCollection = null
        dataCollection.show(to.params.id).then(({data}) => {
          let hasResponse = data.hasOwnProperty('data_collection_response')
          this.isSubmitted = hasResponse
          this.setData(hasResponse ? data.data_collection_response.data_collection : data.data_collection)
          next()
        })
      }
    },
    data() {
      return {
        dataCollection: null,
        isSubmitting: false,
        isSubmitted: false
      }
    },
    methods: {
      setData(dataCollection) {
        this.dataCollection = dataCollection
      },
      collectAnswer() {
        let hasError = false

        this.response = this.$refs['question'].map(function (question) {
          try {
            return question.$collectAnswer()
          } catch (e) {
            hasError = true
          }
        })

        if (hasError) return

        this.isSubmitting = true
        dataCollection.saveResponse(this.dataCollection.id, {
          response: this.response
        }).then(({data}) => {
          this.isSubmitting = false
          this.isSubmitted = true
          this.$message.success('Thank you for response!')
        })
      },
    }
  }
</script>

<style scoped>

</style>
