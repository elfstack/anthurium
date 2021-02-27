<template>
  <a-form-model>
  <a-form-model-item :label="question.question" :colon="false" v-for="question in data.response">
    <template v-if="question.type === 'checkbox' || question.type === 'radio'">
      <component
        :is="`a-${question.type}-group`"
        v-model:value="answerForm">
        <component :is="`a-${question.type}`" v-for="option in question.options" :value="option.id">
          {{ option.value }}
        </component>
      </component>
    </template>

    Answer: {{ question.response.answer }}
  </a-form-model-item>
  </a-form-model>
</template>

<script>
    export default {
      name: "DataCollectionResponse",
      props: {
        data: {
          type: Object,
          required: true
        }
      }
    }
</script>

<style scoped>

</style>
