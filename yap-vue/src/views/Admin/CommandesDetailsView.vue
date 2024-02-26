<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import { useToast } from "primevue/usetoast";
import { useAuthStore } from "../stores/auth";
const toast = useToast();
const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();

const idCommande = ref(null); // Define a ref to store the idCommande value
const Animaux = ref();
const CountAnimaux = ref();
const TotalPriceAnimaux = ref();
onMounted(async () => {
  await authStore.getUser();
  if (authStore.user && authStore.user !== null) {
    if (authStore.user.type != "admin") {
      router.push("/catalogue");
    }
  }

  idCommande.value = route.params.idCommande;
  
  const response = await axios.post("/api/paniers/" + idCommande.value);
  Animaux.value = response.data.animals;
  TotalPriceAnimaux.value = response.data.totalPrice;
  CountAnimaux.value = response.data.totalAnimals;
  

});
</script>

<template>
  <div class="min-h-full">
    <navbar-admin routeCurrentName="dashboardCommandes" />

    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          Details Commandes
        </h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <main>
          <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
             <div class="card">
              <DataTable
                :value="Animaux"
                paginator
                :rows="5"
                tableStyle="min-width: 50rem"
              >
                <template #header>
                  <div
                    class="flex flex-wrap align-items-center justify-content-between gap-2"
                  >
                  </div>
                </template>

                <Column field="nom_animal" header="Nom">
                  <template #body="slotProps">
                    {{ slotProps.data.nom_animal }}
                  </template>
                </Column>
                <Column field="type_animal" header="Type">
                  <template #body="slotProps">
                    {{ slotProps.data.type_animal }}
                  </template>
                </Column>
                <Column field="couleur_animal" header="Couleur">
                  <template #body="slotProps">
                    <ColorPicker
                      v-model="slotProps.data.couleur_animal"
                      disabled
                    />
                  </template>
                </Column>
                <Column field="image_animal" header="Image">
                  <template #body="slotProps">
                    <img
                      :src="`http://localhost:8000/uploads/${slotProps.data.image_animal}`"
                      :alt="slotProps.data.nom_animal"
                      class="w-12 border-round"
                    />
                  </template>
                </Column>
                <Column
                  field="date_de_naissance_animal"
                  header="Date de Naissance"
                >
                  <template #body="slotProps">
                    {{ slotProps.data.date_de_naissance_animal }}
                  </template>
                </Column>
                <Column field="prix_animal" header="Prix">
                  <template #body="slotProps">
                    {{ slotProps.data.prix_animal }} MAD
                  </template>
                </Column>
              
                <template #footer>
                  <div class="flex justify-between items-center">
                    <div>
                      Au total il y a
                      {{ CountAnimaux }}
                       Animaux.
                    </div>
                    <div>
                      Prix Total {{ TotalPriceAnimaux }} MAD.
                    </div>
                  </div>
                </template>
              </DataTable>
            </div>
          </div>
        </main>
      </div>
    </main>
  </div>
</template>
