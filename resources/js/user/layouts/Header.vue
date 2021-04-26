<template>
  <a-layout-header class="app-header">

    <a-row type="flex">
      <a-col class="logo">
            <div
              class="pr2 h4"
              style="color: #fff"
            >
              {{ $config('org_name') || 'Anthurium' }}
            </div>
      </a-col>

      <a-col class="menu" flex="auto">
            <a-menu
              class="nav-menu"
              theme="dark"
              mode="horizontal"
              :default-selected-keys="['dashboard']"
            >
              <a-menu-item key="dashboard" v-if="$isLoggedIn()">
                <router-link to="/">
                  <a-icon type="dashboard" />
                  <span>Dashboard</span>
                </router-link>
              </a-menu-item>
              <a-menu-item key="activities">
                <router-link to="/activities">
                  <a-icon type="compass" />
                  <span>Activities</span>
                </router-link>
              </a-menu-item>
            </a-menu>
      </a-col>

      <a-col class="user ant-menu-dark">
      <template v-if="$isLoggedIn()">
          <a-dropdown :trigger="['click']">
            <div @click="e => e.preventDefault()">
              <a-avatar size="large" :src="user.avatar_url" v-if="user.avatar_url"/>
              <a-avatar size="large" icon="user" v-else/>
              <span class="ml1 color-white username">
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
              <a-menu-item key="3" @click="logoutUser">
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
      ]),
      logoutUser () {
        this.logout().then(() => {
          this.$message.success('Logged out');
        })
      }
    }
  }
</script>

<style lang="less" scoped>
  .color-white {
    color: #fff;
  }


  .app-header {
    height: 48px;
    line-height: 48px;

    .nav-menu {
      line-height: 48px !important;
    }

    @media screen {
      @media (max-width: 768px) {
        padding: 0;

        .logo {
          width: 100%;
          justify-content: center;
          display: flex;
        }

        .username {
          display: none;
        }

        .nav-menu li {
          i {
            margin-right: 0;
            font-size: 18px;
          }
          span {
            display: none;
          }
        }

        .menu, .user {
          height: 48px;
        }

        .user {
          padding-right: 10px
        }
      }
    }
  }
</style>
