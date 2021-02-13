<template>
  <a-list-item>
    <template slot="actions">
        <span>
          <a-icon type="clock-circle" style="margin-right: 4px"/>
          {{ data.ends_at | moment('from', data.starts_at, true) }}
        </span>
    </template>
    <template slot="actions">
        <span>
          <a-icon type="user" style="margin-right: 4px"/>
          {{ data.approved_participants }} / {{ data.quota}}
        </span>
    </template>

    <a-list-item-meta>
      <router-link
        slot="title"
        :to="{
          name: 'app.activities.show',
          params: {
            id: data.details.activity_id,
            participationId: data.details.id
          }
      }">
        {{ data.name }}
        <small style="float: right">
          {{ data.starts_at | moment('LLL') }} - {{ data.ends_at | moment('LLL') }}
        </small>
      </router-link>
      <template slot="description">
        <a-badge status="processing" text="Processing" v-if="data.details.participation_status === 'pending'"/>
        <a-badge status="error" text="Rejected" v-if="data.details.participation_status === 'rejected'" />
        <template v-if="data.details.participation_status === 'admitted'" >
          <a-badge status="processing" text="Coming soon" v-if="!data.details.attend_status" />
          <a-badge status="success" :text="data.details.attend_status" v-else />
        </template>
      </template>
    </a-list-item-meta>
    {{ data.details.content ? data.details.content : "No description available" }}
  </a-list-item>
</template>

<script>
  export default {
    name: "ParticipationListItem",
    props: {
      data: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        actionMap: {}
      }
    }
  }
</script>

<style scoped>

</style>
