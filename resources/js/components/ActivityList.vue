<template>
    <div>
        <h3 class="mb-3">Ongoing activities</h3>
        <activity-list-item v-for="item in ongoing.data" :key="item.id" :activity="item"/> 
        <infinite-loading @infinite="infiniteHandlerOngoing"></infinite-loading>

        <h3 class="mb-3">Upcoming activities</h3>
        <activity-list-item v-for="item in upcoming.data" :key="item.id" :activity="item"/> 
        <infinite-loading @infinite="infiniteHandlerUpcoming"></infinite-loading>

        <h3 class="mb-3">Past activities</h3>
        <activity-list-item v-for="item in past.data" :key="item.id" :activity="item" class="bg-light"/> 
        <infinite-loading @infinite="infiniteHandlerPast"></infinite-loading>
    </div>
</template>

<script>
import ActivityListItem from './ActivityListItem'
import InfiniteLoading from 'vue-infinite-loading'

export default {
    components: {
        'activity-list-item': ActivityListItem,
        'infinite-loading': InfiniteLoading
    },
    data () {
        return {
            ongoing: {
                current_page: 1,
                data: []
            },
            upcoming: {
                current_page: 1,
                data: []
            },
            past: {
                current_page: 1,
                data: []
            },
        }
    },
    created () {
        this.loadData()
    },
    methods: {
        infiniteHandlerOngoing($state) {
            axios.get('/api/activities?status=ongoing', {
                params: {
                    page: this.ongoing.current_page
                }
            }).then(({ data }) => {
                data = data.data
                this.ongoing.current_page = data.current_page + 1

                if (data.data.length) {
                    this.ongoing.data.push(...data.data);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        },
        infiniteHandlerUpcoming($state) {
            axios.get('/api/activities?status=upcoming', {
                params: {
                    page: this.upcoming.current_page
                }
            }).then(({ data }) => {
                data = data.data
                this.upcoming.current_page = data.current_page + 1

                if (data.data.length) {
                    this.upcoming.data.push(...data.data);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        },
        infiniteHandlerPast($state) {
            axios.get('/api/activities?status=past', {
                params: {
                    page: this.past.current_page
                }
            }).then(({ data }) => {
                data = data.data
                this.past.current_page = data.current_page + 1

                if (data.data.length) {
                    this.past.data.push(...data.data);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        }
    }
}
</script>
