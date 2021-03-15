<template>
  <div class="p2">
    <data-collection-response :data="response"/>
  </div>
</template>

<script>
  import dataCollection from "../../../api/admin/dataCollection";
  import Question from '../../components/Question'

  import DataCollectionResponse from '../../components/DataCollectionResponse'

  export default {
    name: "Answers",
    components: {
      'question': Question,
      'data-collection-response': DataCollectionResponse
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        vm.loadData(to.params.id, to.params.answersId)
      })
    },
    beforeRouteUpdate (to, from, next) {
      this.loadData(to.params.id, to.params.answersId)
      next()
    },
    data () {
      return {
        response: {
          response: []
        }
      }
    },
    methods: {
      loadData (formId, responseId) {
        this.response = {
          response: []
        }
        dataCollection.showResponse(formId, responseId).then(({ data }) => {
          this.response = data.response
        })
      }
    }
  }
</script>

<style scoped>

</style>
