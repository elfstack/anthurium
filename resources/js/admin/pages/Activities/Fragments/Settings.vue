<template>
  <div>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card title="Schedule">
          <template slot="extra">
            <a-button @click="saveSchedule">Save</a-button>
          </template>
          <a-form-model :label-col="labelCol" :wrapper-col="wrapperCol">
            <a-form-item label="Time">
              <a-range-picker
                :default-value="getActivityTimeRange()"
                :show-time="{ format: 'HH:mm' }"
                @ok="updateDuration"
                format="YYYY-MM-DD HH:mm"
              />

              <template slot="help">
                <a-icon type="clock-circle"></a-icon>
                {{ activity.ends_at | moment('from', activity.starts_at, true) }}
              </template>
            </a-form-item>

            <a-form-item label="Application Close (not implemented)">
              <a-date-picker
              show-time>
              </a-date-picker>
            </a-form-item>
            <!-- a-form-item label="Start At">
              <a-date-picker>
              </a-date-picker>
              <a-time-picker
                format="HH:mm">
              </a-time-picker>

            </a-form-item>

            <a-form-item label="End At">
              <a-date-picker>
              </a-date-picker>

              <a-time-picker format="HH:mm">
              </a-time-picker>

              <template slot="help">
                <a-icon type="clock-circle"></a-icon>
                {{ activity.ends_at | moment('from', activity.starts_at, true) }}
              </template>
            </a-form-item -->

            <!-- TODO: reschedule button if published -->
          </a-form-model>
        </a-card>
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card title="Admission">
          <template slot="extra">
            <a-button :type="primary" @click="saveAdmission">Save</a-button>
          </template>
          <a-form-model :label-col="labelCol" :wrapper-col="wrapperCol">
            <a-form-item label="Quota">
              <a-input-number placeholder="Quota" v-model="activity.quota"/>
            </a-form-item>

            <a-form-item help="Who is able to view and enroll this activity"
                         label="User group">
              <a-transfer
                :data-source="userGroups"
                :render="item => `${item.title} (L${item.level})`"
                :target-keys="transfer.targetKeys"
                :selected-keys="transfer.selectedKeys"
                @change="handleTransferChange"
              />
            </a-form-item>

            <!-- a-form-item label="Policy">
              <a-select>
                <a-select-option value="fcfs">
                  First come first served
                </a-select-option>

                <a-select-option value="selection">
                  Via selection
                </a-select-option>
              </a-select>
            </a-form-item -->
          </a-form-model>

        </a-card>
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card title="Danger Zone">
          <a-button type="danger">Remove Activity</a-button>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>
  // TODO: rename activity
  // TODO: delete activity
  // TODO: cancel activity

  // TODO: archive activity (next-phase)
  import {mapState, mapActions} from 'vuex'
  import formLayouts from "../../../../common/mixins/formLayouts";
  import userGroup from '../../../../api/admin/userGroup';

  export default {
    name: "Settings",
    mixins: [formLayouts],
    computed: {
      ...mapState({
        activity: state => state.activity.activity
      })
    },
    mounted() {
      userGroup.index().then(({data}) => {
        this.userGroups = data.user_groups.map(item => ({key: item.id.toString(), title: item.name, level: item.level}))
        this.transfer.targetKeys = this.activity.user_groups.map(item => item['id'].toString());
      })
    },
    data() {
      return {
        userGroups: [],
        transfer: {
          targetKeys: [],
          selectKeys: []
        }
      }
    },
    methods: {
      updateDuration(value) {
        this.updateActivity({
          starts_at: value[0],
          ends_at: value[1]
        })
      },
      ...mapActions({
        updateActivity: 'activity/updateActivity'
      }),
      getActivityTimeRange() {
        return [
          this.activity.starts_at === null ? null : this.$moment(this.activity.starts_at),
          this.activity.ends_at === null ? null : this.$moment(this.activity.ends_at)
        ]
      },
      saveSchedule() {
        this.updateActivity({
          starts_at: this.activity.starts_at,
          ends_at: this.activity.ends_at
        }).then(() => {
          this.$message.success('Activity Updated!')
        })
      },
      handleTransferChange(nextTargetKeys, direction, moveKeys) {
        this.transfer.targetKeys = nextTargetKeys;
      },
      saveAdmission () {
        this.updateActivity({
          quota: this.activity.quota,
          user_groups: this.transfer.targetKeys
        }).then(() => {
          this.$message.success('Activity Updated!')
        })
      }
    }
  }
</script>

<style scoped>

</style>
