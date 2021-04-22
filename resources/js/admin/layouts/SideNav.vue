<template>
  <a-layout-sider
    width="256"
    v-model="collapsed"
    style="background: #fff"
  >
    <router-link
      to="/"
      tag="div"
      class="logo h4 center"
    >
      {{ !collapsed ? 'Anthurium' : 'An' }}
    </router-link>
    <a-menu
      :open-keys.sync="openKeys"
      v-model="selectedKeys"
      mode="inline"
    >
      <a-menu-item class="menu-group-header" disabled>
        <div class="ant-menu-item-group-title">Member</div>
      </a-menu-item>

      <a-menu-item key="users">
        <router-link to="/users">
          <a-icon type="user"></a-icon>
          <span>Users</span>
        </router-link>
      </a-menu-item>

      <a-menu-item key="user-groups">
        <router-link to="/user-groups">
          <a-icon type="team"></a-icon>
          <span>User Groups</span>
        </router-link>
      </a-menu-item>

      <a-menu-item class="menu-group-header" disabled>
        <div class="ant-menu-item-group-title">Operation</div>
      </a-menu-item>

      <a-menu-item key="activities">
        <router-link to="/activities">
          <a-icon type="compass"></a-icon>
          <span>Activities</span>
        </router-link>
      </a-menu-item>

      <a-menu-item key="forms">
        <router-link to="/forms">
          <a-icon type="file-text"></a-icon>
          <span>Forms</span>
        </router-link>
      </a-menu-item>
      <!--a-sub-menu key="members">
        <span slot="title">
          <a-icon type="user"></a-icon>
          <span>Members</span>
        </span>
        <a-menu-item key="Members">
          <router-link to="/members">
            Members
          </router-link>
        </a-menu-item>

        <a-menu-item key="Membership">
          <router-link to="/members/membership">
            Membership
          </router-link>
        </a-menu-item>
      </a-sub-menu-->




      <!--a-menu-item class="menu-group-header" disabled>
        <div class="ant-menu-item-group-title">Settings</div>
      </a-menu-item -->

      <!--a-menu-item key="general">
        <router-link to="/site-settings/site-info">
          <a-icon type="setting"></a-icon>
          <span>Site Info</span>
        </router-link>
      </a-menu-item -->
      <a-menu-item class="menu-group-header" disabled>
        <div class="ant-menu-item-group-title">Management</div>
      </a-menu-item>

        <a-menu-item key="admin-users" v-if="$can('admin.admin-users')">
          <router-link to="/manage-access/admin-users">
            <a-icon type="user"></a-icon>
            <span>Admin Users</span>
          </router-link>
        </a-menu-item>
        <a-menu-item key="roles" v-if="$can('admin.roles')">
          <router-link to="/manage-access/roles">
            <a-icon type="safety"></a-icon>
            <span>Roles & Permissions</span>
          </router-link>
        </a-menu-item>
        <!--a-menu-item key="audits" v-if="$can('admin.audits')">
          <router-link to="/manage-access/audits">Action Log</router-link>
        </a-menu-item -->
    </a-menu>
  </a-layout-sider>
</template>

<script>
  export default {
    name: "SideNav",
    data() {
      return {
        openKeys: [],
        selectedKeys: [],
        collapsed: false
      }
    },
    created () {
      this.updateSelected(this.$route.name)
    },
    watch: {
      'collapsed': function (val) {
        if (val === true) {
          this.openKeys = []
        }
      },
      '$route.name': function (val) {
        const name = val.split('.')
//        this.openKeys = [name[0]]
        this.selectedKeys = [name[1]]
      }
    },
    methods: {
      updateSelected (val) {
        const name = val.split('.')
//        this.openKeys = [name[0]]
        this.selectedKeys = [name[1]]
      }
    }
  }
</script>

<style scoped>
  .logo {
    height: 64px;
    line-height: 64px;
  }

  .menu-group-header {
    background: unset !important;
  }

  .ant-menu-inline .ant-menu-item::after {
    border-right: unset;
  }
</style>
