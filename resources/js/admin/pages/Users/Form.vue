<template>
    <a-form-model>

    </a-form-model>
</template>

<script>
    import form from "../../../common/mixins/form";

    export default {
        name: "Form",
        mixins: [ form ],
        props: {
            api: {
                type: Function,
                required: true
            },
            data: {
                type: Object,
                required: true
            }
        },
        data () {
            return {
                loading: false,
                rules: [

                ]
            }
        }
    }
</script>

<style scoped>

</style>
