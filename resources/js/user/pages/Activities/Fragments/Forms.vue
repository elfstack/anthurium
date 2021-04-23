<template>
  <a-list :data-source="data" :split="false">
    <a-list-item slot="renderItem" slot-scope="item, index" :style="item.type === 'title' ? 'padding: 0' : ''">
      <a-card v-if="item.type === 'form'" class="form-card" :class="{ 'form-is-filled' : item.content.is_filled }">
        <a-list-item-meta :description="item.content.form.description.substring(0, 100)">
          <router-link slot="title" :to="{ name: 'app.forms.show', params: { id: item.content.id }}">{{ item.content.form.title }}</router-link>
        </a-list-item-meta>
      </a-card>
      <h3 v-else style="margin: 0">{{ item.content }}</h3>
    </a-list-item>
    <div v-if="loading && !busy" class="demo-loading-container">
      <a-spin/>
    </div>
  </a-list>
</template>

<script>
  import dataCollection from "../../../../api/user/dataCollection";
  import listing from "../../../../common/mixins/listing";

  export default {
    name: "Forms",
    mixins: [ listing ],
    props: {
      activityId: {
        type: Number,
        required: true
      }
    },
    data () {
      return {
        api: (paramBag) => {
          paramBag.filters.activity_id = [this.activityId]
          return dataCollection.index(paramBag)
        },
        autoload: true,
        listing: {
          pagination: false
        },
        data: [
          {
            type: 'title',
            content: 'Enroll'
          },
          {
            type: 'form',
            disabled: false,
            content: {
              id: 1,
              title: 'Test form',
              available_to: '2021-02-03 15:25:03',
              description: 'This is the description of the test form',
              is_filled: true
            }
          },
          {
            type: 'form',
            disabled: true,
            content: {
              id: 1,
              title: 'Test form',
              available_to: '2021-02-03 15:25:03',
              description: 'This is the description of the test form',
              is_filled: false
            }
          }
        ]
      }
    },
    methods: {
      updateData (data) {
        const pagination = { ...this.listing.pagination }
        pagination.total = data.total
        this.data = data.data.map(item => {
          return {
            type: 'form',
            content: item
          }
        })
        this.listing.pagination = pagination
      },
    }
  }
</script>

<style scoped lang="less">
  .form-card {
    width: 100%;

  & /deep/ .ant-card-body {
      padding: 12px
    }
  }

  .form-is-filled {
    background-color: #f6ffed;
    border-color: #b7eb8f;
  }

  /deep/ .ant-list-item {
    padding-top: 4px;
    padding-bottom: 4px;
  }
</style>
