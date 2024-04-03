<script setup>
import {useRoute} from 'vue-router'
import User from '../views/Users/singleUserProfile.vue'
const route = useRoute()
const activeTab = ref(route.params.tab)
console.log(User)
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
  fasdfasdfas
</template>
