<template>
  <a-select
    @dropdownVisibleChange="lazyLoadOptions"
    @change="onSelectOptionChanged"
    :value="selectedId"
    :loading="loading"
  >
    <a-select-option
      v-for="option in mappedOptions"
      :key="option.id"
      :value="option.id"
    >
      {{ option.name }}
    </a-select-option>
  </a-select>
</template>

<script>
  export default {
    name: "AsyncSelect",
    props: {
      api: {
        required: true,
        type: Function
      },
      value: {
        required: false,
        type: Object
      },
      optionMapper: {
        required: false,
        type: Function,
        default: (item) => ({ id: item.id, name: item.name })
      },
      itemKey: {
        required: false,
        default: 'id'
      }
    },
    data () {
      return {
        selectedId: null,
        options: [],
        loading: false,
        loaded: false
      }
    },
    created () {
      this.selectedId = this.value.id
      this.options.push(this.value)
    },
    computed: {
      mappedOptions () {
        return this.options.map(this.optionMapper)
      }
    },
    methods: {
      onSelectOptionChanged (value) {
        this.selectedId = value
        this.$emit('input', this.options.find(item => item[this.itemKey] === value ))
      },
      lazyLoadOptions () {
        if (this.loaded) return

        this.loading = true
        this.api().then((options) => {
          this.options = options
          this.loading = false
          this.loaded = true
        })
      }
    }
  }
</script>

<style scoped>

</style>
