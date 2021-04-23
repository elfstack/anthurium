<template>
  <a-modal
    title="Participation"
    @ok="handleOk"
    @cancel="handleCancel"
    centered
    visible
  >
    <a-tabs style="margin-top: -24px" default-active-key="2">
      <a-tab-pane tab="Status" key="1">
        <a-timeline>
          <a-timeline-item color="blue">Requested {{ participation.created_at | moment('LLL') }}</a-timeline-item>
          <a-timeline-item v-if="participation.participation_status === 'admitted'" color="green">
            Admitted {{ participation.approved_at | moment('LLL') }}
          </a-timeline-item>
          <a-timeline-item v-if="participation.participation_status === 'rejected'" color="red">
            Rejected {{ participation.rejected_at | moment('LLL') }}
          </a-timeline-item>

          <template v-if="participation.participation_status === 'admitted'">
            <a-timeline-item v-if="participation.attend_status !== 'unattended'" color="blue">
              Attended {{ participation.arrived_at | moment('LLL') }}
            </a-timeline-item>

            <a-timeline-item v-if="participation.attend_status === 'left'" color="green">
              Left {{ participation.left_at | moment('LLL') }}
            </a-timeline-item>
          </template>
        </a-timeline>
      </a-tab-pane>
      <a-tab-pane tab="Forms" key="2">
        <forms :activity-id="id"/>
      </a-tab-pane>
    </a-tabs>

  </a-modal>
</template>

<script>
  import participation from "../../../../api/user/participation";
  import Forms from './Forms';

  export default {
    name: "Participation",
    components: {
      'forms': Forms
    },
    props: {
      id: {
        type: Number,
        required: true
      },
      participationId: {
        type: Number,
        required: true
      }
    },
    data() {
      return {
        participation: null
      }
    },
    mounted() {
      participation.show(this.participationId).then(({data}) => {
        this.participation = data.participation
      })
    },
    methods: {
      handleOk() {
        this.handleCancel()
      },
      handleCancel() {
        this.$router.replace({
          name: 'app.activities.show',
          params: {
            id: this.id
          }
        })
      }
    }
  }
</script>

<style scoped lang="less">

</style>
