<template>
  <div class="min-h-full">
    <navbar-admin routeCurrentName="dashboardAnimaux" />
   

    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Animaux</h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="card">
          <TabView>
            <TabPanel header="Gérer Animaux">
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
                      <!-- Header content -->
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
                      <ColorPicker  v-model="slotProps.data.couleur_animal"  disabled />
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

                  <!-- Ajoutez d'autres colonnes selon vos besoins -->

                  <template #footer>
                    In total there are
                    {{ Animaux ? Animaux.length : 0 }} Animaux.
                  </template>
                </DataTable>
              </div>
            </TabPanel>
            <TabPanel header="Ajouter Animaux">
              <form @submit.prevent="handleAjouterAnimal">
                <div class="space-y-12">
                  <div class="border-b border-gray-900/10 pb-12">
                    <div class="border-b border-gray-900/10 pb-12">
                      <h2
                        class="text-base font-semibold leading-7 text-gray-900"
                      >
                        Informations sur l'animal
                      </h2>

                      <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                      >
                        <div class="sm:col-span-3">
                          <label
                            for="first-name"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Nom</label
                          >
                          <div class="mt-2">
                            <input
                              type="text"
                              name="first-name"
                              v-model="form.nom_animal"
                              id="first-name"
                              autocomplete="nom_animal"
                              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            />
                          </div>
                        </div>

                        <div class="sm:col-span-3">
                          <label
                            for="prix_animal"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Prix</label
                          >
                          <div class="mt-2">
                            <input
                              type="number"
                              name="prix_animal"
                              id="prix_animal"
                              v-model="form.prix_animal"
                              autocomplete="prix_animal"
                              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            />
                          </div>
                        </div>

                        <div class="sm:col-span-3">
                          <label
                            for="date_de_naissance_animal"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Date de naissance</label
                          >
                          <div class="mt-2">
                            <input
                              v-model="form.date_de_naissance_animal"
                              id="date_de_naissance_animal"
                              name="date_de_naissance_animal"
                              type="date"
                              autocomplete="date_de_naissance_animal"
                              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            />
                          </div>
                        </div>
                        <div class="sm:col-span-1">
                          <label
                            for="date_de_naissance_animal"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Couleur</label
                          >
                          <div class="mt-2">
                            <!-- <input
                              v-model="form.couleur_animal"
                              id="couleur_animal"
                              name="couleur_animal"
                              type="color"
                              autocomplete="couleur_animal"
                              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                           /> -->
                            <ColorPicker v-model="form.couleur_animal" />
                          </div>
                        </div>
                        <div class="sm:col-span-2">
                          <label
                            for="pet-category"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Catégorie</label
                          >
                          <div class="mt-2">
                            <select
                              id="pet-category"
                              name="pet-category"
                              v-model="form.type_animal"
                              autocomplete="pet-category"
                              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:max-w-xs sm:text-sm sm:leading-6"
                            >
                              <option>Chien</option>
                              <option>Chat</option>
                              <option>Oiseau</option>
                              <option>Poisson</option>
                              <option>Rongeur</option>
                              <option>Reptile</option>
                              <option>Lapin</option>
                              <option>Hamster</option>
                              <option>Cochon d'Inde</option>
                              <option>Furet</option>
                              <option>Souris</option>
                              <option>Chinchilla</option>
                              <option>Perroquet</option>
                              <option>Perruche</option>
                              <option>Canari</option>
                              <option>Poule</option>
                              <option>Pigeon</option>
                              <option>Paon</option>
                              <option>Autre</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div
                      class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                    >
                      <div class="col-span-full">
                        <label
                          for="cover-photo"
                          class="block text-sm font-medium leading-6 text-gray-900"
                          >Photo</label
                        >
                        <div
                          class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
                        >
                          <div class="text-center">
                            <PhotoIcon
                              class="mx-auto h-12 w-12 text-gray-300"
                              aria-hidden="true"
                            />
                            <div
                              class="mt-4 flex text-sm leading-6 text-gray-600"
                            >
                              <label
                                for="file-upload"
                                class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 hover:text-blue-500"
                              >
                                <span>Téléverser un fichier</span>
                                <input
                                  id="file-upload"
                                  name="file-upload"
                                  type="file"
                                  class="sr-only"
                                  @change="onselectedFile"
                                />
                              </label>
                              <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs leading-5 text-gray-600">
                              PNG, JPG, GIF jusqu'à 10 Mo
                            </p>
                          </div>
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
import { ProductService } from "@/service/ProductService";
import axios from "axios";
import { useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";
const toast = useToast();

const router = useRouter();

onMounted(() => {
  ProductService.getProducts().then((data) => (products.value = data));
  getAnimals();
});
const form = ref({
  nom_animal: "",
  prix_animal: "",
  date_de_naissance_animal: "",
  type_animal: "",
  couleur_animal: "",
  image_animal: null, // Définissez image_animal sur null
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

const onselectedFile = (event) => {
  form.image_animal = event.target.files[0];
};

const handleAjouterAnimal = async () => {
  const formData = new FormData();
  formData.append("nom_animal", String(form.value.nom_animal));
  formData.append("prix_animal", form.value.prix_animal);
  formData.append("couleur_animal", String(form.value.couleur_animal));
  formData.append(
    "date_de_naissance_animal",
    form.value.date_de_naissance_animal
  );
  formData.append("type_animal", String(form.value.type_animal));
  formData.append("image_animal", form.image_animal);
  console.log(formData);
  await axios
    .post("api/animal", formData, {
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
      getAnimals();
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
  form.value.nom_animal = "";
  form.value.prix_animal = "";
  form.value.date_de_naissance_animal = "";
  form.value.type_animal = "";
  form.value.couleur_animal = "";
  form.value.image_animal = null;
};

const products = ref();
const formatCurrency = (value) => {
  return value.toLocaleString("en-Maroc", {
    style: "currency",
    currency: "MAD",
  });
};
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
