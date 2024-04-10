<template>
    <VRow>
        <VCol cols="12">
            <VCard>
                <VTable class="text-no-wrap text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Nick Name</th>
                        <th>Status</th>
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="role in response" :key="role.id">
                        <td class="w-0">{{ role.id }}</td>
                        <td>{{ role.name }}</td>
                        <td>{{ role.nick_name }}</td>
                        <td><v-btn icon="" variant="text">

                        </v-btn></td>
                        <td>
                            <router-link :to="{ name: 'role.setting', params: { id: role.id } }"><VBtn>Edit</VBtn></router-link>
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
        getRoles() {
            axios.get('/api/administrator/roles')
                .then((response) => {
                    console.log(response)
                    this.response = response.data.roles;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    created() {
        this.getRoles();
    },
};
</script>
