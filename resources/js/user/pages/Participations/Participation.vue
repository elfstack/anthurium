<template>
  <div>
    <!-- TODO: when activity not started, when user checked in, when activity ends, when activity ends but not checked in -->
  <a-card v-if="participation.attend_status === 'unattended'">
    <template #title>
      <a-tag>{{ participation.participant_type }}</a-tag>
      Check In
    </template>
    <a-row>
      <a-col :md="12">
        <qrcode :value="otp" v-if="otp"></qrcode>
        <p style="padding-left: 15px">Refresh every 10 seconds</p>
      </a-col>
      <a-col :md="12">
        <h2>{{ participation.activity.name }}</h2>
        <h3>{{ participation.participant.name }}</h3>
        <h4>{{ participation.activity.starts_at | moment('LLL') }} - {{ participation.activity.ends_at | moment('LLL') }}</h4>
      </a-col>
    </a-row>
  </a-card>
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
    data () {
      return {
        participation: {},
        otp: ''
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => vm.getParticipationInfo(to.params.id))
    },
    beforeRouteUpdate (to, from, next) {
      this.getParticipationInfo(to.params.id)
      next()
    },
    methods: {
      getParticipationInfo (id) {
        participation.show(id).then(({data}) => {
          this.participation = data.participation
          if (this.participation.attend_status === 'unattended') {
            this.getOtp()
          }
        })
      },
      getOtp () {
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
