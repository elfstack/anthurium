<template>
  <div>
    <a-page-header title='Response' @back="$router.go(-1)" style="background: #fff">
    </a-page-header>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card class="card-dense">
          <a-list-item>
            <a-list-item-meta
              :description="data.user.email"
            >
              <a slot="title">{{ data.user.name }}</a>
            </a-list-item-meta>
          </a-list-item>
        </a-card>
      </a-col>
    </a-row>
    <h3>Response</h3>
    <a-row :gutter="[16,16]" v-for="question in data.response" :key="question.id">
      <a-col>
        <a-card>
          <p :class="{ 'ant-form-item-required': question.is_required }">{{ question.question }}</p>
          <a-form-model-item ref="form-item">
            <template v-if="question.type === 'checkbox' || question.type === 'radio'">
              <component :is="`a-${question.type}-group`" :value="Number.parseInt(question.response.answer)">
                <component :is="`a-${question.type}`"
                           v-for="option in question.options"
                           :value="option.id"
                           :disabled="disabled"
                           @click="null"
                >
                  {{ option.value }}
                </component>
              </component>
            </template>
            <template v-else>
              <a-input :type="question.type"
                       :placeholder="question.type === 'text' ? 'Short question input' : 'Long question input'"
                       :value="question.response.answer"
                       readonly
              ></a-input>
            </template>
          </a-form-model-item>
        </a-card>
      </a-col>
    </a-row>
  </div>
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
