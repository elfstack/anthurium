<template>
  <div class="p2">
    <a-row :gutter="[16, 16]">
      <a-col :span="12">
        <!--a-card>
        </a-card -->
      </a-col>
      <a-col :span="12">
        <a-row :gutter="[16,16]">
          <a-col :span="12">
            <a-card :loading="loading">
              <a-statistic
                title="Activities"
                :value="metrics.activities_count"
              />
            </a-card>
          </a-col>
          <a-col :span="12">
            <a-card :loading="loading">
              <a-statistic
                title="Members"
                :value="metrics.users_count"
              />
            </a-card>
          </a-col>
        </a-row>
        <a-row>
          <a-row :gutter="[16,16]">
            <!--a-col :span="12">
              <a-card>
                <a-statistic
                  title="Members"
                  :value="12"
                />
              </a-card>
            </a-col>
            <a-col :span="12">
              <a-card>Past Activities</a-card>
            </a-col-->
          </a-row>
        </a-row>
      </a-col>
    </a-row>
    <a-row :gutter="[16,16]">
      <!--a-card>
        // TODO: activity list (ongoing)
      </a-card -->
    </a-row>
  </div>
</template>

<script>
  export default {
    name: "Dashboard",
    metaInfo: {
      title: 'Dashboard'
    },
    data() {
      return {
        loading: true,
        metrics: {}
      }
    },
    mounted () {
      this.getData()
    },
    methods: {
      getData() {
        window.axios.get('/metrics').then(({data}) => {
          this.metrics = data
          this.loading = false
        })
      }
    }
  }
</script>

<style scoped>

</style>
