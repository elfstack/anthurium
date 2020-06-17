<template>
    <div>
        <a-page-header :title="user.name" style="background: #fff;margin: -50px;padding: 50px 50px 0;">
            <template #footer>
                <a-tabs>
                    <a-tab-pane key="profile" tab="Profile"></a-tab-pane>
                    <a-tab-pane key="participation" tab="Participation"></a-tab-pane>
                    <a-tab-pane key="achievement" tab="Achievement"></a-tab-pane>
                </a-tabs>
            </template>
        </a-page-header>

        <router-view />
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import user from "../../../api/user/user"
    import store from "../../store"

    // FIXME: this is a workaround for not getting current logged in user before enter
    const isSameUser = async (id) => {
        if (!store.getters['user/loaded']) {
            await store.dispatch('user/getUser')
        }

        return id === store.getters['user/user'].id
    }

    export default {
        name: "Show",
        metaInfo () {
            return {
                title: this.user.name
            }
        },
        data () {
            return {
                user: {}
            }
        },
        beforeRouteEnter (to, from, next) {
           if (isSameUser(to.params.id)) {
               next(vm => vm.setUser(store.getters['user/user']))
           }
        },
        beforeRouteUpdate (to, from, next) {
            this.user = null
            if (isSameUser(to.params.id)) {
                this.setUser(this.$store.getters['user/user'])
                next()
            }
        },
        methods: {
            setUser (user) {
                this.user = user
            }
        }
    }
</script>

<style scoped>

</style>
