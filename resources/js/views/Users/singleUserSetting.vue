<template>
    <form @submit.prevent="submitForm">
        <VCard>
            <VAlert class="rounded-b-0" v-if="this.alert.message" :type="this.alert.type">{{ this.alert.message }}
            </VAlert>

            <VCardTitle class="text-2xl font-weight-bold">
                {{ this.response.name }}
            </VCardTitle>
            <VRow class="pa-6">
                <VCol cols="12">
                    <VImg class="" :src="this.imageUrl" width="200"/>
                    <br>
                    <VFileInput
                        v-model="selectedFile"
                        :label="'Upload Profile Picture'"
                        accept="image/*"
                        @change="onFileChanged"
                    />
                </VCol>
                <VCol cols="6">
                    <VTextField
                        v-model="this.response.id"
                        autofocus
                        :value="this.response.id"
                        label="ID"
                        disabled
                        readonly
                        type="rea"
                        hidden="hidden"
                    />
                </VCol>
                <VCol cols="6">
                    <VTextField
                        v-model="this.response.f_name"
                        autofocus
                        :value="this.response.f_name"
                        label="Last Name"
                        type="text"
                    />
                </VCol>
                <VCol cols="6">
                    <VTextField
                        v-model="this.response.l_name"
                        autofocus
                        :value="this.response.l_name"
                        label="Last Name"
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
                    <VTextField
                        v-model="this.response.phone_number"
                        autofocus
                        :value="this.response.phone_number"
                        label="Phone Number"
                        type="text"
                    />
                </VCol>
                <VCol cols="6">
                    <VSelect
                        v-model="this.selectedRole"
                        autofocus
                        :items="this.roles"
                        item-value="id"
                        item-title="name"
                        label="Roles"
                        type="text"
                    />
                </VCol>

            </VRow>
            <VCardActions class="float-end">
                <VBtn type="submit" color="primary">Save</VBtn>
            </VCardActions>
        </VCard>
    </form>
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
            roles: [],
            selectedRole: '',
            selectedFile: null,
            imageUrl: '',
            alert: {message: '', type: ''}
        };
    },
    methods: {
        getUser() {
            axios.get('/api/administrator/users/' + this.$route.params.id)
                .then((response) => {
                    this.response = response.data.user;
                    if (this.response.profile.file_path !== '') {
                        this.imageUrl = window.location.origin+'/' + this.response.profile.file_path;
                        console.log(this.imageUrl)
                    }
                    this.selectedRole = response.data.user.role_id;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getRoles() {
            axios.get('/api/administrator/roles')
                .then((response) => {
                    response.data.roles.forEach(item =>
                        this.roles.push({'id': item.id, 'name': item.name}))
                    this.roles = response.data.roles;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm() {
            const formData = new FormData();
            formData.append('profile_picture', this.selectedFile);
            formData.append('f_name', this.response.f_name);
            formData.append('l_name', this.response.l_name);
            formData.append('email', this.response.email);
            formData.append('phone_number', this.response.phone_number);
            formData.append('id', this.response.id);
            formData.append('role_id', this.selectedRole);

            axios.post('/api/administrator/users/update-profile/' + this.$route.params.id, formData)
                .then((response) => {
                    this.alert = {message: response.data.message, type: 'success'};
                    this.getUser()
                })
                .catch(error => {
                    const errorMessage = error.response?.data?.error || 'Error uploading profile picture!';
                    this.alert = {message: errorMessage, type: 'error'};
                });
        },
        onFileChanged(event) {

            const file = event.target.files[0];
            if (file) {
                this.imageUrl = URL.createObjectURL(file);
                this.selectedFile = file;
            }
        }
    },
    created() {
        this.getUser();
        this.getRoles();
    },
};
</script>
