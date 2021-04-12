export default {
  data () {
    return {
      selection: {
        selectedKeys: []
      },
      selectionConfig: {
        key: 'id',
        dataSource: 'data',
        pageSize: 10,
        totalItems: 10
      }
    }
  },
  computed: {
    isIndeterminate () {
      return this.selection.selectedKeys.length > 0 && this.selection.selectedKeys.length < this.selectionConfig.pageSize && this.selection.selectedKeys.length !== this.selectionConfig.totalItems
    },
    isAllChecked () {
      return this.selection.selectedKeys.length === this.selectionConfig.pageSize || this.selection.selectedKeys.length === this.selectionConfig.totalItems
    }
  },
  methods: {
    $toggleCheckAll(e) {
      if (e.target.checked) {
        this.selection.selectedKeys = this[this.selectionConfig.dataSource].map(item => item[this.selectionConfig.key])
      } else {
        this.$clearSelection()
      }
    },
    _findIndex (key) {
      return item => item === key
    },
    $isChecked (key) {
      return this.selection.selectedKeys.findIndex(this._findIndex(key)) !== -1
    },
    $toggleCheck (key) {
      const index = this.selection.selectedKeys.findIndex(this._findIndex(key))
      if (index !== -1) {
        this.selection.selectedKeys.splice(index, 1)
      } else {
        this.selection.selectedKeys.push(key)
      }
    },
    $clearSelection () {
      this.selection.selectedKeys = []
    }
  }
}
