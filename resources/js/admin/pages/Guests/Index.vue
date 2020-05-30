<template>
    <a-layout>
        <a-page-header title="Guests">
            <template #extra>
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
                                <router-link :to="{ name: 'admin.guests.show.account', params: { id: record.id }}">Details</router-link>
                                <a-divider type="vertical" />
                                <a>Invite</a>
                            </span>

                        </a-table>
                    </a-card>
                </a-col>
            </a-row>
        </div>

    </a-layout>

</template>

<script>
    import guest from "../../../api/admin/guest";
    import listing from "../../../common/mixins/listing";

    export default {
        name: "Index",
        mixins: [ listing ],
        metaInfo: {
            title: 'Guests'
        },
        data () {
            return {
                api: guest.index,
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
