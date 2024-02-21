<template>
  <div class="flex min-h-full flex-1 flex-col justify-center">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <router-link :to="{ name: 'home' }">
        <img
          class="mx-auto h-20 w-auto"
          src="/public/images/logo.ico"
          alt="Votre entreprise"
        />
      </router-link>
      <h2
        class="mt-2 text-center text-2xl font-bold leading-6 tracking-tight text-gray-900"
      >
        Créez un compte
      </h2>
    </div>
    <div class="mt-2 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="handleRegister">
        <div>
          <label
            for="name"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Nom</label
          >
          <div class="mt-2">
            <input
              id="name"
              v-model="form.name"
              name="name"
              type="text"
              required
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>
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
          <label
            for="password"
            class="block text-sm font-medium leading-6 text-gray-900"
            >Mot de passe</label
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
              v-model="form.confirmPassword"
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
            S'inscrire
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Déjà membre ?
        <router-link
          :to="{ name: 'login' }"
          class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
          >Connectez-vous</router-link
        >
      </p>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from "../stores/auth";
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";

const router = useRouter();
const toast = useToast();
const form = ref({
  name: "",
  email: "",
  password: "",
  confirmPassword: "",
});

// const handleRegister = async () => {
//   await axios.get("/sanctum/csrf-cookie");
//   await axios.post("api/register", {
//     name: form.value.name,
//     email: form.value.email,
//     password: form.value.password,
//     confirmPassword: form.value.confirmPassword,
//   });
//   router.push("/dashboard");
// };

const handleRegister = async () => {
  try {
    await axios.get("/sanctum/csrf-cookie");
    const response = await axios.post("api/register", {
      name: form.value.name,
      email: form.value.email,
      password: form.value.password,
      password_confirmation: form.value.confirmPassword,
    });

    // Affichage du toast de succès
    toast.add({
      severity: "success",
      summary: "Succès",
      detail: "L'inscription a été effectuée avec succès.",
      life: 3000,
    });

    // Redirection vers le tableau de bord
    router.push("/catalogue");
  } catch (error) {
    if (
      error.response.data.message.includes("The email has already been taken")
    ) {
      // Ajoutez un toast pour indiquer que l'e-mail est déjà pris
      toast.add({
        severity: "error",
        summary: "Erreur",
        detail: "Cet e-mail est déjà associé à un compte.",
        life: 3000,
      });
    } else {
      // Affichage du toast d'erreur
      toast.add({
        severity: "error",
        summary: "Erreur",
        detail: "Erreur de mot de passe",
        life: 3000,
      });
    }
  }
};

const authStore = useAuthStore();
onMounted(async () => {
  await authStore.getUser();
  if (authStore.user && authStore.user !== null) {
    if (authStore.user.type === "admin") {
      router.push("/dashboard");
    } else {
      router.push("/catalogue");
    }
  }
});
</script>
