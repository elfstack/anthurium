import { BaseForm } from 'craftable';

export default {
	mixins: [BaseForm],
    methods: {
        onSuccess: function onSuccess(data) {
          this.submiting = false;
          if (data.redirect) {
            window.location.replace(data.redirect);
          }
          this.$notify({
            type: 'success',
            title: 'Success!'
          });
        },
    }
};
