<template>
    <div>
        <a-page-header @back="$router.go(-1)" :title="user.name">
            <template #footer>
                <a-tabs :active-key="activeTab" @change="changeTab">
                    <a-tab-pane key="account" tab="Account" />
                    <a-tab-pane key="membership" tab="Membership" v-if="userIsNotGuest"/>
                    <a-tab-pane key="participation" tab="Participation" />
                </a-tabs>
            </template>
        </a-page-header>

        <div class="p2">
            <router-view />
        </div>
    </div>
</template>

<script>
    import store from '../../store'
    import { mapState } from 'vuex'

    export default {
        name: "Show",
        metaInfo () {
            return {
                title: this.user.name
            }
        },
        data () {
            return {
                activeTab: 'account'
            }
        },
        computed: {
            ...mapState({
                user: state => state.user.user
            })
        },
        beforeRouteEnter(to, from, next) {
            store.dispatch('user/getUser', to.params.id).then(() => {
                next(
                    vm => {
                        vm.activeTab = to.name.split('.')[3]
                    }
                )
            })
        },
        methods: {
            changeTab (key) {
                this.activeTab = key
                this.$router.push({ name: 'admin.members.show.' + key })
            },
            userIsNotGuest () {
              // TODO: move this to backend API
              if (!this.user) {
                return false
              }

              return this.user.user_group.id !== 1
            }
        }
    }
</script>

<style scoped>

</style>
