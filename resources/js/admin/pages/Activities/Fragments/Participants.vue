<template>
    <div>
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
                        <span slot="status" slot-scope="text, record">
                            <a-tag
                                :color="participationColourMapping[record.participation_status]"
                                v-if="activity.status === 'upcoming' || record.participation_status === 'rejected'"
                            >
                                {{ record.participation_status }}
                            </a-tag>
                            <a-tag
                                :color="attendColourMapping[record.attend_status]"
                                v-if="record.participation_status === 'approved' && activity.status !== 'upcoming'"
                            >
                                {{ record.attend_status }}
                            </a-tag>
                        </span>
                        <span slot="participant_type" slot-scope="text,record">
                            <a-tag :color="typeColourMapping[record.participant_type]">{{ record.participant_type }}</a-tag>
                        </span>
                        <span slot="updated_at" slot-scope="text,record">
                            {{ record.updated_at | moment('LLL') }}
                        </span>
                        <span slot="action" slot-scope="text,record,idx">
                            <!-- before event -->
                            <template v-if="record.participation_status === 'pending' && activity.status == 'upcoming'">
                                <a-button type="danger" icon="close" @click="updateStatus(record.id, 'rejected', idx)">Reject</a-button>
                                <a-button icon="check" @click="updateStatus(record.id, 'approved', idx)">Approve</a-button>
                            </template>
                            <template v-if="record.participation_status === 'approved'">
                                <!-- in event -->
                                <template v-if="activity.status === 'ongoing'">
                                    <a-button
                                        icon="import"
                                        @click="updateStatus(record.id, 'attended', idx)"
                                        v-if="record.attend_status === 'unattended'"
                                    >
                                        Check In
                                    </a-button>
                                    <a-button
                                        icon="export"
                                        @click="updateStatus(record.id, 'left', idx)"
                                        v-if="record.attend_status === 'attended'"
                                    >
                                        Check Out
                                    </a-button>
                                </template>
                                <template v-if="activity.status === 'past' && record.attend_status !== 'unattended' && record.attend_status !== 'left'">
                                    <a-button icon="export" @click="updateStatus(record.id, 'left', idx)">Check Out</a-button>
                                </template>
                            </template>
                        </span>
                    </a-table>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
    import activity from "../../../../api/admin/activity"
    import listing from "../../../../common/mixins/listing"
    import { mapState } from 'vuex'

    export default {
        name: "Participants",
        mixins: [ listing ],
        data () {
            return {
                api: (paramBag) => activity.participants(this.activity.id, paramBag),
                columns: [
                    { dataIndex: 'status', key: 'status', title: 'Status', scopedSlots: { customRender: 'status' }, align: 'center'},
                    { dataIndex: 'participant.name', key: 'participant.name', title: 'Name', align: 'center'},
                    { dataIndex: 'participant_type', key: 'participant_type', title: 'Type', scopedSlots: { customRender: 'participant_type'}, align: 'center' },
                    { dataIndex: 'updated_at', key: 'updated_at', title: 'Last Update', scopedSlots: { customRender: 'updated_at'}, align: 'center' },
                    { dataIndex: 'action', key: 'action', title: 'Action', scopedSlots: { customRender: 'action' }, align: 'center' }
                ],
                typeColourMapping: {
                    guest: 'blue',
                    user: 'purple'
                },
                participationColourMapping: {
                    rejected: 'red',
                    approved: 'green',
                    pending: 'blue'
                },
                attendColourMapping: {
                    unattended: 'red',
                    attended: 'green',
                    left: 'purple'
                }
            }
        },
        computed: {
            ...mapState({
                activity: state => state.activity.activity
            })
        },
        methods: {
            updateStatus (id, status, idx) {
                activity.updateParticipationStatus(id, status).then(() => {
                    if (Object.keys(this.participationColourMapping).includes(status)) {
                        this.data[idx].participation_status = status
                    } else {
                        this.data[idx].attend_status = status
                    }
                    this.data[idx].updated_at = new Date;
                })
            }
        }
    }
</script>

<style scoped>

</style>
