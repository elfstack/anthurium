<template>
  <a-layout>

    <app-header class="sticky-top"/>

    <a-layout style="display: flex; align-items: center;">
      <a-layout-content class="layout-content" style="max-width: 1440px; width: 100%">
        <keep-alive>
          <router-view v-if="$route.meta.keepAlive"></router-view>
        </keep-alive>

        <router-view v-if="!$route.meta.keepAlive"></router-view>

      </a-layout-content>
    </a-layout>

    <a-layout-footer style="text-align: center">
      Powered by <a href="https://anthurium.laceleaf.com">Anthurium</a>
    </a-layout-footer>

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

<style lang="less" scoped>
  .layout-content {
    padding: 50px 50px 0;
    min-height: calc(100vh - 48px);
  }

  @media screen and (max-width: 768px) {
    .layout-content {
      padding: 64px 16px 0;
      min-height: calc(100vh - 96px);
    }
  }

  .sticky-top {
    position: sticky;
    top: 0;
    z-index: 4;
  }
</style>
