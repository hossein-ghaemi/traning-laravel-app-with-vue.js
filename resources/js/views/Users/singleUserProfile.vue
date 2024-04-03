<template>
    <VCard>
        <VCardTitle class="text-2xl font-weight-bold">
            {{ this.response.name }}
        </VCardTitle>
        <VRow class="pa-6">
            <VCol cols="6">
                <VTextField
                    v-model="this.response.name"
                    autofocus
                    :value="this.response.name"
                    label="Name"
                    type="text"
                />
            </VCol>
            <VCol cols="6">
                <VTextField
                    v-model="this.response.email"
                    autofocus
                    :value="this.response.email"
                    label="Email"
                    type="text"
                />
            </VCol>
            <VCol cols="6">
                <VSelect
                    v-model="this.response.role"
                    autofocus
                    :items="this.roles"
                    item-value="id"
                    item-title="name"
                    multiple
                    label="Roles"
                    type="text"
                />
            </VCol>
        </VRow>
    </VCard>
</template>

<script>
import {useRoute} from "vue-router";
import axios from "axios";

const route = useRoute();

export default {
    name: "UsersList",
    data() {
        return {
            response: [],
            roles: [

            ]

        };
    },
    methods: {
        getUser() {
            axios.get('/api/administrator/users/' + this.$route.params.id)
                .then((response) => {
                    this.response = response.data.user;
                    console.log(this.response)
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getRoles() {
            axios.get('/api/administrator/roles/get' )
                .then((response) => {
                    response.data.roles.forEach(item=>

                    this.roles.push({'id':item.id,'name':item.name}))
                    this.roles = response.data.roles;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    created() {
        this.getUser();
        this.getRoles();
    },
};
</script>
