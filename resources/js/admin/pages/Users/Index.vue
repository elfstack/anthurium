<template>
    <a-layout>
        <a-page-header title="Users">
            <template #extra>
              <!--router-link :to="{ name: 'admin.members.application' }">
                <a-button>
                  Pending Applications
                </a-button>
              </router-link -->
              <router-link :to="{ name: 'admin.members.create' }">
                    <a-button type="primary" icon="plus">
                        Create
                    </a-button>
                </router-link>
            </template>
        </a-page-header>

        <div class="p2">
            <a-row :gutter="[16,16]">
                <a-col>
                    <a-card class="card-dense">
                        <a-table
                            @change="handleChange"
                            :pagination="listing.pagination"
                            :loading="loading"
                            :columns="columns"
                            row-key="id"
                            :data-source="data">

                            <span slot="group" slot-scope="text,record">
                              <a-tag>{{ record.user_group.name }}</a-tag>
                            </span>

                            <span slot="action" slot-scope="text,record">
                              <a-badge :count="record.pending_actions_count" dot>
                                <router-link :to="{ name: 'admin.members.show.account', params: { id: record.id }}">Details</router-link>
                              </a-badge>
                            </span>

                        </a-table>
                    </a-card>
                </a-col>
            </a-row>
        </div>

    </a-layout>

</template>

<script>
    import user from "../../../api/admin/user";
    import listing from "../../../common/mixins/listing";

    export default {
        name: "Index",
        mixins: [ listing ],
        metaInfo: {
            title: 'Users'
        },
        data () {
            return {
                api: user.index,
                columns: [
                    {
                        dataIndex: 'id',
                        key: 'id',
                        title: 'ID',
                        sorter: true
                    },
                    {
                        dataIndex: 'name',
                        key: 'name',
                        title: 'Name'
                    },
                  {
                    dataIndex: 'group',
                    title: 'Group',
                    scopedSlots: { customRender: 'group' }
                  },
                  {
                    dataIndex: 'email',
                        title: 'Email'
                    },
                    {
                        dataIndex: 'pending_actions_count',
                        title: 'Action',
                        sorter: true,
                        sortDirections: ['descend'],
                        scopedSlots: { customRender: 'action' }
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
