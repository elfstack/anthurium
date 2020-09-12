<template>
  <div>
    <a-row :gutter="[16,16]">
      <a-col>
        <h1>{{ participation.activity.name}}</h1>
        <!-- TODO: when activity not started, when user checked in, when activity ends, when activity ends but not checked in -->
        <a-card v-if="participation.participation_status === 'admitted' && participation.attend_status !== 'left'">
          <template #title>
            <a-tag>{{ participation.participant_type }}</a-tag>
            {{ participation.attend_status === 'arrived' ? 'Check Out' : 'Check In' }}
          </template>
          <a-row>
            <a-col :md="12">
              <qrcode :value="otp" v-if="otp"></qrcode>
              <p style="padding-left: 15px">Refresh every 10 seconds</p>
            </a-col>
            <a-col :md="12">
              <h2>{{ participation.activity.name }}</h2>
              <h3>{{ participation.participant.name }}</h3>
              <h4>{{ participation.activity.starts_at | moment('LLL') }} - {{ participation.activity.ends_at |
                moment('LLL')
                }}</h4>
            </a-col>
          </a-row>
        </a-card>

        <a-card v-if="participation.participation_status !== 'admitted'">
          <a-icon type="close-circle" theme="twoTone" two-tone-color="#f5222d" /> Not admitted
        </a-card>

        <a-card v-if="participation.attend_status === 'left'">
          <a-icon type="check-circle" theme="twoTone" two-tone-color="#52c41a" />
          <span>You have successfully participated this activity</span>
          <p>
            Duration: {{ participation.left_at | moment('diff', participation.arrived_at, 'minute') }} minutes
          </p>
        </a-card>
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]">
      <a-col>
        <a-card title="Timeline">
          <a-timeline>
            <a-timeline-item color="blue">Requested {{ participation.created_at | moment('LLL') }}</a-timeline-item>
            <a-timeline-item v-if="participation.participation_status === 'admitted'" color="green">
              Admit {{ participation.approved_at | moment('LLL') }}
            </a-timeline-item>
            <a-timeline-item v-if="participation.participation_status === 'rejected'" color="red">
              Reject {{ participation.rejected_at | moment('LLL') }}
            </a-timeline-item>

            <template v-if="participation.participation_status === 'admitted'">
              <a-timeline-item v-if="participation.attend_status !== 'unattended'" color="blue">
                Attend {{ participation.arrived_at | moment('LLL') }}
              </a-timeline-item>

              <a-timeline-item v-if="participation.attend_status === 'left'" color="green">
                Leave {{ participation.left_at | moment('LLL') }}
              </a-timeline-item>
            </template>
          </a-timeline>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>

<script>
  import participation from "../../../api/user/participation";
  import VueQrCode from '@chenfengyuan/vue-qrcode';

  export default {
    name: "Participation",
    components: {
      'qrcode': VueQrCode
    },
    data() {
      return {
        participation: {
          activity: {}
        },
        otp: ''
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => vm.getParticipationInfo(to.params.id))
    },
    beforeRouteUpdate(to, from, next) {
      this.getParticipationInfo(to.params.id)
      next()
    },
    methods: {
      getParticipationInfo(id) {
        participation.show(id).then(({data}) => {
          this.participation = data.participation
          if (this.participation.attend_status !== 'left') {
            this.getOtp()
          }
        })
      },
      getOtp() {
        participation.otp(this.participation.id).then(({data}) => {
          this.otp = data.otp
          setTimeout(this.getOtp, 10000)
        })
      }
    }
  }
</script>

<style scoped>

</style>
