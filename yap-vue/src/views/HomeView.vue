<script setup>
import NavbarHome from "../components/NavbarHome.vue";
import Pet from "../components/Pet.vue";
import { onMounted } from "vue";
import { useAuthStore } from "./stores/auth";

const authStore = useAuthStore();

onMounted(async () => {
  await authStore.getUser();
});
</script>

<template>
  <main>
    <div v-if="authStore.user"></div>
    <navbar-home />
    <pet />
  </main>
</template>
