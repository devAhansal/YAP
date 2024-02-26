<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";
import { useAuthStore } from "../stores/auth";
const toast = useToast();
const authStore = useAuthStore();
const router = useRouter();

onMounted(() => {
  getCommandes();
});

const Commandes = ref();

const getCommandes = async () => {
  try {
    const response = await axios.get("api/commandes");
    Commandes.value = response.data;
  } catch (error) {
    console.error(
      "Erreur lors de la récupération des détails de l'animal:",
      error
    );
  }
};

const form = ref({
  Partenaire: "",
});

const handleAssignerPartenaire = async () => {
  const formData = new FormData();
  // Set the selected Partenaire ID in the FormData
  formData.append('partenaire_id', form.Partenaire);
  
  await axios
    .post("api/partenaires", formData)
    .then((response) => {
      toast.add({
        severity: "success",
        summary: response.data.message,
        detail: response.data.message,
        life: 5000,
      });
      resetForm();
      getPartenaires();
    })
    .catch((error) => {
      if (error.response.data.errors) {
        const errors = error.response.data.errors;
        Object.values(errors).forEach((error) => {
          toast.add({
            severity: "error",
            summary: "Erreur de validation",
            detail: error[0],
            life: 5000,
          });
        });
      }
    });
};


const Partenaires = ref([]);

const getPartenaires = async () => {
  try {
    const response = await axios.get("api/partenaires");
    Partenaires.value = response.data;
  } catch (error) {
    console.error(
      "Erreur lors de la récupération des détails de les partanires:",
      error
    );
  }
};

onMounted(async () => {
  await authStore.getUser();
  if (authStore.user && authStore.user !== null) {
    if (authStore.user.type === "admin") {
      router.push("/dashboard/commandes");
    } else {
      router.push("/catalogue");
    }
  }
  await getPartenaires();
});
</script>

<template>
  <div class="min-h-full">
    <navbar-admin routeCurrentName="dashboardCommandes" />

    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          Commandes
        </h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <main>
          <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="card">
              <TabView>
                <TabPanel header="Gérer Commandes">
                  <div class="card">
                    <DataTable
                      :value="Commandes"
                      paginator
                      :rows="5"
                      tableStyle="min-width: 50rem"
                    >
                      <template #header>
                        <div
                          class="flex flex-wrap align-items-center justify-content-between gap-2"
                        >
                          <!-- Header content -->
                        </div>
                      </template>

                      <Column field="NumCommande" header="Numéro de commande">
                        <template #body="slotProps">
                          <router-link
                            :to="{
                              name: 'dashboardCommandesDetails',
                              params: { idCommande: slotProps.data.id },
                            }"
                            class="-m-2 block p-2 font-medium text-blue-900"
                          >
                            {{ slotProps.data.NumCommande }}
                          </router-link>
                        </template>
                      </Column>
                      <Column field="status" header="Statut de paiement">
                        <template #body="slotProps">
                          <span
                            :style="{
                              color:
                                slotProps.data.status === 'paye'
                                  ? 'green'
                                  : 'red',
                            }"
                          >
                            {{
                              slotProps.data.status === "paye"
                                ? "Payé"
                                : "Non payé"
                            }}
                          </span>
                        </template>
                      </Column>

                      <Column field="livrée" header="Statut de livraison">
                        <template #body="slotProps">
                          <span
                            :style="{
                              color:
                                slotProps.data.livrée === 'oui'
                                  ? 'green'
                                  : 'red',
                            }"
                          >
                            {{
                              slotProps.data.livrée === "oui"
                                ? "Livré"
                                : "Non livré"
                            }}
                          </span>
                        </template>
                      </Column>

                      <!-- <Column field="prix_animal" header="Prix">
                        <template #body="slotProps">
                          {{ slotProps.data.prix_animal }} MAD
                        </template>
                      </Column> -->
                      <Column field="Actions" header="Actions">
                        <template #body="slotProps">
                          <center>
                            <i
                              title="Supprimer Animal"
                              style="font-size: 20px"
                              class="pi pi-trash text-red-500 cursor-pointer text-lg"
                              @click="confirmDelete(slotProps.data)"
                            ></i>
                          </center>
                        </template>
                      </Column>
                      <!-- Ajoutez d'autres colonnes selon vos besoins -->

                      <template #footer>
                        Au total il y a
                        {{ Commandes ? Commandes.length : 0 }} Commandes.
                      </template>
                    </DataTable>
                  </div>
                </TabPanel>
                <TabPanel header="Assigner un partenaire">
                  <div class="card">
                    <form @submit.prevent="handleAssignerPartenaire">
                      <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">
                          <h2
                            class="text-base font-semibold leading-7 text-gray-900"
                          >
                            Assigner un partenaire
                          </h2>

                          <div
                            class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                          >
                            <div class="sm:col-span-2">
                              <label
                                for="region"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Partenaire de livraison</label
                              >
                              <div class="mt-2">
                                <select
                                  id="Partenaire"
                                  name="Partenaire"
                                  v-model="form.Partenaire"
                                  autocomplete="Partenaire"
                                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:max-w-xs sm:text-sm sm:leading-6"
                                >
                                  <option
                                    v-for="partenaire in Partenaires"
                                    :key="partenaire.id"
                                    :value="partenaire.id"
                                  >
                                    {{ partenaire.name }}
                                  </option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button
                          type="submit"
                          class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                        >
                        Assigner 
                        </button>
                      </div>
                    </form>
                  </div>
                </TabPanel>
              </TabView>
            </div>
          </div>
        </main>
      </div>
    </main>
  </div>
</template>
