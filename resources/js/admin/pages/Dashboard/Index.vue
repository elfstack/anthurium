<template>
    <div class="p2">
        <a-row :gutter="[16, 16]">
            <a-col :span="6">
                <a-card>
                    <a-statistic
                        title="Volunteers"
                        :value="11.28"
                        :precision="2"
                        suffix="%"
                        :value-style="{ color: '#3f8600' }"
                        style="margin-right: 50px"
                    >
                        <template #prefix>
                            <a-icon type="arrow-up" />
                        </template>
                    </a-statistic>
                </a-card>
            </a-col>
        </a-row>
        <a-row :gutter="[16,16]">

        </a-row>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    metaInfo: {
        title: 'Dashboard'
    }
}
</script>

<style scoped>

</style>
