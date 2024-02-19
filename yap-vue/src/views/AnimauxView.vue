<template>
  <navbar-client routeCurrentName="catalogue" />
  <main>
    <div
      class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 flex justify-center items-center flex-wrap"
    >
      <div class="card">
        <DataView :value="Animaux" paginator :rows="5" :layout="layout">
          <template #header>
            
          </template>

          <!-- <template #list="slotProps">
            <div class="flex flex-wrap">
              <div
                v-for="(item, index) in slotProps.items"
                :key="index"
                class="w-full p-3"
              >
                <div
                  class="flex flex-col xl:flex-row xl:items-start p-4 gap-4"
                  :class="{
                    'border-t border-surface-200 dark:border-surface-700':
                      index !== 0,
                  }"
                >
                  <img
                    class="w-9/12 sm:w-[16rem] xl:w-[10rem] shadow-md block xl:block mx-auto rounded"
                    :src="`http://localhost:8000/uploads/${item.image_animal}`"
                    :alt="item.nom_animal"
                  
                  />
                  <div
                    class="flex flex-col sm:flex-row justify-between items-center xl:items-start flex-1 gap-4"
                  >
                    <div
                      class="flex flex-col items-center sm:items-start gap-3"
                    >
                      <div
                        class="text-2xl font-bold text-surface-900 dark:text-surface-0"
                      >
                        {{ item.nom_animal }}
                      </div>
                    
                      <div class="flex items-center gap-3">
                        <span class="flex items-center gap-2">
                          <i class="pi pi-tag"></i>
                          <span class="font-semibold">{{ item.type_animal }}</span>
                        </span>
                     
                      </div>
                    </div>
                    <div
                      class="flex sm:flex-col items-center sm:items-end gap-3 sm:gap-2"
                    >
                      <span class="text-2xl font-semibold"
                        >${{ item.prix_animal }}</span
                      >
                      <Button
                        icon="pi pi-shopping-cart"
                        rounded
                        :disabled="item.inventoryStatus === 'OUTOFSTOCK'"
                      ></Button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template> -->

          <template #grid="slotProps">
            <div class="flex flex-wrap">
              <div
                v-for="(item, index) in slotProps.items"
                :key="index"
                class="w-full p-3 sm:w-6/12 xl:w-4/12"
              >
                <div
                  class="p-4 border border-surface-200 dark:border-surface-700 bg-surface-0 dark:bg-surface-800 rounded"
                >
                  <div
                    class="flex flex-wrap items-center justify-between gap-2"
                  >
                    <div class="flex items-center gap-2">
                      <i class="pi pi-tag"></i>
                      <span class="font-semibold">{{ item.type_animal }}</span>
                    </div>
                   
                  </div>
                  <div class="flex flex-col items-center gap-3 py-5">
                    <img
                      class="w-9/12 shadow-md rounded animal-image"
                      :src="`http://localhost:8000/uploads/${item.image_animal}`"
                      :alt="item.nom_animal"
                    />
                    <div class="text-2xl font-bold">{{ item.nom_animal }}</div>
                   
                  </div>
                  <div class="flex items-center justify-between">
                    <span class="text-2xl font-semibold"
                      >{{ item.prix_animal }} MAD</span
                    >
                    <Button
                      icon="pi pi-shopping-cart"
                      rounded
                      :disabled="item.inventoryStatus === 'EN RUPTURE DE STOCK'"
                    ></Button>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </DataView>
      </div>
    </div>
  </main>
</template>

<script setup>
// import CardBuy from "../components/CardBuy.vue";
import NavbarClient from "../components/NavbarClient.vue";
import { ref, onMounted } from "vue";
import { ProductService } from "@/service/ProductService";
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions'   // optional

import axios from "axios";
onMounted(() => {
  ProductService.getProducts().then((data) => (products.value = data));
  getAnimals();
});

const Animaux = ref();

const getAnimals = async () => {
  try {
    const response = await axios.get("api/animal");
    Animaux.value = response.data;
  } catch (error) {
    console.error(
      "Erreur lors de la récupération des détails de l'animal:",
      error
    );
  }
};

const products = ref();
const layout = ref("grid");

const getSeverity = (product) => {
  switch (product.inventoryStatus) {
    case "EN STOCK":
      return "success";
    case "EN RUPTURE DE STOCK":
      return "danger";
    default:
      return null;
  }
};
</script>
<style>
.animal-image {
  width: 400px; /* Set width to 100% to fill the container */
  height: auto; /* Let the height adjust proportionally */
  height: 200px; /* Adjust the maximum height as needed */
}
</style>