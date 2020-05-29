<template>
    <div>
        <a-modal
            title="Create Activity"
            :visible="createModalVisible"
            :confirm-loading="creating"
            @ok="createActivity"
            @cancel="() => { createModalVisible = false }"
        >
            <a-form-model :model="activityForm" ref="activityForm" :rules="rules">
                <a-form-model-item prop="name" label="Name">
                    <a-input v-model="activityForm.name" placeholder="Name" />
                </a-form-model-item>

                <a-form-model-item prop="quota" label="Quota">
                    <a-input-number v-model="activityForm.quota" placeholder="Quota" />
                </a-form-model-item>

                <a-form-model-item prop="time" label="Time">
                    <a-range-picker
                        :show-time="{ format: 'HH:mm' }"
                        @ok="updateDuration"
                    />
                </a-form-model-item>
            </a-form-model>
        </a-modal>

        <a-page-header title="Activities">
            <template #extra>
                <a-button type="primary" icon="plus" @click="createModalVisible = true">
                    Create
                </a-button>
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
    import form from "../../../common/mixins/form";
    import activity from "../../../api/admin/activity";
    import moment from 'vue-moment'

    export default {
        name: "Index",
        mixins: [ listing, form ],
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
                },
                creating: false,
                createModalVisible: false,
                rules: {
                    name: [
                        { required: true }
                    ]
                },
                activityForm: {

                }
            }
        },
        methods: {
            createActivity () {
                this.$submit('activityForm', activity.create, this.activityForm).then(({data}) => {
                    this.$router.push({ name: 'admin.activities.show.overview', params: { id: data.activity.id } })
                })
            },
            updateDuration (value) {
                this.activityForm.starts_at = value[0]
                this.activityForm.ends_at = value[1]
            }
        }
    }
</script>

<style scoped>

</style>
