<template>
    <a-layout>
        <a-layout-header>
            <a-row type="flex"
                   justify="space-between">
                <a-col>
                    <a-row type="flex">
                        <a-col>
                            <router-link
                                to="/"
                                tag="div"
                                class="px2 h4"
                                style="color: #fff"
                            >
                                {{ !collapsed ? 'Anthurium' : 'An' }}
                            </router-link>
                        </a-col>
                        <a-col>
                            <a-menu
                                theme="dark"
                                mode="horizontal"
                                :default-selected-keys="['2']"
                                :style="{ lineHeight: '64px' }"
                            >
                                <a-menu-item key="1">
                                    Dashboard
                                </a-menu-item>
                                <a-menu-item key="2">
                                    Activities
                                </a-menu-item>
                                <a-menu-item key="3">
                                    nav 3
                                </a-menu-item>
                            </a-menu>
                        </a-col>
                    </a-row>

                </a-col>
                <a-col>
                    <a-dropdown :trigger="['click']">
                        <div @click="e => e.preventDefault()">
                            <a-avatar size="large" :src="user.avatar_url" v-if="user.avatar_url"/>
                            <a-avatar size="large" icon="user" v-else/>
                            <span class="ml1">
                            {{ user.name }} <a-icon type="down"/>
                        </span>
                        </div>
                        <a-menu slot="overlay">
                            <a-menu-item key="0">
                                <router-link :to="{ name: 'user.profile' }">My Profile</router-link>
                            </a-menu-item>
                            <a-menu-divider/>
                            <a-menu-item key="1" @click="logout">
                                Logout
                            </a-menu-item>
                        </a-menu>
                    </a-dropdown>
                </a-col>
            </a-row>
        </a-layout-header>
    </a-layout>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                user: {}
            }
        }
    }
</script>

<style scoped>
</style>
