<template>
  <a-layout>

    <app-header/>

    <a-layout style="display: flex; align-items: center;">
      <a-layout-content class="layout-content" style="max-width: 1440px; width: 100%">
        <keep-alive>
          <router-view v-if="$route.meta.keepAlive"></router-view>
        </keep-alive>

        <router-view v-if="!$route.meta.keepAlive"></router-view>

      </a-layout-content>
    </a-layout>

  </a-layout>
</template>

<script>
  import Header from './Header'

  export default {
    name: "App",
    components: {
      'app-header': Header
    },
    metaInfo: {
      title: 'Loading...',
      titleTemplate: '%s | Anthurium'
    },
  }
</script>

<style scoped>
  .layout-content {
    padding: 50px 50px 0;
    min-height: calc(100vh - 64px);
  }
</style>
