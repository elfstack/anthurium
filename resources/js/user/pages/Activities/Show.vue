<template>
    <div>
        <a-row :gutter="[16,16]">
            <a-col :span="24">
                <a-page-header :title="activity.name" style="background: #fff">
                    <template #tags>
                        <a-tag :color="statusColour[activity.status]">{{ activity.status }}</a-tag>
                    </template>

                    <template #extra>
                        <a-button
                            type="primary"
                            @click="$refs['enroll-modal'].$toggleVisibility()"
                            :disabled="activity.is_enrolled"
                        >
                            {{ activity.is_enrolled ? 'Enrolled' : 'Enroll' }}
                        </a-button>
                    </template>

                    <p>{{ activity.starts_at | moment('LLL') }} - {{ activity.ends_at | moment('LLL') }}</p>
                </a-page-header>
            </a-col>
        </a-row>
        <a-row :gutter="[16,16]">
            <a-col :span="18">
                <a-card
                    :tab-list="tabList"
                    :active-tab-key="tabKey"
                >
                    <viewer :initial-value="activity.content" height="500px"/>
                </a-card>
            </a-col>
            <a-col :span="6">
                <a-row :gutter="[16,16]">
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
                  <a-card>
                    <a-list :data-source="activity.user_groups">
                      <a-list-item slot="renderItem" slot-scope="item, index">
                        <a-icon type="check"/>&nbsp;
                        {{ item.name }}
                      </a-list-item>
                    </a-list>
                  </a-card>
                </a-col>
              </a-row>

              <a-row :gutter="[16,16]">
                    <a-col>
                        <a-card title="Calendar" body-style="padding: 0">
                            <a-calendar
                                :fullscreen="false"
                            ></a-calendar>
                        </a-card>
                    </a-col>
                </a-row>

            </a-col>
        </a-row>

      <enroll
        ref="enroll-modal"
            :id="activity.id"
            @user-enrolled="activity.is_enrolled = true"
        />

      <participation
        ref="participation-modal"
        :id="$route.params.id"
        :participationId="$route.params.participationId"
        v-if="$route.params.participationId"
      />

    </div>
</template>

<script>
  import '@toast-ui/editor/dist/toastui-editor-viewer.css'
  import {Viewer} from '@toast-ui/vue-editor'

  import activity from "../../../api/user/activity";

  import Enroll from './Fragments/Enroll'
  import Participation from './Fragments/Participation'

    export default {
        name: "Show",
        components: {
            Viewer,
            Enroll,
            Participation
        },
        metaInfo() {
            return {
                title: this.$route.params.participationId ? 'My Participation' : (this.activity ? this.activity.name : null)
            }
        },
        beforeRouteEnter(to, from, next) {
            activity.show(to.params.id).then(({data}) => {
                next(vm => {
                    vm.setActivity(data.activity)
                })
            })
        },
        beforeRouteUpdate(to, from, next) {
            this.setActivity(null)
            activity.show(to.params.id).then(({data}) => {
                this.setActivity(data.activity)
                next()
            })
        },
        data() {
            return {
                activity: null,
                statusColour: {
                    draft: 'purple',
                    ongoing: 'green',
                    upcoming: 'blue',
                    past: null
                },
                tabList: [
                    {
                        key: 'content',
                        tab: 'Content',
                    },
                    {
                        key: 'itinerary',
                        tab: 'Itinerary',
                    },
                ],
                tabKey: 'content'
            }
        },
        methods: {
            // TODO: if activity is public
            setActivity(activity) {
                this.activity = activity
            }
        }
    }
</script>

<style scoped>

</style>
