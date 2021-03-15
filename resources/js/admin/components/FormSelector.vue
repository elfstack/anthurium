<template>
  <div class="form-selector">
    <a-input
      :value="selectedRecord.title"
      @click="toggleModal"
      @input="toggleModal"
      :placeholder="placeholder"
    />
    <a-modal
      :visible="displayModal"
      title="Select Form"
      @close="toggleModal"
      :footer="null"
    >
      <div style="padding: 12px">
        <a-input-search placeholder="Search Form" @search="handleSearch" />
      </div>
      <a-table
        @change="handleChange"
        :pagination="listing.pagination"
        :loading="loading"
        :columns="columns"
        row-key="id"
        :data-source="data">

          <span slot="action" slot-scope="text,record">
            <a @click="selectRecord(record)">Select</a>
          </span>

      </a-table>
    </a-modal>
  </div>
</template>

<script>
  import listing from "../../common/mixins/listing";
  import form from "../../api/admin/form";

  export default {
    name: "FormSelector",
    mixins: [listing],
    props: {
      value: {
        type: Object
      },
      placeholder: {
        type: String,
        default: 'Please choose a form'
      }
    },
    data() {
      return {
        displayModal: false,
        selectedRecord: null,
        api: form.index,
        columns: [
          {
            dataIndex: 'title',
            title: 'Title'
          },
          {
            dataIndex: 'updated_at',
            title: 'Updated At',
            customRender: (text) => this.$moment(text).format('LLL')
          },
          {
            dataIndex: 'action',
            title: 'Action',
            scopedSlots: {customRender: 'action'}
          },
        ]
      }
    },
    created () {
      this.modifyListingOptions()
    },
    mounted () {
      this.copyValue()
    },
    methods: {
      copyValue () {
        this.selectedRecord = Object.assign({}, this.value)
      },
      modifyListingOptions () {
        this.listing.pagination.size = 'small'
        this.listing.pagination.pageSize = 5
        this.listing.pagination.pageSizeOptions = ['5', '10']
        this.autoload = false
      },
      toggleModal () {
        this.displayModal = !this.displayModal
        if (this.displayModal) {
          this.fetchData()
        }
      },
      selectRecord (record) {
        this.selectedRecord = record
        this.$emit('input', record)
        this.toggleModal()
      }
    }
  }
</script>

<style scoped>
>>> .ant-modal-body {
  padding: 0;
}
</style>
