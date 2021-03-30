<template>
  <a-layout-header>
    <a-row type="flex"
           justify="space-between">
      <a-col>
        <a-row type="flex">
          <a-col>
            <router-link
              to="/"
              tag="div"
              class="pr2 h4"
              style="color: #fff"
            >
              Anthurium
            </router-link>
          </a-col>
          <a-col>
            <a-menu
              theme="dark"
              mode="horizontal"
              :default-selected-keys="['dashboard']"
              :style="{ lineHeight: '64px' }"
            >
              <a-menu-item key="dashboard">
                <router-link to="/">
                  Dashboard
                </router-link>
              </a-menu-item>
              <a-menu-item key="activities">
                <router-link to="/activities">
                  Activities
                </router-link>
              </a-menu-item>
            </a-menu>
          </a-col>
        </a-row>

      </a-col>
      <a-col>
        <template v-if="$isLoggedIn()">
          <a-dropdown :trigger="['click']">
            <div @click="e => e.preventDefault()">
              <a-avatar size="large" :src="user.avatar_url" v-if="user.avatar_url"/>
              <a-avatar size="large" icon="user" v-else/>
              <span class="ml1 color-white">
                            {{ user.name }} <a-icon type="down"/>
                        </span>
            </div>
            <a-menu slot="overlay">
              <a-menu-item key="0">
                <router-link :to="{ name: 'app.user.profile', params: { id: user.id } }">My Profile</router-link>
              </a-menu-item>
              <a-menu-item key="1">
                <router-link :to="{ name: 'app.inbox' }">Inbox</router-link>
              </a-menu-item>
<!--              <a-menu-item key="2">-->
<!--                <router-link :to="{ name: 'app.member-registration' }" v-if="$config('user.can_apply_membership')">Member Registration</router-link>-->
<!--              </a-menu-item>-->
              <a-menu-divider/>
              <a-menu-item key="3" @click="logout">
                Logout
              </a-menu-item>
            </a-menu>
          </a-dropdown>
        </template>
        <template v-else>
          <router-link :to="{ name: 'app.login' }">
            <a-button ghost>
              Login
            </a-button>
          </router-link>
          <!-- TODO: control button visibility by config -->
          <router-link :to="{ name: 'app.register' }">
            <a-button ghost>
              Register
            </a-button>
          </router-link>
        </template>
      </a-col>
    </a-row>
  </a-layout-header>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    name: "Header",
    computed: {
      ...mapGetters('user', [
        'user'
      ])
    },
    methods: {
      ...mapActions('user', [
        'logout'
      ])
    }
  }
</script>

<style scoped>
  .color-white {
    color: #fff;
  }
</style>
