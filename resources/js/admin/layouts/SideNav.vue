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
      mode="vertical"
    >
      <a-menu-item class="menu-group-header" disabled>
        <div class="ant-menu-item-group-title">Manage</div>
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
      <a-menu-item key="Members">
        <router-link to="/members">
          <a-icon type="user"></a-icon>
          <span>Members</span>
        </router-link>
      </a-menu-item>
      <a-menu-item key="user-groups">
        <router-link to="/user-groups">
          <a-icon type="team"></a-icon>
          <span>User Groups</span>
        </router-link>
      </a-menu-item>


      <a-menu-item class="menu-group-header" disabled>
        <div class="ant-menu-item-group-title">Settings</div>
      </a-menu-item>

      <a-menu-item key="general">
        <router-link to="/site-settings/general">
          <a-icon type="setting"></a-icon>
          <span>General</span>
        </router-link>
      </a-menu-item>

      <!-- a-sub-menu key="manage-access">
        <span slot="title"><a-icon type="lock"/><span>Manage Access</span></span>
        <a-menu-item key="admin-users" v-if="$can('admin.admin-users')">
          <router-link to="/manage-access/admin-users">Admin Users</router-link>
        </a-menu-item>
        <a-menu-item key="roles" v-if="$can('admin.roles')">
          <router-link to="/manage-access/roles">Roles & Permissions</router-link>
        </a-menu-item>
        <a-menu-item key="audits" v-if="$can('admin.audits')">
          <router-link to="/manage-access/audits">Action Log</router-link>
        </a-menu-item>
      </a-sub-menu -->
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
    watch: {
      'collapsed': function (val) {
        if (val === true) {
          this.openKeys = []
        }
      }
    },
    created() {
      const name = this.$route.name.split('.')
      this.openKeys = [name[1]]
      this.selectedKeys = [name[2]]
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

  .menu-group-header::after {
    display: none;
  }
</style>
