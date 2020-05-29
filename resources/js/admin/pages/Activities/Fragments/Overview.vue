<template>
    <div>
        <a-row :gutter="[16,16]" v-if="activity.status !== 'draft'">
            <a-col>
                <a-card title="Processing Status">
                    <a-tooltip :title="statisticsToolTip">
                        <a-progress :percent="percent" :success-percent="successPercent"/>
                    </a-tooltip>
                </a-card>
            </a-col>
        </a-row>
        <a-row :gutter="[16,16]">
            <a-col :span="16">
                <a-card title="Content">
                    <template slot="extra">
                        <a-icon
                            type="edit"
                            @click="editing = !editing"
                            v-if="!editing"
                        />
                        <template v-else>
                            <a-button @click="editing = !editing">Cancel</a-button>
                            <a-button :type="primary" @click="saveDescription">Save</a-button>
                        </template>
                    </template>
                    <template v-if="editing">
                        <editor
                            ref="descriptionEditor"
                            :initial-value="activity.content"
                        />
                    </template>
                    <template v-else>
                        <viewer :initial-value="activity.content"/>
                    </template>
                </a-card>
            </a-col>

            <a-col :span="8">
                <a-row :gutter="[16,16]" v-if="activity.status !== 'draft'">
                    <a-col>
                        <a-card>
                            <a-statistic-countdown
                                title="Time to start"
                                :value="activity.starts_at"
                                v-if="activity.status === 'upcoming'"
                                format="DD:HH:mm:ss"
                            />

                            <a-statistic-countdown
                                title="Time to end"
                                :value="activity.ends_at"
                                v-if="activity.status === 'ongoing'"
                                format="DD:HH:mm:ss"
                            />
                        </a-card>
                    </a-col>
                </a-row>
                <a-row :gutter="[16,16]">
                    <a-col>
                        <a-card title="Eligible To">

                        </a-card>
                    </a-col>
                </a-row>
            </a-col>
        </a-row>

    </div>
</template>

<script>
    import 'codemirror/lib/codemirror.css'
    import '@toast-ui/editor/dist/toastui-editor.css'
    import '@toast-ui/editor/dist/toastui-editor-viewer.css'
    import { Editor, Viewer } from '@toast-ui/vue-editor'
    import { mapState, mapActions } from 'vuex'

    // TODO: share state using vuex
    // TODO: editing api
    export default {
        name: "Overview",
        components: {
            editor: Editor,
            viewer: Viewer
        },
        data() {
            return {
                editing: false
            }
        },
        mounted () {
            this.getStatistics()
        },
        computed: {
            ...mapState({
                activity: state => state.activity.activity,
                statistics: state => state.activity.statistics
            }),
            statisticsToolTip () {
                if (this.activity.status === 'upcoming') {
                    let processed = this.statistics.admitted + this.statistics.rejected
                    return `${this.activity.quota} quota / ${this.statistics.applicant} applicant / ${processed} processed / ${this.statistics.applicant - processed} pending`
                }
            },
            percent () {
                if (this.activity.status === 'upcoming') {
                    return (this.statistics.applicant / this.activity.quota * 100).toFixed()
                }
            },
            successPercent () {
                if (this.activity.status === 'upcoming') {
                    let processed = this.statistics.admitted + this.statistics.rejected
                    return (processed / this.statistics.applicant * 100).toFixed()
                }
            }
        },
        methods: {
            saveDescription() {
                // TODO: send response
                const content = this.$refs['descriptionEditor'].invoke('getMarkdown')
                this.updateActivity({
                    content: content
                }).then(() => {
                    this.editing = false
                    this.$message.success('Content Updated!')
                })
            },
            ...mapActions({
                updateActivity: 'activity/updateActivity',
                getStatistics: 'activity/getStatistics'
            })
        }
    }
</script>

<style scoped>

</style>
