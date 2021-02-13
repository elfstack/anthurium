<template>
    <div>
        <a-page-header  @back="$router.go(-1)">
            <template #title>
                <a-tooltip v-if="!editingName" @click="editingName = true">
                    <template slot="title">
                        Rename
                    </template>
                    {{ activity.name }}
                </a-tooltip>
                <a-input v-else @pressEnter="updateName" :value="activity.name" />
            </template>
            <template #tags>
                <a-tag :color="statusColour[activity.status]">{{ activity.status }}</a-tag>
                <a-tooltip>
                    <template #title>
                        Duration
                    </template>
                    <a-tag>
                        <a-icon type="clock-circle" />
                        {{ activity.ends_at | moment('from', activity.starts_at, true) }}
                    </a-tag>
                </a-tooltip>
                <a-tooltip v-if="!editingQuota" @click="editingQuota = true">
                    <template #title>
                        Quota
                    </template>
                    <a-tag>
                        <a-icon type="team" />
                        {{ activity.quota }}
                    </a-tag>
                </a-tooltip>
                <a-input-number size="small" v-else @pressEnter="updateQuota" :value="activity.quota"></a-input-number>
            </template>

            <template #extra>
                <a-button key="1" type="primary" v-if="!activity.is_published" @click="publish">
                    Publish
                </a-button>
            </template>


            <template #footer>
                <a-tabs :active-key="activeTab" @change="changeTab">
                    <a-tab-pane key="overview" tab="Overview"/>
                    <!-- a-tab-pane key="information" tab="Information" --/ -->
                    <a-tab-pane key="participants" tab="Members" v-if="activity.status !== 'draft'"/>
                    <!-- a-tab-pane key="forms" tab="Forms" / -->
                    <a-tab-pane key="data-collection" tab="Data Collection" />
                    <a-tab-pane key="settings" tab="Settings" />
                </a-tabs>
            </template>
        </a-page-header>

        <div class="p2">
            <router-view />
        </div>
    </div>
</template>

<script>
    import { mapActions, mapState } from 'vuex'
    import activity from "../../../api/admin/activity"
    import store from '../../store'

    export default {
        name: "Show",
        metaInfo () {
            return {
                title: this.activity.name
            }
        },
        data () {
            return {
                activeTab: 'overview',
                statusColour: {
                    draft: 'purple',
                    ongoing: 'green',
                    upcoming: 'blue',
                    past: null
                },
                editingName: false,
                editingQuota: false
            }
        },
        computed: {
            ...mapState({
                activity: state => state.activity.activity
            }),
            canCheckIn () {
                return this.activity.status == 'ongoing'
            },
        },
        beforeRouteEnter(to, from, next) {
            store.dispatch('activity/getActivity', to.params.id).then(() => {
                next(
                    vm => {
                        vm.activeTab = to.name.split('.')[3]
                    }
                )
            })
        },
        methods: {
            ...mapActions({
                updateActivity: 'activity/updateActivity',
            }),
            publish () {
                this.updateActivity({
                    is_published: true
                }).then(() => {
                    this.$message.success('Activity Published')
                })
            },
            updateName (e) {
                let name = e.target.value
                this.editingName = false
                if (name === '') return
                this.updateActivity({
                    name: name
                })
            },
            updateQuota (e) {
                let quota = e.target._value
                this.editingQuota = false
                if (quota < 1) return
                this.updateActivity({
                    quota: quota
                })
            },
            changeTab (key) {
                this.activeTab = key
                this.$router.push({ name: 'admin.activities.show.' + key })
            }
        }
    }
</script>

<style scoped>

</style>
