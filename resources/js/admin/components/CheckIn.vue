<template>
    <div class="card text-center">
        <div class="card-body">
            <h1 class="card-title">{{ title }}</h1>
            <p class="card-text">Check In</p>
            <qrcode v-if="tokenUrl" :value="tokenUrl" :options="{ width: 200 }"></qrcode>
        </div>
    </div>
</template>

<script>
import Vue from 'vue';
import VueQrcode from '@chenfengyuan/vue-qrcode';

export default {
    props: {
        title: {
            type: String,
            required: true
        },
        activityId: {
            type: Number,
            required: true
        },
        url: {
            type: String,
            required: true
        }
    },
    data () {
        return {
            tokenUrl: null
        }
    },
    components: {
        'qrcode': VueQrcode
    },
    created () {
        this.getOTP();
        setInterval(this.getOTP, 10000);
    },
    methods: {
        getOTP () {
            window.axios.get('/admin/activities/' + this.activityId + '/checkin/otp').then(({data}) => {
                this.tokenUrl = this.url + '/activity/' + this.activityId + '?token=' + data.otp
            })
        }
    }
}
</script>
