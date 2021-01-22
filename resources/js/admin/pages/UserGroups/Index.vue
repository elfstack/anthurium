<template>
    <a-layout>
        <a-page-header title="User Groups">
            <template #extra>
                <router-link :to="{ name: 'admin.user-groups.create' }">
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
                            :pagination="false"
                            :loading="loading"
                            :columns="columns"
                            row-key="id"
                            :data-source="data">

                            <span slot="usersCount" slot-scope="text,record">
                              <a-tag>{{ text }} members</a-tag>
                            </span>

                            <span slot="action" slot-scope="text,record">
                                <router-link :to="{ name: 'admin.user-groups.show', params: { id: record.id }}">
                                  Details
                                </router-link>
                            </span>

                        </a-table>
                    </a-card>
                </a-col>
            </a-row>
        </div>

    </a-layout>

</template>

<script>
    import userGroups from "../../../api/admin/userGroup";
    import listing from "../../../common/mixins/listing";
    import listingAdapter from "../../../common/mixins/listingAdapter.js";

    export default {
        name: "Index",
        mixins: [ listing ],
        metaInfo: {
            title: 'Users'
        },
        data () {
            return {
                api: listingAdapter(() => userGroups.index(true), 'user_groups'),
                columns: [
                    {
                        dataIndex: 'name',
                        title: 'Name',
                      width: '70%'
                    },
                  {
                    dataIndex: 'users_count',
                    title: 'No. of Members',
                    scopedSlots: { customRender: 'usersCount' }
                  },
                    {
                        dataIndex: 'action',
                        title: 'Action',
                        scopedSlots: { customRender: 'action' }
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
