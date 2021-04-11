<template>
  <a-layout>
    <a-row :gutter="[16,16]">
      <a-col>
        <h1 class="h2">All Participations</h1>
        <a-card>
          <a-list
            item-layout="vertical"
            :data-source="data"
            :loading="loading">
            <participation-list-item slot="renderItem" slot-scope="item, index" :data="item"/>

          </a-list>
        </a-card>
      </a-col>
    </a-row>
  </a-layout>
</template>

<script>
  import {mapState} from 'vuex';

  import listing from "../../../common/mixins/listing";
  import participation from "../../../api/user/participation";

  import ParticipationListItem from '../../components/ParticipationListItem';

  export default {
    name: "Dashboard",
    metaInfo: {
      title: 'Dashboard'
    },
    mixins: [listing],
    components: {
      ParticipationListItem
    },
    data() {
      return {
        api: () => participation.listUserParticipation(this.userId),
        data: []
      }
    },
    computed: {
      ...mapState({
        userId: state => state.user.id
      })
    }
  }
</script>

<style scoped>

</style>
