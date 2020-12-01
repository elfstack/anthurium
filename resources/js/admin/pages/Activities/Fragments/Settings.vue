<template>
    <div>
      <a-row :gutter="[16,16]">
        <a-col>
          <a-card title="Schedule">
            <template slot="extra">
              <a-button :type="primary" @click="saveDescription">Save</a-button>
            </template>
            <a-form-model :wrapper-col="wrapperCol" :label-col="labelCol">
              <a-form-item label="Time">
                <a-range-picker
                  :show-time="{ format: 'HH:mm' }"
                  :default-value="[$moment(activity.starts_at), $moment(activity.ends_at)]"
                  @ok="updateDuration"
                />
              </a-form-item>

              <!-- TODO: reschedule button if published -->
            </a-form-model>
          </a-card>
        </a-col>
      </a-row>
      <a-row :gutter="[16,16]">
        <a-col>
          <a-card title="Recruitment">
            <template slot="extra">
              <a-button :type="primary" @click="saveDescription">Save</a-button>
            </template>
            <a-form-model :wrapper-col="wrapperCol" :label-col="labelCol">
              <a-form-item label="Quota">
                <a-input-number v-model="activity.quota" placeholder="Quota" />
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
    import { mapState, mapActions } from 'vuex'
    import formLayouts from "../../../../common/mixins/formLayouts";

    export default {
        name: "Settings",
        mixins: [ formLayouts ],
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
