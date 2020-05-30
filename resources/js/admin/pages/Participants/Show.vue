<template>
    <div>
        <a-row :gutter="[16,16]">
            <a-col :span="6">
                <a-card>
                    Total Duration: 300h
                </a-card>
            </a-col>
            <a-col :span="6">
                <a-card>
                    18 Activities participated
                </a-card>
            </a-col>
        </a-row>
        <a-row :gutter="[16,16]">
            <a-col>
                <a-card>
                    <a-timeline>
                        <a-timeline-item v-for="item in data">
                            <a-card>
                                <p>{{ item.starts_at | moment('ll') }}&nbsp;<b>{{ item.name }}</b></p>
                                <a-tag v-if="item.details.attend_status !== 'unattended'">
                                    {{ item.details.participation_status }}
                                </a-tag>
                                <a-tag v-if="item.details.participation_status === 'admitted'">
                                    {{ item.details.attend_status }}
                                </a-tag>
                                <a-tag v-if="item.details.attend_status === 'left'">
                                    {{ item.details.arrived_at | moment('from', item.details.left_at, true) }}
                                </a-tag>
                            </a-card>
                        </a-timeline-item>
                    </a-timeline>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
    import users from "../../../api/admin/user";
    // TODO: switch to guest api
    import listing from "../../../common/mixins/listing";
    import { mapState } from 'vuex'

    export default {
        name: "Show",
        mixins: [ listing ],
        data () {
            return {
                participantType: this.$route.meta.participantType,
                api: (paramBag) => users.participations(this.participant.id, paramBag)
            }
        },
        created() {
            this.fetchData()
        },
        computed: {
            participant () {
                return this.$store.state[this.participantType][this.participantType]
            }
        }
    }
</script>

<style scoped>

</style>
