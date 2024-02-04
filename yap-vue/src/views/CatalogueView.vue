<template>
    <navbar-detail routeCurrentName="catalogue"/>
    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 flex justify-center items-center flex-wrap" >
        <card-catalogue />
        <card-catalogue />
        <card-catalogue />
      </div>
    </main>
  </template>
  
  <script setup>
  import CardBuy from "../components/CardBuy.vue";
  import NavbarDetail from "../components/NavbarDetail.vue";
  </script>
  