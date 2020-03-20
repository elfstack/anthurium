import AppForm from '../app-components/Form/AppForm';

Vue.component('user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                email:  '' ,
                password:  ''

            },
            mediaCollections: ['avatar'],
            countdown: -1,
            timer: null
        }
    },
    methods: {
        sendVerification () {
            window.axios.post('/email/resend', {
                maxRedirects: 0,
            }).then(() => {
                this.countdown = 60
                if (!this.timer) {
                    this.timer = setInterval(() => {
                        if (this.countdown > 0 && this.countdown <= 60) {
                          this.countdown--;
                          if (this.countdown === 0) {
                            clearInterval(this.timer);
                            this.countdown = 60;
                            this.timer = null;
                          }
                       }
                    }, 1000)
                }
            })
        }
    }

});
