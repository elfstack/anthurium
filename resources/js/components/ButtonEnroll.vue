<template>
    <button class="btn btn-block" :class="statusClass" @click="toggleEnroll" :disabled="enrollStatus">
        Enroll
    </button>
</template>

<script>
export default {
    props: {
        activity: {
            type: Object,
            required: true
        },
        status: {
            type: Boolean,
            required: true
        }
    },
    created () {
        this.enrollStatus = this.status
    },
    data () {
        return {
            enrollStatus: false
        }
    },
    computed: {
        statusClass () {
            if (this.enrollStatus) {
                return 'btn-success';
            } else {
                return 'btn-primary';
            }
        }
    },
    methods: {
        toggleEnroll () {
            window.axios.patch(`/api/activity/${this.activity.id}/participants`).then(({data}) => {
                if (data.enrolled) {
                    this.enrollStatus = true
                }
            })
        }
    }
}
</script>
