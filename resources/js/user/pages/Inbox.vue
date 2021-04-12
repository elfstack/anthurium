<template>
  <a-layout>
    <h1 class="h2">Inbox</h1>
    <a-row :gutter="[16,16]">
      <a-col :span="24">
        <a-card>
          <template #title>
            <a-row type="flex">
              <a-col flex="auto">
                <a-checkbox
                  style="margin-right: 10px"
                  :indeterminate="isIndeterminate"
                  :checked="isAllChecked"
                  @change="$toggleCheckAll"/>
                  <a-button v-show="isIndeterminate || isAllChecked" size="small" @click="markAsRead">Mark as read</a-button>
                  <a-button type="danger" v-show="isIndeterminate || isAllChecked" size="small" @click="deleteMessage">Delete</a-button>
              </a-col>
              <a-col>
              </a-col>
            </a-row>
          </template>
          <a-list
            style="margin-top: -24px"
            :data-source="data"
            :pagination="listing.pagination"
            :loading="loading">
            <a-list-item slot="renderItem" slot-scope="item, index">
              <a-checkbox
                style="margin-right: 10px"
                @change="$toggleCheck(item.id)"
                :checked="$isChecked(item.id)"
              />
              <a-list-item-meta
                :description="item.description">
                <router-link
                  slot="title"
                  :to="{ name: 'app.inbox.message', params: { id: item.id } }"
                  :style="isRead(item)"
                >
                  <a-badge color="blue" v-show="item.read_at === null"/>
                  {{ item.title }}
                </router-link>
              </a-list-item-meta>
              <div>{{ item.created_at | moment('from') }}</div>
            </a-list-item>
          </a-list>
        </a-card>
      </a-col>
    </a-row>
  </a-layout>
</template>

<script>
  import listing from "../../common/mixins/listing";
  import notification from "../../api/user/notification";
  import listingSelect from '../../common/mixins/listingSelect';

  export default {
    name: "Inbox",
    mixins: [listing, listingSelect],
    data() {
      return {
        api: notification.index,
        listing: {
          pagination: {
            onChange: this.handlePageChange,
            onShowSizeChange: this.handlePageSizeChange,
            showTotal: (total, range) => `${range[0]}-${range[1]} of ${total} messages`,
            showSizeChanger: true
          },
          sorter: {},
          filters: {},
          keyword: ''
        },
        notification: {
          unreadCount: 10
        }
      }
    },
    metaInfo() {
      return {
        title: `Inbox`
      }
    },
    methods: {
      /**
       * Since the API was created using resources
       * @override
       * @param data
       */
      updateData(data) {
        const pagination = {...this.listing.pagination}
        pagination.total = data.meta.total
        this.data = data.data
        this.listing.pagination = pagination
        // TODO: this is a workaround for api returning string instead of integer
        this.selectionConfig.pageSize = Number.parseInt(data.meta.per_page)
        this.selectionConfig.totalItems = data.meta.total
        this.selection.selectedKeys = []
      },
      isRead(item) {
        if (item.read_at !== null) {
          return {
            color: '#ccc'
          }
        }
      },
      markAsRead () {
        const ids = this.selection.selectedKeys;
        notification.markSelectedAsRead(ids).then(({data}) => {
          this.updateReadAt(ids)
        })
      },
      updateReadAt (ids) {
        const currentTime = new Date()
        ids.forEach((id) => {
          const index = this.data.findIndex(item => item.id === id)
          const data = this.data[index]
          data.read_at = currentTime
          this.data.splice(index, 1, data)
        })
        this.$clearSelection()
      },
      deleteMessage () {
        const ids = this.selection.selectedKeys;
        notification.destroySelected(ids).then(({data}) => {
          ids.forEach((id) => {
            const index = this.data.findIndex(item => item.id === id)
            this.data.splice(index, 1)
          })
          this.$clearSelection()
        })
      }
    }
  }
</script>

<style scoped>

</style>
