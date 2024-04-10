<script setup>
import {useRoute} from 'vue-router'
import Roles from '../../../views/Roles/allRolesList.vue'
const route = useRoute()
const activeTab = ref(route.params.tab)

// tabs
const tabs = [
    {
        title: 'All',
        icon: 'bx-user',
        tab: 'account',
    },
    {
        title: 'Role 1',
        icon: 'bx-lock-open',
        tab: 'security',
    },
    {
        title: 'Role 2',
        icon: 'bx-bell',
        tab: 'notification',
    },
]
</script>
<template>
    <div>
        <VTabs
            v-model="activeTab"
            show-arrows
        >
            <VTab
                v-for="item in tabs"
                :key="item.icon"
                :value="item.tab"
            >
                <VIcon
                    size="20"
                    start
                    :icon="item.icon"
                />
                {{ item.title }}
            </VTab>
        </VTabs>
        <VDivider/>

        <VWindow
            v-model="activeTab"
            class="mt-5 disable-tab-transition"
        >
            <!-- Account -->
            <VWindowItem value="account">
                <Roles/>
            </VWindowItem>

            <!-- Security -->
            <VWindowItem value="security">
                <AccountSettingsSecurity/>
            </VWindowItem>

            <!-- Notification -->
            <VWindowItem value="notification">
                <AccountSettingsNotification/>
            </VWindowItem>
        </VWindow>
    </div>
</template>
