<template>
  <div>
    <a-page-header title="Site Info"></a-page-header>
    <div class="p2">
      <a-row :gutter="[16, 16]">
        <a-col>
          <a-card title="Registration">
            <register-config :settings="configs"/>
          </a-card>
        </a-col>
      </a-row>
      <a-row :gutter="[16, 16]">
        <a-col>
          <a-card>
            <a-button type="primary">Clear Cache</a-button>
          </a-card>
        </a-col>
      </a-row>
    </div>
  </div>
</template>

<script>
  import RegisterConfig from './Forms/RegisterConfig'
  import config from "../../../api/admin/config";

  export default {
    name: "Info",
    components: {
      'register-config': RegisterConfig
    },
    beforeRouteEnter (to, from, next) {
      config.group('registration').then(({ data }) => {
        next(vm => vm.setConfig(data.configs))
      })
    },
    beforeRouteUpdate (to, from, next) {
      config.group('registration').then(({ data }) => {
        this.setConfig(data.configs)
        next()
      })
    },
    metaInfo: {
      title: 'Info'
    },
    data () {
      return {
        configs: {}
      }
    },
    methods: {
      setConfig (config) {
        this.configs = config
      }
    }
  }
</script>

<style scoped>

</style>
