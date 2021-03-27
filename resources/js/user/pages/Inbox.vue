<template>
  <a-card>
    <a-list
      :data-source="data"
      :pagination="listing.pagination"
      :loading="loading">
      <a-list-item slot="renderItem" slot-scope="item, index">
        <a-list-item-meta
          :description="item.description">

          <router-link
            slot="title"
            :to="{ name: 'app.inbox.message', params: { id: item.id } }"
            :style="isRead(item)"
          >
            <a-badge color="blue" v-show="item.read_at === null" />
            {{ item.title }}
          </router-link>
        </a-list-item-meta>
        <div>{{ item.created_at | moment('from') }}</div>
      </a-list-item>
    </a-list>
  </a-card>
</template>

<script>
  import listing from "../../common/mixins/listing";
  import notification from "../../api/user/notification";

    export default {
      name: "Inbox",
      mixins: [ listing ],
      data () {
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
      metaInfo () {
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
        updateData (data) {
          const pagination = { ...this.listing.pagination }
          pagination.total = data.meta.total
          this.data = data.data
          this.listing.pagination = pagination
        },
        isRead (item) {
          if (item.read_at !== null) {
            return {
              color: '#ccc'
            }
          }
        }
      }
    }
</script>

<style scoped>

</style>
