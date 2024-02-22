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

                      <!-- Ajoutez d'autres colonnes selon vos besoins -->

                      <template #footer>
                        Au total il y a
                        {{ Animaux ? Animaux.length : 0 }} Animaux.
                      </template>
                    </DataTable>
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
