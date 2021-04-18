<template>
  <a-modal
    title="Enroll"
    :visible="visible"
    @ok="handleOk"
    ok-text="Enroll"
    @cancel="handleCancel"
  >
    Are you sure to enroll this activity?
  </a-modal>
</template>

<script>
  import activity from "../../../../api/user/activity";

  export default {
    name: "Enroll",
    props: {
      id: {
        type: Number,
        required: true
      }
    },
    data() {
      return {
        visible: false,
        form: {
          name: '',
          email: ''
        }
      }
    },
    methods: {
      $toggleVisibility() {
        this.visible = !this.visible
        if (this.visible && !this.$isLoggedIn()) {
          this.$router.push({
            name: 'app.login',
            query: {
              redirect: this.$route.path
            }
          })
        }
      },
      handleOk() {
        this.userEnroll().then(({data}) => {
          this.$toggleVisibility()
          this.$message.success(data.message)
          this.$emit('user-enrolled')
        }).catch(() => {
          this.$toggleVisibility()
        })
      },
      handleCancel() {
        this.$toggleVisibility()
      },
      userEnroll() {
        return activity.enroll(this.id, null)
      }
    }
  }
</script>

<style scoped>

</style>
