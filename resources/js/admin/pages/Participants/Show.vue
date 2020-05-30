<template>
    <div>
        <a-row :gutter="[16,16]">
            <a-col>
                <a-card>
                    <pre>{{ JSON.stringify(data, null, 2) }}
                    </pre>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
    import users from "../../../api/admin/user";
    // TODO: switch to guest api
    import listing from "../../../common/mixins/listing";
    import { mapState } from 'vuex'

    export default {
        name: "Show",
        mixins: [ listing ],
        data () {
            return {
                participantType: this.$route.meta.participantType,
                api: (paramBag) => users.participations(this.participant.id, paramBag)
            }
        },
        created() {
            this.fetchData()
        },
        computed: {
            participant () {
                return this.$store.state[this.participantType][this.participantType]
            }
        }
    }
</script>

<style scoped>

</style>
