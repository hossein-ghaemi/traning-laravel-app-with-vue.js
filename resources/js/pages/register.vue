<script setup>
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue'
import logo from '@images/logo.svg?raw'

const form = ref({
  username: '',
  email: '',
  password: '',
  privacyPolicies: false,
})

const isPasswordVisible = ref(false)
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard
      class="auth-card pa-4 pt-7"
      max-width="448"
    >
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="d-flex">
            <div
              class="d-flex text-primary"
              v-html="logo"
            />
          </div>
        </template>

        <VCardTitle class="text-2xl font-weight-bold">
          sneat
        </VCardTitle>
      </VCardItem>

      <VCardText class="pt-2">
        <h5 class="text-h5 mb-1">
          Adventure starts here 🚀
        </h5>
        <p class="mb-0">
          Make your app management easy and fun!
        </p>
      </VCardText>
        <VAlert v-if="alert.message" :type="alert.type">{{ alert.message }}</VAlert>
      <VCardText>
        <VForm @submit.prevent="register()">
          <VRow>

            <!-- email -->
            <VCol cols="12">
              <VTextField
                v-model="email"
                label="Email"
                placeholder="johndoe@email.com"
                type="email"
              />
            </VCol>


            <!-- password -->
            <VCol cols="12">
              <VTextField
                v-model="password"
                label="Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
              />
              <VTextField
                  class="mt-4"
                v-model="password_confirmation"
                label="Password"
                placeholder="············"
                :type="isPasswordVisible_confirmation ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible_confirmation ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible_confirmation = !isPasswordVisible_confirmation"
              />


              <div class="d-flex align-center mt-1 mb-4">
                <VCheckbox
                  id="privacy-policy"
                  v-model="form.privacyPolicies"
                  inline
                />
                <VLabel
                  for="privacy-policy"
                  style="opacity: 1;"
                >
                  <span class="me-1">I agree to</span>
                  <a
                    href="javascript:void(0)"
                    class="text-primary"
                  >privacy policy & terms</a>
                </VLabel>
              </div>

              <VBtn
                block
                type="submit"
              >
                Sign up
              </VBtn>
            </VCol>

            <!-- login instead -->
            <VCol
              cols="12"
              class="text-center text-base"
            >
              <span>Already have an account?</span>
              <RouterLink
                class="text-primary ms-2"
                to="/login"
              >
                Sign in instead
              </RouterLink>
            </VCol>

            <VCol
              cols="12"
              class="d-flex align-center"
            >
              <VDivider />
              <span class="mx-4">or</span>
              <VDivider />
            </VCol>

            <!-- auth providers -->
            <VCol
              cols="12"
              class="text-center"
            >
              <AuthProvider />
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </div>
</template>
<script>
import axios from "axios";
import {useRouter} from 'vue-router';

const alert = ref({message: '', type: ''});
const isPasswordVisible = ref(false);
const isPasswordVisible_confirmation = ref(false);
const router = useRouter();
export default {
    data() {
        return {
            email: '',
            password: '',
            password_confirmation: '',
        };
    },
    methods: {
        async register() {


            if (this.password !== this.password_confirmation){
                alert.value = {message: 'The password and confirmation are not the same.', type: 'error'};
                return;
            }


            try {
                const response = await axios.post('/api/register', {
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });
                localStorage.setItem('token', response.data.token);
                alert.value = {message: 'Register successful', type: 'success'};
                this.$router.push('/dashboard');
            } catch (error) {
                const errorMessage = error.response?.data?.message || 'An error occurred during login.';
                alert.value = {message: errorMessage, type: 'error'};
            }
        },
    },

};
</script>
<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>
