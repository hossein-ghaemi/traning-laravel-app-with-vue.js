<template>

</template>

<script>
import axios from "axios";

console.log(window.location.href)
export default {
    name: "UsersList",
    data() {
        return {
            response: [],
        };
    },
    methods: {
        getUsers() {
            axios.get('/api/administrator/users')
                .then((response) => {
                    this.response = response.data.users;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    created() {
        this.getUsers();
    },
};
</script>
