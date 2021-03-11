<template>
  <a-card :title="`Question ${question.sequence}`">
    <template v-if="!isQuestionEditing">
      <p>{{ question.question }}</p>
      <template v-if="question.type === 'checkbox' || question.type === 'radio'">
        <component :is="`a-${question.type}`" v-for="option in question.options">{{ option.value }}</component>
      </template>
    </template>

    <template v-if="!isAnswerEditing && question.type.substring(0, 4) === 'text'">
      Answer: {{ answer }}
    </template>

    <template v-else>
      <!-- editing text/textarea -->
    </template>
  </a-card>
</template>

<script>
  export default {
    name: 'Question',
    props: {
      question: {
        // can be synced
        required: true,
        type: Object
      },
      answer: {
        // can be synced
        required: true,
        type: [ String, Number ]
      },
      isAnswerEditing: {
        default: false,
        type: Boolean
      }
    },
    mounted () {
      this.setAnswer()
    },
    methods: {
      setAnswer () {
        if (this.question.type === 'checkbox' || this.question.type === 'radio') {
          // TODO
        }

        if (this.question.response) {
          this.answer = this.question.response.answer
        }
      }
    }
  }
</script>

<style scoped>

</style>
