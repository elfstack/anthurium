<template>
  <a-form-model :label-col="labelCol" :colon="false" label-align="left">
    <a-form-model-item :label="option.column" v-for="(option, key) in opt" :key="key">
      <a-tag>All</a-tag>
      <a-tag v-for="tag in option.tags" :key="tag.value">
        {{ tag.label }}
      </a-tag>
    </a-form-model-item>
  </a-form-model>
</template>

<script>
  export default {
    name: "TagFilter",
    props: {
      options: {
        required: false,
        type: Object
      }
    },
    data() {
      return {
        labelCol: { sm: {
          span: 6,
          },
          md: {
          span: 4
          },
          lg: {
          span: 2
          }
        },
        opt: [
          {
            column: 'Category',
            tags: [
              {
                label: 'Test',
                value: 1
              },
              {
                label: 'Test2',
                value: 2
              }
            ]
          }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
