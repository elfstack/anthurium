<template>
  <a-modal
    :title="action.type"
    @cancel="handleCancel"
    centered
    :visible="visible"
  >
    <a-list-item style="padding: 0">
      <a-list-item-meta
        :description="action.user.email"
      >
        <a slot="title" href="https://www.antdv.com/">{{ action.user.name }}</a>
        <a-avatar
          slot="avatar"
          src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
        />
      </a-list-item-meta>
    </a-list-item>
    <a-divider  orientation="left">Form Response</a-divider>
    <data-collection-response :data="action.data_collection_response" />
    <template #footer>
      <a-button type="danger" icon="close" @click="updateActionResult('rejected')">
        Reject
      </a-button>

      <a-button type="primary" icon="check" @click="updateActionResult('approved')">
        Approve
      </a-button>
    </template>
  </a-modal>
</template>

<script>
  import action from "../../api/admin/action";

  import DataCollectionResponse from './DataCollectionResponse';

  export default {
    name: "ActionModel",
    props: {
      id: {
        type: Number,
        required: true
      }
    },
    components: {
      DataCollectionResponse
    },
    data() {
      return {
        visible: true,
        action: {
          type: 'loading',
          user: {}
        }
      }
    },
    mounted () {
      action.show(this.id).then(({data}) => {
        this.action = data.action
      })
    },
    methods: {
      handleClose() {
        this.id = null
      },
      updateActionResult(result) {
        action.update(this.action.id, result).then(({data}) => {
          this.$message.success('Action resolved');
          this.handleClose()
        })
      }
    }
  }
</script>

<style scoped>

</style>
