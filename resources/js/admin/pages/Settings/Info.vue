<template>
  <div>
    <a-page-header title="Site Info"></a-page-header>
    <div class="p2">
      <a-row :gutter="[16, 16]">
        <a-col>
          <a-card title="Members">
            <register-config />
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

  export default {
    name: "Info",
    components: {
      'register-config': RegisterConfig
    },
    metaInfo: {
      title: 'Info'
    }
  }
</script>

<style scoped>

</style>
