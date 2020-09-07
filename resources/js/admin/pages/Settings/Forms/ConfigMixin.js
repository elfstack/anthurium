import formLayouts from "../../../../common/mixins/formLayouts"

import { mapGetters, mapActions, mapMutations } from 'vuex'

export default {
  mixins: [ formLayouts ],
  data () {
    return {
      configGroup: '', // specify the config group
      configs: {},  // configs in this section
      rules: {}, // form rules
      keys: [] // TODO: next phase, generate views from this,
    }
  },
  mounted () {
    this.configs = this.getConfigs(this.configGroup);
  },
  computed: {
    ...mapGetters({
      getConfigs: 'config/getConfigs',
      hasUncommittedChanges: 'config/hasUncommittedChanges'
    })
  },
  methods: {
    ...mapActions({
      commitConfigChanges: 'config/commitChanges'
    }),
    ...mapMutations('config', [
      'setUpdatedConfigs'
    ]),
    $submit(ref = 'form') {
      const form = this.$refs[ref]
      return form.validate().then(() => {
        this.setUpdatedConfigs(this.configs)
        return this.commitConfigChanges().then(response => {
          // TODO: successfully updated
          this.$message.success('Updated!')
        }).catch(error => {
          // TODO: error handling
          this.$message.error('An error occurs')
        })
      })
    }
  }
}
