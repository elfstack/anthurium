<template>
    <div>
        <a-page-header title="Create User" @back="$router.go(-1)"></a-page-header>
        <div class="p2">
            <a-row :gutter="[16,16]">
                <a-col>
                    <a-card title="Account">
                        <user-account-form />
                    </a-card>
                </a-col>
            </a-row>
        </div>
    </div>
</template>

<script>
    import Form from './Form'
    export default {
        name: "Create",
        components: {
            userAccountForm: Form
        }
    }
</script>

<style scoped>

</style>
