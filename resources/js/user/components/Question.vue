<template>
  <a-card>
    <p :class="{ 'ant-form-item-required': question.is_required }">{{ question.question }}</p>
    <a-form-model-item ref="form-item">
      <template v-if="question.type === 'checkbox' || question.type === 'radio'">
        <component :is="`a-${question.type}-group`" v-model="response">
          <component :is="`a-${question.type}`"
                     v-for="option in question.options"
                     :value="option.id"
                     :disabled="disabled"
          >
            {{ option.value }}
          </component>
        </component>
      </template>
      <template v-else>
        <a-input :type="question.type"
                 :placeholder="question.type === 'text' ? 'Short question input' : 'Long question input'"
                 v-model="response"
                 @input="clearError"
                 :disabled="disabled"
        ></a-input>
      </template>
    </a-form-model-item>
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
      isEditing: {
        default: false,
        type: Boolean
      },
      disabled: {
        default: false,
        type: Boolean
      }
    },
    data() {
      return {
        response: null
      }
    },
    mounted() {
      if (this.question.response) {
        this.$setAnswer(this.question.response.answer)
      }
    },
    methods: {
      clearError () {
        const field = this.$refs['form-item']
        field.validateState = ''
        field.validateMessage = null
      },
      $setAnswer(answer) {
        if (this.question.type === 'radio' || this.question.type === 'checkbox') {
          this.response = Number.parseInt(answer)
        } else {
          this.response = answer
        }
      },
      $getQuestionId() {
        return this.question.id
      },
      $collectAnswer() {
        if (this.question.is_required && this.response === null){
          const field = this.$refs['form-item']
          field.validateState = 'error'
          field.validateMessage = 'This field is required'
          throw new Error('Field is required')
        }

        return {
          form_question_id: this.question.id,
          answer: this.response
        }
      }
    }
  }
</script>

<style scoped>
</style>
