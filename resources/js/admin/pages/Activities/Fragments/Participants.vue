<template>
    <div>
        <a-row :gutter="[16,16]" type="flex" justify="space-between">
            <a-col v-for="(statistic, idx) in currentStatistics" :key="idx" :span="6">
                <a-card>
                    <a-statistic
                        :title="statistic.title"
                        :value="statistic.value"
                    >
                      <template #suffix v-if="statistic.suffix">
                        <span>{{ statistic.suffix }}</span>
                      </template>
                    </a-statistic>
                </a-card>
            </a-col>
        </a-row>
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
                        <p slot="expandedRowRender" slot-scope="record" style="margin: 0">
                            <a-timeline>
                                <a-timeline-item color="blue">Requested {{ record.created_at | moment('LLL') }}</a-timeline-item>
                                <a-timeline-item v-if="record.participation_status === 'admitted'" color="green">
                                    Admit {{ record.approved_at | moment('LLL') }}
                                </a-timeline-item>
                                <a-timeline-item v-if="record.participation_status === 'rejected'" color="red">
                                    Reject {{ record.rejected_at | moment('LLL') }}
                                </a-timeline-item>

                                <template v-if="record.participation_status === 'admitted'">
                                    <a-timeline-item v-if="record.attend_status !== 'unattended'" color="blue">
                                        Attend {{ record.arrived_at | moment('LLL') }}
                                    </a-timeline-item>

                                    <a-timeline-item v-if="record.attend_status === 'left'" color="green">
                                        Leave {{ record.left_at | moment('LLL') }}
                                    </a-timeline-item>
                                </template>
                            </a-timeline>
                        </p>
                        <span slot="name" slot-scope="text, record">
                            <router-link
                                :to="{
                                    name: `admin.members.show.participation`,
                                    params: { id: record.participant.id } }"
                            >
                                {{ record.participant.name }}
                            </router-link>
                        </span>
                        <span slot="status" slot-scope="text, record">
                            <a-tag
                                :color="participationColourMapping[record.participation_status]"
                                v-if="activity.status === 'upcoming' || record.participation_status === 'rejected'"
                            >
                                {{ record.participation_status }}
                            </a-tag>
                            <a-tag
                                :color="attendColourMapping[record.attend_status]"
                                v-if="record.participation_status === 'admitted' && activity.status !== 'upcoming'"
                            >
                                {{ record.attend_status }}
                            </a-tag>
                        </span>
                        <span slot="participant_type" slot-scope="text,record">
                            <a-tag :color="typeColourMapping[record.participant.user_group.name ]">{{ record.participant.user_group.name }}</a-tag>
                        </span>
                        <span slot="updated_at" slot-scope="text,record">
                            {{ record.updated_at | moment('LLL') }}
                        </span>
                        <span slot="action" slot-scope="text,record,idx">
                            <!-- before event -->
                            <template v-if="activity.status === 'upcoming'">
                                <a-button type="danger"
                                          icon="close"
                                          @click="updateStatus(record, idx, 'rejected')"
                                          v-if="record.participation_status !== 'rejected'"
                                >
                                  Reject
                                </a-button>
                                <a-button icon="check"
                                          @click="updateStatus(record, idx, 'admitted')"
                                          v-if="record.participation_status !== 'admitted'"
                                >
                                  Admit
                                </a-button>
                            </template>
                            <template v-if="record.participation_status === 'admitted'">
                                <!-- in event -->
                                <template v-if="activity.status === 'ongoing'">
                                    <a-button
                                        icon="import"
                                        @click="updateStatus(record, idx, 'attended')"
                                        v-if="record.attend_status === 'unattended'"
                                    >
                                        Check In
                                    </a-button>
                                    <a-button
                                        icon="export"
                                        @click="updateStatus(record, idx, 'left')"
                                        v-if="record.attend_status === 'attended'"
                                    >
                                        Check Out
                                    </a-button>
                                </template>
                                <template v-if="activity.status === 'past' && record.attend_status !== 'unattended' && record.attend_status !== 'left'">
                                    <a-button icon="export" @click="updateStatus(record, idx, 'left')">Check Out</a-button>
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
    import { mapState, mapActions } from 'vuex'

    export default {
        name: "Participants",
        mixins: [ listing ],
        data () {
            return {
                api: (paramBag) => activity.participants(this.activity.id, paramBag),
                columns: [
                    { dataIndex: 'status', key: 'status', title: 'Status', scopedSlots: { customRender: 'status' }, align: 'center'},
                    { dataIndex: 'participant.name', key: 'participant.name', title: 'Name', align: 'center', scopedSlots: { customRender: 'name' } },
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
                    admitted: 'green',
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
                activity: state => state.activity.activity,
                statistics: state => state.activity.statistics
            }),
            currentStatistics () {
                const statistics = []
                if (this.activity.status === 'upcoming') {
                  statistics.push({
                    title: 'Applicant',
                    value: this.statistics.applicant
                  })

                  statistics.push({
                        title: 'Admitted',
                        value: this.statistics.admitted,
                        suffix: `/ ${this.activity.quota}`,
                    })

                  statistics.push({
                    title: 'Rejected',
                    value: this.statistics.rejected
                  })

                  statistics.push({
                        title: 'Pending',
                        value: this.statistics.pending
                    })
                }

                if (this.activity.status === 'ongoing' || this.activity.status === 'past') {
                    statistics.push({
                        title: 'Participants',
                        value: this.statistics.admitted
                    })
                    statistics.push({
                        title: 'Rejected',
                        value: this.statistics.rejected
                    })
                    statistics.push({
                        title: 'Attended',
                        value: this.statistics.attended
                    })
                    statistics.push({
                        title: 'Unattended',
                        value: this.statistics.unattended
                    })
                }

                return statistics
            }
        },
        mounted () {
            this.getStatistics()
        },
        methods: {
            ...mapActions({
                getStatistics: 'activity/getStatistics',
                updateStatistics: 'activity/updateStatistics'
            }),
            updateStatus (entry, idx, status) {
                activity.updateParticipationStatus(entry.id, status).then(() => {
                    // if status is for participation
                    if (Object.keys(this.participationColourMapping).includes(status)) {
                        this.updateStatistics(entry.participation_status, status)
                        this.data[idx].participation_status = status
                    } else {
                        this.updateStatistics(entry.attend_status, status)
                        this.data[idx].attend_status = status
                    }
                    this.data[idx].updated_at = new Date;

                    this.$message.success(status);
                })
            }
        }
    }
</script>

<style scoped>

</style>
