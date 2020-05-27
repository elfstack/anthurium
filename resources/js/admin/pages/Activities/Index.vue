<template>
    <div>
        <a-page-header title="Activities">
            <template #extra>
                <router-link :to="{ name: 'admin.activities.create' }">
                    <a-button type="primary" icon="plus">
                        Create
                    </a-button>
                </router-link>
            </template>
        </a-page-header>

        <div class="p2">
            <a-card>
                <a-table
                    @change="handleChange"
                    :pagination="listing.pagination"
                    :loading="loading"
                    :columns="columns"
                    row-key="id"
                    :data-source="data">
                    <span slot="name" slot-scope="text,record">
                        <p class="truncate mb1">{{ text }}</p>
                        <small>
                            <a-tag>
                                <a-icon type="clock-circle" />
                                {{ record.ends_at | moment('from', record.starts_at, true) }}
                            </a-tag>
                            {{ record.starts_at }} - {{ record.ends_at }}
                        </small>
                    </span>
                    <span slot="status" slot-scope="text,record">
                        <a-tag :color="statusColourMapping[record.status]">{{ record.status }}</a-tag>
                    </span>
                    <span slot="action" slot-scope="text,record">
                        <router-link :to="{ name: 'admin.activities.show.overview', params: { id: record.id }}">Details</router-link>
                    </span>
                </a-table>
            </a-card>
        </div>
    </div>
</template>

<script>
    import listing from '../../../common/mixins/listing'
    import activity from "../../../api/admin/activity";

    import moment from 'vue-moment'
    export default {
        name: "Index",
        mixins: [ listing ],
        metaInfo: {
            title: 'Activities'
        },
        data () {
            return {
                api: activity.index,
                columns: [
                    { dataIndex: 'name', key: 'name', title: 'Name', scopedSlots: { customRender: 'name' } },
                    { dataIndex: 'status', key: 'status', title: 'Status', scopedSlots: { customRender: 'status'} },
                    { dataIndex: 'action', key: 'action', title: 'Action', scopedSlots: { customRender: 'action' } }
                ],
                statusColourMapping: {
                    draft: 'purple',
                    ongoing: 'green',
                    upcoming: 'blue',
                    past: null
                }
            }
        }
    }
</script>

<style scoped>

</style>
