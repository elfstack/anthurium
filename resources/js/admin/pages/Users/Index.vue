<template>
    <a-layout>
        <a-page-header title="Users">
            <template #extra>
                <router-link :to="{ name: 'admin.users.create' }">
                    <a-button type="primary" icon="plus">
                        Create
                    </a-button>
                </router-link>
            </template>
        </a-page-header>

        <div class="p2">
            <a-row :gutter="[16,16]">
                <a-col>
                    <a-card>
                        <a-table
                            @change="handleChange"
                            :pagination="listing.pagination"
                            :loading="loading"
                            :columns="columns"
                            row-key="id"
                            :data-source="data">

                            <span slot="action" slot-scope="text,record">
                                <router-link :to="{ name: 'admin.users.show.account', params: { id: record.id }}">Details</router-link>
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
                        dataIndex: 'email',
                        key: 'email',
                        title: 'Email'
                    },
                    {
                        dataIndex: 'action',
                        key: 'action',
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
