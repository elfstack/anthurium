<template>
    <div>
      <a-row :gutter="[16, 16]">
        <a-col :span="12">
                <a-card>
                    <a-statistic
                        title="Permissions"
                        :value="role.permissions.length"
                        style="margin-right: 50px"
                    >
                    </a-statistic>
                </a-card>
            </a-col>
            <a-col :span="12">
                <a-card>
                    <a-statistic
                        title="Users"
                        :value="role.total_users"
                        style="margin-right: 50px"
                    >
                    </a-statistic>
                </a-card>
            </a-col>
        </a-row>
        <div>
            <a-table
                :pagination="false"
                :data-source="permissions"
                rowKey="id"
                :columns="columns"
                :row-selection="{ selectedRowKeys: role.permissions, onChange: onSelectChange }"
            ></a-table>
          <a-button icon="save" type="primary" @click="updateRole" :disabled="role.permissions.length === 0">
            Save
          </a-button>

            <a-button type="danger" icon="delete" class="mt2" @click="">
              Remove
            </a-button>
        </div>
    </div>
</template>

<script>
    import role from '../../../api/admin/role'
    import permission from '../../../api/admin/permission'
    export default {
        name: "Show",
        metaInfo () {
            return {
                title: this.role.name
            }
        },
        data () {
            return {
                role: {
                    id: '',
                    name: '',
                    permissions: []
                },
                columns: [
                    { dataIndex: 'name', key: 'name', title: 'Permission'}
                ],
                permissions: [],
            }
        },
        beforeRouteEnter (to, from, next) {
            next(vm => vm.fetchRole(to.params.id))
        },
        beforeRouteUpdate (to, from, next) {
            this.fetchRole(to.params.id)
            next()
        },
        created() {
            this.fetchRole()
        },
        methods: {
            // TODO: sort permissions selected, name
            fetchRole (id) {
                role.show(id).then(({data}) => {
                    this.role = data.role
                })
                permission.index().then(({data}) => {
                    this.permissions = data.permissions
                })
            },
            updateRole () {
                role.update(this.role).then(({data}) => {
                    this.$message.success("Updated!")
                })
            },
            onSelectChange(selectedRowKeys) {
                this.role.permissions = selectedRowKeys;
            },
        }
    }
</script>

<style scoped>

</style>
