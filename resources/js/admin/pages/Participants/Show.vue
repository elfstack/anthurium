<template>
    <div>
        <a-row :gutter="[16,16]">
            <a-col :span="6">
              <a-card>
                <a-statistic
                  title="Activity Hours"
                  :value="300">
                </a-statistic>
              </a-card>
            </a-col>
            <a-col :span="6">
              <a-card>
                <a-statistic
                  title="Activities Applied"
                  :value="1">
                </a-statistic>
              </a-card>
            </a-col>
          <a-col :span="6">
            <a-card>
              <a-statistic
                title="Activities Approved"
                :value="1">
              </a-statistic>
            </a-card>
          </a-col>
          <a-col :span="6">
            <a-card>
              <a-statistic
                title="Activities Attended"
                :value="1">
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
                      :data-source="data"
                    >
                      <template slot="duration" slot-scope="text, record">
                          <template v-if="record.details.attend_status === 'unattended'">
                            N/A
                          </template>
                          <template v-if="record.details.attend_status === 'left'">
                            {{ record.details.left_at | moment('from', record.details.arrived_at, true) }}
                          </template>
                          <template v-if="record.details.attend_status === 'attended'">
                            {{ record.details.arrived_at | moment('from', 'now', true) }}
                          </template>
                      </template>
                      <template slot="updTime" slot-scope="text">
                        {{ text | moment('YYYY-MM-DD HH:mm:ss')}}
                      </template>
                      <template slot="admittance" slot-scope="text">
                        <a-tag :color="participationColourMapping[text]">{{ text }}</a-tag>
                      </template>
                      <template slot="attendance" slot-scope="text, record">
                        <template v-if="record.details.participation_status !== 'rejected'">
                          <a-tag :color="attendColourMapping[text]">{{ text }}</a-tag>
                        </template>
                      </template>

                    </a-table>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
    import users from "../../../api/admin/user";
    import listing from "../../../common/mixins/listing";
    import { mapState } from 'vuex'

    export default {
        name: "Show",
        mixins: [ listing ],
        data () {
            return {
                participantType: this.$route.meta.participantType,
                api: (paramBag) => users.participations(this.participant.id, paramBag),
              columns: [
                {dataIndex: 'details.participation_status', key: 'details.participation_status', title: 'Admittance', scopedSlots: {customRender: 'admittance'}},
                {dataIndex: 'details.attend_status', key: 'details.attend_status', title: 'Attendance', scopedSlots: {customRender: 'attendance'}},
                {dataIndex: 'name', key: 'name', title: 'Activity'},
                {dataIndex: 'duration', key: 'duration', title: 'Duration', scopedSlots: { customRender: 'duration' }},
                {
                  dataIndex: 'details.updated_at',
                  key: 'details.updated_at',
                  title: 'Updated At',
                  sorter: true,
                  scopedSlots: {customRender: 'updTime'}
                },
              ],
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
