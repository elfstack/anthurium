<template>
  <a-layout>
    <a-page-header title="Roles & Permissions" />
    <a-row :gutter="[16,16]" class="p2">
      <a-col :span="6">
        <a-card class="card-dense">
          <a-list size="large" bordered :data-source="roles" style="border: none" :loading="loadingRoles">
            <a-list-item slot="renderItem" slot-scope="item, index">
              <router-link
                :to="{
                                name: 'admin.manage-access.roles.index.show',
                                params: { id: item.id }
                            }"
              >
                {{ item.name }}
              </router-link>
            </a-list-item>
            <div slot="footer" @click="modalCreateRoleVisible = true">
              <a-icon type="plus"></a-icon>
              New Role
            </div>
          </a-list>
        </a-card>
        <a-modal
          v-model="modalCreateRoleVisible"
          title="Create role"
          centered
          @ok="createRole"
        >
          <a-form-model
            layout="horizontal"
            ref="create-role-form"
            :model="roleForm"
            :rules="rules"
            :label-col="{ sm: { span: 6 } }"
            :wrapper-col="{ sm: { span: 18 } }"
          >
            <a-form-model-item prop="name" has-feedback label="Name">
              <a-input v-model="roleForm.name"></a-input>
            </a-form-model-item>
            <a-form-model-item prop="is_for_admin" has-feedback label="Guard">
              <a-checkbox v-model="roleForm.is_for_admin">
                Role for admin
              </a-checkbox>
            </a-form-model-item>
          </a-form-model>
        </a-modal>
      </a-col>
      <a-col :span="18">
        <router-view></router-view>
      </a-col>
    </a-row>
  </a-layout>
</template>

<script>
  import role from '../../../api/admin/role'

  export default {
    name: "Index",
    metaInfo: {
      title: 'Roles & Permissions'
    },
    data() {
      return {
        roles: [],
        loadingRoles: true,
        modalCreateRoleVisible: false,
        roleForm: {
          name: '',
          is_for_admin: true
        },
        rules: {
          name: [{required: true}]
        }
      }
    },
    created() {
      role.index().then(({data}) => {
        this.roles = data.roles
        this.loadingRoles = false
      });
    },
    methods: {
      createRole() {
        this.$refs['create-role-form'].validate(valid => {
          if (valid) {
            role.create(this.roleForm).then(({data}) => {
              this.roles.push(data.role)
              this.modalCreateRoleVisible = false
            })
          }
        })
      }
    }
  }
</script>

<style scoped>

</style>
