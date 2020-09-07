<template>
  <div class="p-3">
    <template v-if="answer">
      <a-row
        v-for="(question, idx) in form.questions"
        :key="question.id"
        :gutter="[16,16]"
      >
        <a-col>
          <question
            :question="question"
            :answer="answer.answers.find(isQuestionEquals(question.id))"/>
        </a-col>
      </a-row>
    </template>
    <a-card v-else>
      <a-empty></a-empty>
    </a-card>
  </div>
</template>

<script>
  import form from "../../../../api/admin/form"
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
        answer: null
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
        const registrationFormId = this.$getConfig('registration.form_id')
        const userId = this.$route.params.id
        form.questions(registrationFormId).then(({ data }) => {
          this.form = data
        })
        // TODO: get answers by form and user
        form.getAnswersByUserId(registrationFormId, userId).then(({ data }) => {
          this.answer = data.answer
        })
      }
    }
  }
</script>

<style scoped>

</style>
