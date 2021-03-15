<template>
  <div>
    <a-form-model :model="configs" ref="form" :rules="rules" :label-col="labelCol" :wrapper-col="wrapperCol">
      <a-form-model-item
        :label="configKey"
        v-for="(value, configKey) in configs"
        :key="configKey"
        :prop="configKey"
      >
        <a-switch v-model="configs[configKey]"/>
      </a-form-model-item>

<!--      <a-form-model-item label="Default Member Group" prop="'user.default_member_group'">-->
<!--        <async-select-->
<!--          v-model="configs['user.default_member_group']"-->
<!--          :api="getUserGroup"-->
<!--        />-->
<!--      </a-form-model-item>-->

      <a-form-model-item :wrapper-col="btnWrapperCol">
        <a-button type="primary" @click="$submit('form')">Save</a-button>
      </a-form-model-item>
    </a-form-model>
  </div>
</template>

<script>
  import userGroup from "../../../../api/admin/userGroup"

  import configMixin from "./ConfigMixin"

  import AsyncSelect from '../../../components/AsyncSelect'

  export default {
    name: "RegisterConfigs",
    mixins: [ configMixin ],
    components: {
      'async-select': AsyncSelect
    },
    data() {
      return {
        configGroup: 'user',
        getUserGroup: () => userGroup.index().then(({ data }) => data.user_groups),
      }
    },
    mounted () {
      this.configs = this.getConfigs(this.configGroup);
    },
    methods: {
    }
  }
</script>

<style scoped>

</style>
