<template>
    <a-config-provider :getPopupContainer="getPopupContainer">
        <a-layout>
            <admin-side-nav></admin-side-nav>
            <a-layout>
                <admin-header></admin-header>
                <a-layout>
                    <a-layout-content>
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
                title: 'Page',
                // all titles will be injected into this template
                titleTemplate: `%s | Anthurium`
            }
        },
        data() {
            return {
                loading: true,
                config: {
                    locale: 'en'
                }
            }
        },
        created() {
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
