<template>
    <div>
        <a-row :gutter="[16,16]">
            <a-col>
                <a-card>
                    <a-row :gutter="8">
                        <a-col>
                            <a-range-picker
                                :show-time="{ format: 'HH:mm' }"
                                :default-value="[$moment(activity.starts_at), $moment(activity.ends_at)]"
                                @ok="updateDuration"
                            />
                            <a-tag>
                                <a-icon type="clock-circle"></a-icon>
                                {{ activity.ends_at | moment('from', activity.starts_at, true) }}
                            </a-tag>
                        </a-col>
                    </a-row>
                </a-card>
            </a-col>
        </a-row>
        <a-row :gutter="[16,16]">
            <a-col>
                <a-card>
                    // Under Construction
                    <a-timeline>
                        <a-timeline-item>Create a services site 2015-09-01</a-timeline-item>
                        <a-timeline-item>Solve initial network problems 2015-09-01</a-timeline-item>
                        <a-timeline-item>Technical testing 2015-09-01</a-timeline-item>
                        <a-timeline-item>Network problems being solved 2015-09-01</a-timeline-item>
                    </a-timeline>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        name: "Itinerary",
        computed: {
            ...mapState({
                activity: state => state.activity.activity
            })
        },
        methods: {
            updateDuration (value) {
                this.updateActivity({
                    starts_at: value[0],
                    ends_at: value[1]
                })
            },
            ...mapActions({
                updateActivity: 'activity/updateActivity'
            }),

        }
    }
</script>

<style scoped>

</style>
