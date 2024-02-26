<script setup>
import { useAuthStore } from "../stores/auth";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";

const toast = useToast();
const authStore = useAuthStore();

const router = useRouter(); // Initialisez le router
const form = ref({
  email: "",
  password: "",
});

onMounted(async () => {
  await authStore.getUser();
  if (authStore.user && authStore.user !== null) {
    if (authStore.user.type === "admin") {
      router.push("/dashboard/animaux");
    } else {
      router.push("/catalogue");
    }
  }
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
        Connectez-vous à votre compte
      </h2>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="authStore.handleLogin(form)">
        <div>
          <label
            for="email"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Adresse e-mail</label
          >
          <div class="mt-2">
            <input
              id="email"
              v-model="form.email"
              name="email"
              type="email"
              autocomplete="email"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label
              for="password"
              class="block text-sm font-medium leading-6 text-gray-900"
              >Mot de passe</label
            >
            <div class="text-sm">
              <router-link
                :to="{ name: 'forgotpassword' }"
                class="font-semibold text-indigo-600 hover:text-indigo-500"
                >Mot de passe oublié ?</router-link
              >
            </div>
          </div>
          <div class="mt-2">
            <input
              id="password"
              v-model="form.password"
              name="password"
              type="password"
              autocomplete="current-password"
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
            Se connecter
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Pas encore membre ?
        {{ " " }}
        <router-link
          :to="{ name: 'register' }"
          class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
          >Inscrivez-vous
        </router-link>
      </p>
    </div>
  </div>
</template>
