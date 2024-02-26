<template>
  <div class="min-h-full">
    <navbar-admin routeCurrentName="dashboardPartenaires" />

    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          Partenaires
        </h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="card">
          <TabView>
            <TabPanel header="Gérer Partenaires">
              <div class="card">
                <DataTable
                  :value="Partenaires"
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

                  <Column field="name" header="Nom">
                    <template #body="slotProps">
                      {{ slotProps.data.name }}
                    </template>
                  </Column>
                  <Column field="email" header="E-mail">
                    <template #body="slotProps">
                      {{ slotProps.data.email }}
                    </template>
                  </Column>
                  <Column field="password_exact" header="Mot de passe">
                    <template #body="slotProps">
                      {{ slotProps.data.password_exact }}
                    </template>
                  </Column>
                  <Column field="carte_identite" header="Carte d'identité">
                    <template #body="slotProps">
                      {{ slotProps.data.carte_identite }}
                    </template>
                  </Column>
                  <Column field="date_de_naissance" header="Date de Naissance">
                    <template #body="slotProps">
                      {{ slotProps.data.date_de_naissance }}
                    </template>
                  </Column>
                  <Column field="statu" header="Status">
                    <template #body="slotProps">
                      {{ slotProps.data.statu }}
                    </template>
                  </Column>
                  <Column field="phone" header="Numéro de téléphone">
                    <template #body="slotProps">
                      {{ slotProps.data.phone }}
                    </template>
                  </Column>
                  <!-- Ajoutez d'autres colonnes selon vos besoins -->

                  <template #footer>
                    Totalement on a
                    {{ Partenaires ? Partenaires.length : 0 }} Partenaires.
                  </template>
                </DataTable>
              </div>
            </TabPanel>
            <TabPanel header="Ajouter Partenaires">
              <form @submit.prevent="handleAjouterPartenaire">
                <div class="space-y-12">
                  <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">
                      Informations sur Partenaire
                    </h2>

                    <div
                      class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                    >
                      <div class="sm:col-span-3">
                        <label
                          for="name"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Nom</label
                        >
                        <div class="mt-2">
                          <input
                            type="text"
                            name="name"
                            v-model="form.name"
                            id="name"
                            autocomplete="name"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                          />
                        </div>
                      </div>

                      <div class="sm:col-span-3">
                        <label
                          for="date_de_naissance"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Date de naissance</label
                        >
                        <div class="mt-2">
                          <input
                            v-model="form.date_de_naissance"
                            id="date_de_naissance"
                            name="date_de_naissance"
                            type="date"
                            autocomplete="date_de_naissance"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                          />
                        </div>
                      </div>
                      <div class="sm:col-span-3">
                        <label
                          for="carte_identite"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Carte d'identité</label
                        >
                        <div class="mt-2">
                          <input
                            type="text"
                            name="carte_identite"
                            v-model="form.carte_identite"
                            id="carte_identite"
                            autocomplete="carte_identite"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                          />
                        </div>
                      </div>

                      <div class="sm:col-span-3">
                        <label
                          for="address"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Adresse personnel</label
                        >
                        <div class="mt-2">
                          <input
                            type="text"
                            name="address"
                            v-model="form.address"
                            id="address"
                            autocomplete="address"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                          />
                        </div>
                      </div>
                      <div class="sm:col-span-3">
                        <label
                          for="phone"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Numéro de téléphone</label
                        >
                        <div class="mt-2">
                          <input
                            type="number"
                            name="phone"
                            v-model="form.phone"
                            id="phone"
                            autocomplete="phone"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                          />
                        </div>
                      </div>

                      <div class="sm:col-span-2">
                        <label
                          for="region"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Région</label
                        >
                        <div class="mt-2">
                          <select
                            id="region"
                            name="region"
                            v-model="form.region"
                            autocomplete="region"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:max-w-xs sm:text-sm sm:leading-6"
                          >
                            <option>Tanger - Tétouan - Al Hoceima</option>
                            <option>Fès - Meknès</option>
                            <option>Rabat - Salé - Kénitra</option>
                            <option>Beni Mellal - Khénifra</option>
                            <option>Casablanca - Settat</option>
                            <option>Marrakech - Safi</option>
                            <option>Drâa - Tafilale</option>
                            <option>Souss - Massa</option>
                            <option>Guelmim - Oued Noun</option>
                            <option>Laâyoune - Saguia al Hamra</option>
                            <option>Dakhla - Oued Ed-Dahab</option>
                          </select>
                        </div>
                      </div>
                      <div class="sm:col-span-1">
                        <label
                          for="statu"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Statu</label
                        >
                        <div
                          class="card flex flex-wrap justify-content-center gap-3"
                        >
                          <InputSwitch
                            v-model="form.statu"
                            id="statu"
                            name="statu"
                          />
                        </div>
                      </div>
                      <div class="sm:col-span-3">
                        <label
                          for="email"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >E-mail</label
                        >
                        <div class="mt-2">
                          <input
                            type="email"
                            name="email"
                            v-model="form.email"
                            id="email"
                            autocomplete="email"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                          />
                        </div>
                      </div>
                      <div class="sm:col-span-3">
                        <label
                          for="password"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Mot de passe</label
                        >
                        <div class="mt-2">
                          <input
                            type="text"
                            name="password"
                            v-model="form.password"
                            id="password"
                            autocomplete="password"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                  <button
                    @click="resetForm"
                    type="button"
                    class="text-sm font-semibold leading-6 text-gray-900"
                  >
                    Annuler
                  </button>
                  <button
                    type="submit"
                    class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                  >
                    Enregistrer
                  </button>
                </div>
              </form>
            </TabPanel>
          </TabView>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";
import { useAuthStore } from "../stores/auth";

const toast = useToast();
const router = useRouter();
const authStore = useAuthStore();

onMounted(() => {
  getPartenaires();
});
const form = ref({
  name: "",
  date_de_naissance: "",
  carte_identite: "",
  address: "",
  phone: "",
  region: "",
  statu: true,
  email: "",
  password: "",
});

const Partenaires = ref();

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

const handleAjouterPartenaire = async () => {
  const formData = new FormData();
  formData.append("name", String(form.value.name));
  formData.append("date_de_naissance", form.value.date_de_naissance);
  formData.append("carte_identite", String(form.value.carte_identite));
  formData.append("address", String(form.value.address));
  formData.append("phone", form.value.phone);
  formData.append("region", String(form.value.region));
  formData.append("statu", String(form.value.statu));
  formData.append("email", String(form.value.email));
  formData.append("password", String(form.value.password));

  console.log(formData);
  await axios
    .post("api/partenaires", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
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

const resetForm = () => {
  form.value.name = "";
  form.value.carte_identite = "";
  form.value.date_de_naissance = "";
  form.value.address = "";
  form.value.phone = "";
  form.value.region = "";
  form.value.statu = "";
  form.value.email = "";
  form.value.password = "";
};

onMounted(async () => {
  await authStore.getUser();
  if (authStore.user && authStore.user !== null) {
    if (authStore.user.type != "admin") {
      router.push("/catalogue");
    }
  }
});

const products = ref();
</script>
