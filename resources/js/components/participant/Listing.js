import AppListing from '../app-components/Listing/AppListing';

Vue.component('participant-listing', {
    mixins: [AppListing],
    props: {
        activityId: Number
    },
    created () {
        if (this.activity) {
            window.axios.get(this.url).then(({data}) => {
                this.data = data
            })
        }
    }
});
