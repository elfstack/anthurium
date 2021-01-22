<template>
    <a-config-provider :getPopupContainer="getPopupContainer" :locale="locale[config.locale] ? locale[config.locale] : locale[config.fallBackLocale]">
        <a-layout>
            <admin-side-nav></admin-side-nav>
            <a-layout>
                <admin-header></admin-header>
                <a-layout style="display: flex; align-items: center">
                    <a-layout-content style="max-width: 1440px; width: 100%">
                        <keep-alive>
                            <router-view v-if="$route.meta.keepAlive"></router-view>
                        </keep-alive>

                        <router-view v-if="!$route.meta.keepAlive"></router-view>

                    </a-layout-content>
                </a-layout>
            </a-layout>
        </a-layout>
    </a-config-provider>
</template>

<script>
    import Header from './Header'
    import zh_CN from 'ant-design-vue/lib/locale-provider/zh_CN';
    import zh_TW from 'ant-design-vue/lib/locale-provider/zh_TW';
    import en_US from 'ant-design-vue/lib/locale-provider/en_US';
    import en_GB from 'ant-design-vue/lib/locale-provider/en_GB';

    import zh_CNm from 'moment/locale/zh-cn';
    import zh_TWm from 'moment/locale/zh-tw';
    import en_GBm from 'moment/locale/en-gb';
    import SideNav from "./SideNav"
    import Vue from 'vue'

    export default {
        name: "App",
        components: {
            'admin-header': Header,
            'admin-side-nav': SideNav
        },
        metaInfo() {
            return {
                title: 'Loading...',
                // all titles will be injected into this template
                titleTemplate: `%s | Anthurium`
            }
        },
        data() {
            return {
                loading: true,
                config: {
                    locale: 'en-gb',
                    fallBackLocale: 'en-us'
                },
                locale: {
                  'zh-cn': zh_CN,
                  'zh-tw': zh_TW,
                  'en-us': en_US,
                  'en-gb': en_GB
                }
            }
        },
        created () {
            this.setLocale()
        },
        methods: {
            getPopupContainer(el, dialogContext) {
                if (dialogContext) {
                    return dialogContext.getDialogWrap();
                } else {
                    return document.body;
                }
            },
            setLocale () {
                Vue.moment.locale(this.config.locale)
            }
        }
    }
</script>

<style scoped>

</style>
