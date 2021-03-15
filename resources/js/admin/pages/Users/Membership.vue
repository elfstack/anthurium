<template>
  <a-layout>
    <a-page-header title="Membership">
      <template #extra>
        <router-link :to="{ name: 'admin.members.membership.form' }">
          <a-button type="primary" icon="file">
            Membership Form
          </a-button>
        </router-link>
      </template>
    </a-page-header>

    <div class="p2">
      <a-row :gutter="[16,16]">
        <a-col>
          <a-card class="card-dense">
            <a-list-item>
              <a-list-item-meta
                :description="data[0].form.description"
              >
                <router-link
                  slot="title"
                  :to="{ name: 'admin.members.membership.data-collection.show', params: {id : data[0].id }}"
                >
                  {{ data[0].form.title }}
                </router-link>
              </a-list-item-meta>
            </a-list-item>

            <a-collapse :bordered="false">
              <a-collapse-panel key="1" header="History">
                <a-list item-layout="horizontal" :data-source="data">
                  <a-list-item slot="renderItem" slot-scope="item, index">
                    <a-list-item-meta
                      :description="item.form.description"
                    >
                      <router-link
                        slot="title"
                        :to="{ name: 'admin.members.membership.data-collection.show', params: {id : item.id }}"
                        :style="{ color: isActive(item) }">
                        {{ item.form.title }}
                      </router-link>
                    </a-list-item-meta>
                  </a-list-item>
                </a-list>
              </a-collapse-panel>
            </a-collapse>
          </a-card>
        </a-col>
      </a-row>

      <a-row :gutter="[16,16]">
        <a-col>
          <a-card title="Pending Applications">
            <application />
          </a-card>
        </a-col>
      </a-row>
    </div>
  </a-layout>
</template>

<script>
  import dataCollection from "../../../api/admin/dataCollection"
  import listing from "../../../common/mixins/listing"

  import Application from './Fragments/Application'

  export default {
    name: "Membership",
    mixins: [ listing ],
    data () {
      return {
        api: dataCollection.listMemberFormDataCollection
      }
    },
    components: {
      'application': Application
    },
    methods: {
      isActive (item) {
        if (item.is_closed || item.is_archived) {
          return '#ccc'
        } else {
          return '#000'
        }
      }
    }
  }
</script>

<style scoped>

</style>
