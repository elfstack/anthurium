<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ activity.name }}</h5>
            <h6 class="card-subtitle">{{ activity.starts_at }} - {{ activity.ends_at }}</h6>
            <p class="card-text"></p>
            <a :href="`/activity/${activity.id}`" class="card-link">View</a>
            <a class="card-link">{{ activity.participants_count }} Participants</a>
        </div>
        <div class="flex-grow-1">
            <div class="progress" style="height: 3px">
                <div
                    class="progress-bar"
                    role="progressbar"
                    :style="`width: ${( activity.participants_count / activity.quota ) * 100 }%`"
                    :aria-valuenow="activity.participants_count"
                    aria-valuemin="0"
                    :aria-valuemax="activity.quota">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        activity: {
            type: Object,
            required: true
        }
    }
}
</script>
