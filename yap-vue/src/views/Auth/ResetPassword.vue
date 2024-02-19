<script setup>
import { useAuthStore } from "../stores/auth";
import { ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const authStore = useAuthStore();

const form = ref({
  password: "",
  password_confirmation: "",
  email: route.query.email,
  token: route.params.token,
});

</script>
<template>
  <div
    class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8"
  >
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <router-link :to="{ name: 'home' }">
        <img
          class="mx-auto h-20 w-auto"
          src="/public/images/logo.ico"
          alt="Votre entreprise"
        />
      </router-link>
      <h2
        class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
      >
        Réinitialisation du mot de passe
      </h2>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form
        class="space-y-6"
        @submit.prevent="authStore.handleResetPassword(form)"
      >
      <div>
          <label
            for="password"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Nouveau Mot de passe</label
          >
          <div class="mt-2">
            <input
              id="password"
              v-model="form.password"
              name="password"
              type="password"
              autocomplete="new-password"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <label
            for="confirmPassword"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Confirmer le mot de passe</label
          >
          <div class="mt-2">
            <input
              id="confirmPassword"
              v-model="form.password_confirmation"
              name="confirmPassword"
              type="password"
              autocomplete="new-password"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>
        <div>
          <button
            type="submit"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            Réinitialiser le mot de passe
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Retour à la
        <router-link
          :to="{ name: 'login' }"
          class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
          >page de connexion</router-link
        >
      </p>
    </div>
  </div>
</template>
