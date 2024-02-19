<template>
  <navbar-client routeCurrentName="propos" />
  <main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 flex justify-center items-center flex-wrap">
      <div class="mb-8 ml-4 w-full max-w-1/2 bg-white border border-gray-200 rounded-lg shadow white:bg-gray-800 white:border-gray-700 h-[30%]">
        <a href="#">
          <img
            class="p-8 rounded-t-lg" style="height: 600px;width: 100%;" 
            src="/public/images/cute-little-dog-pet-shop-with-owner.jpg"
            alt="product image"
          />
        </a>
        <div class="px-5 pb-5">
          <a href="#">
            <h5
              class="text-xl font-semibold tracking-tight text-gray-500 dark:text-dark"
            >
            Chez YAP, notre mission est d'apporter joie, bonheur et responsabilité dans chaque foyer en connectant les amoureux des animaux avec des compagnons fidèles. Nous nous engageons à offrir une expérience d'adoption transparente et éthique, mettant en avant le bien-être des animaux.
            </h5>
            <h5
              class="text-xl font-semibold tracking-tight text-gray-500 dark:text-dark"
            >
            Nous nous efforçons de garantir le bien-être de chaque animal que nous proposons à l'adoption. Chaque compagnon de YAP est traité avec amour, respect et reçoit des soins de qualité.            </h5>
            <h5
              class="text-xl font-semibold tracking-tight text-gray-500 dark:text-dark"
            >
            Notre vision est de devenir la référence en matière d'adoption d'animaux en ligne, en créant des foyers heureux et épanouis où les humains et les animaux partagent des liens indéfectibles.            </h5>
          </a>

          <div class="flex items-center justify-between"></div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import NavbarClient from "../components/NavbarClient.vue";
</script>
