<template>
  <div class="p-3">
    <template v-if="response">
      <a-row
        v-for="(answer, idx) in response.response"
        :key="answer.id"
        :gutter="[16,16]"
      >
        <a-col>
          <question
            :question="answer" />
        </a-col>
      </a-row>
    </template>
    <a-card v-else>
      <a-empty></a-empty>
    </a-card>
  </div>
</template>

<script>
  import dataCollection from "../../../../api/admin/dataCollection";
  import Question from '../../../components/Question'

  // TODO: get answers
  export default {
    name: "Information",
    components: {
      'question': Question
    },
    data () {
      return {
        form: null,
        response: null
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        vm.getForm()
      })
    },
    beforeRouteUpdate (to, from, next) {
      this.form = null
      this.getForm()
      next()
    },
    methods: {
      isQuestionEquals (questionId) {
        return (answer) => {
          return answer.form_question_id === questionId
        }
      },
      getForm () {
        const userId = this.$route.params.id
        // TODO: get answers by form and user
        dataCollection.showMemberFormAnswersByUserId(userId).then(({ data }) => {
          this.response = data.response
        })
      }
    }
  }
</script>

<style scoped>

</style>
