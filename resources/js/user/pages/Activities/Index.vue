<template>
    <div>
        <h1>Activities</h1>
        <a-row :gutter="[16,16]">
            <a-col :span="24">
                <a-card>
                    <a-input-search
                        v-model="listing.keyword"
                        @search="handleSearch"
                        :loading="loading"
                        allow-clear
                    />
                </a-card>
            </a-col>
        </a-row>

        <a-row :gutter="[16,16]">
            <a-col :span="24">
                <a-card>
                    <a-list
                        item-layout="vertical"
                        size="large"
                        :pagination="listing.pagination"
                        :data-source="data"
                        :loading="loading">
                        <a-list-item slot="renderItem" key="item.id" slot-scope="item, index">
                            <template slot="actions">
                                <span key="count">
                                    <a-icon type="team" />
                                    {{ item.approved_participants }}/{{ item.quota }}
                                </span>
                            </template>

                            <template slot="actions">
                                <span>
                                    <a-icon type="clock-circle" />
                                    {{ item.ends_at | moment('from', item.starts_at, true) }}
                                </span>
                            </template>
                            <a-list-item-meta :description="item.content ? item.content.substring(0,300): 'No description available'">
                                <router-link
                                    slot="title"
                                    :to="{ name: 'app.activities.show', params: { id: item.id } }"
                                >
                                    <a-tag :color="statusColour[item.status]">{{ item.status }}</a-tag>
                                    {{ item.name }}
                                    <small style="float: right">
                                        {{ item.starts_at | moment('LLL') }} - {{ item.ends_at | moment('LLL') }}
                                    </small>
                                </router-link>
                            </a-list-item-meta>
                        </a-list-item>
                    </a-list>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
    import activity from "../../../api/user/activity"
    import listing from "../../../common/mixins/listing"

    export default {
        name: "Index",
        metaInfo: {
            title: 'Activities'
        },
        mixins: [ listing ],
        data () {
            return {
                api: activity.index,
                listing: {
                    pagination: {
                        onChange: this.handlePageChange,
                        onShowSizeChange: this.handlePageSizeChange,
                        showTotal: (total, range) => `${range[0]}-${range[1]} of ${total} activities`,
                        showSizeChanger: true
                    },
                    sorter: {},
                    filters: {},
                    keyword: ''
                },
                statusColour: {
                    draft: 'purple',
                    ongoing: 'green',
                    upcoming: 'blue',
                    past: null
                },
            }
        }
    }
</script>

<style scoped>

</style>
