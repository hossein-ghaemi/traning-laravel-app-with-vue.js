<template>
    <VRow v-if="response">
        <VCol cols="12">
            <VCard>
                <VTable class="text-no-wrap text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in response" :key="user.id">
                        <td class="w-0">{{ user.id }}</td>
                        <td>{{ user.f_name }} {{ user.l_name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role.name }}</td>
                        <td>
                            <router-link :to="{ name: 'user.profile', params: { id: user.id } }">
                                <VBtn>Edit</VBtn>
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </VTable>
            </VCard>
        </VCol>
    </VRow>
</template>

<script>

import axios from "axios";

export default {
    name: "UsersList",
    data() {
        return {
            response: [],
        };
    },
    methods: {
        getUsers() {
            axios.get('/api/administrator/users/get')
                .then((response) => {
                    this.response = response.data.users;
                })
                .catch((error) => {
                    this.response = 'error';
                    console.error(error);
                });
        },
    },
    created() {
        this.getUsers();
    },
};
</script>
