<template>
    <div>
        <a-row :gutter="[16,16]">
            <a-col>
                <a-card>
                    <pre>
{{ JSON.stringify(user, null, 2) }}
                    </pre>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        name: "Account",
        computed: {
            ...mapState({
                user: state => state.user.user
            })
        }
    }
</script>

<style scoped>

</style>
