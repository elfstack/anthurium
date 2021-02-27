<template>
  <a-form-model-item :label="question.question" :colon="false">
    <template v-if="question.type === 'checkbox' || question.type === 'radio'">
      <component
        :is="`a-${question.type}-group`"
        v-model:value="answerForm">
        <component :is="`a-${question.type}`" v-for="option in question.options" :value="option.id" :key="option.id">
          {{ option.value }}
        </component>
      </component>
    </template>

    <template v-if="question.type.substring(0, 4) === 'text'">
      <template v-if="!isEditing">
        Answer: {{ answer.answer }}
      </template>

      <template v-else>
        <component :is="`a-${question.type === 'text' ? 'input' : 'textarea'}`" v-model="answerForm"></component>
      </template>
    </template>
  </a-form-model-item>
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
        type: [ String, Number ]
      },
      isEditing: {
        default: false,
        type: Boolean
      }
    },
    data () {
      return {
        options: [],
        answerForm: ''
      }
    },
    mounted() {
      if (this.question.response) {
        this.answerForm = this.question.response.answer
      }
    },
    methods: {
      $setAnswer (answer) {
        this.answerForm = answer
      },
      $getQuestionId () {
        return this.question.id
      },
      $collectAnswer () {
        return {
          form_question_id: this.question.id,
          answer: this.answerForm
        }
      }
    }
  }
</script>

<style scoped>
</style>
