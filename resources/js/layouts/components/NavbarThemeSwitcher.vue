<script setup>
const themes = [
  {
    name: 'light',
    icon: 'bx-sun',
  },
  {
    name: 'dark',
    icon: 'bx-moon',
  },
]
</script>

<template>
  <ThemeSwitcher :themes="themes" />
</template>
<!--store theme in user profile info-->
<script>
import axios from "axios";
import {useRouter} from 'vue-router';

const alert = ref({message: '', type: ''});
const isPasswordVisible = ref(false);
const router = useRouter();
export default {
    data() {
        return {
            email: '',
            password: '',
            remember: false,
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/auth/login', {
                    email: this.email,
                    password: this.password,
                    remember: false,
                });
                localStorage.setItem('token', response.data.token);
                alert.value = {message: 'Login successful', type: 'success'};
                this.$router.push('/');
            } catch (error) {
                console.error('Login error:', error);
                const errorMessage = error.response?.data?.message || 'An error occurred during login.';
                alert.value = {message: errorMessage, type: 'error'};
            }
        },
    },

};
</script>
