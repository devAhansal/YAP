<template>
    <navbar-client routeCurrentName="catalogue"/>
    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 flex justify-center items-center flex-wrap" >
        <card-catalogue />
        <card-catalogue />
        <card-catalogue />
      </div>
    </main>
  </template>
  
  <script setup>
  import NavbarClient from "../components/NavbarClient.vue";
  </script>
  