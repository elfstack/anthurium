<template>
  <div class="p2">
    <a-card v-for="answer in answer.answers">
      <template #title>
        {{ answer.question.sequence }}. {{ answer.question.question }}
      </template>
      Answer: {{ answer.answer }}
    </a-card>
  </div>
</template>

<script>
  import form from "../../../api/admin/form";
  export default {
    name: "Answers",
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
        answer: {
          answers: []
        }
      }
    },
    methods: {
      loadData (formId, answersId) {
        this.answers = []
        form.showAnswers(formId, answersId).then(({ data }) => {
          this.answer = data.answer
        })
      }
    }
  }
</script>

<style scoped>

</style>
