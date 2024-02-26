<script setup>
import { defineProps, onMounted, ref } from "vue";
import { useAuthStore } from "../views/stores/auth";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import MonDialog from "primevue/dialog";
import { useCartStore } from "../views/stores/cart";
import { useRoute } from "vue-router";

import {
  Dialog,
  DialogPanel,
  PopoverGroup,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import {
  Bars3Icon,
  MagnifyingGlassIcon,
  ShoppingBagIcon,
  XMarkIcon,
} from "@heroicons/vue/24/outline";

const cartStore = useCartStore();
const toast = useToast();
const authStore = useAuthStore();
const props = defineProps({
  // Define your props here
  routeCurrentName: String,
});
const open = ref(false);
const navigation = {
  pages: [
    { name: "Catalogue", routeName: "catalogue" },
    { name: "Conseils", routeName: "conseils" },
    { name: "À propos", routeName: "propos" },
  ],
};
const visible = ref(false);
const route = useRoute();
const confirm = useConfirm();
const confirm1 = (product) => {
  confirm.require({
    message: "Êtes-vous sûr de vouloir supprimer cet animal à votre panier ?",
    header: "Confirmation",
    icon: "pi pi-exclamation-triangle",
    rejectClass: "p-button-secondary p-button-outlined",
    acceptClass: "p-button-danger",
    rejectLabel: "Annuler",
    acceptLabel: "Supprimer",
    accept: async () => {
      cartStore.removeFromCart(product);
      if (authStore.user && authStore.user !== null) {
        const commande = await cartStore.checkCommandesStatus();
        if (commande.countNonPaye == 0) {
          // add new commande for cart
          const id_commande = await cartStore.AddCommmande();
          await cartStore.DeleteAnimalOfCommande(id_commande, product.id);
        } else {
          //use last commande for cart
          cartStore.DeleteAnimalOfCommande(
            commande.lastNonPayeCommandeID,
            product.id
          );
        }
      }
      toast.add({
        severity: "error",
        summary: "Rejeté",
        detail: "Le produit a été supprimer dans le panier",
        life: 3000,
      });
    },
    reject: () => {
      toast.add({
        severity: "error",
        summary: "Rejeté",
        detail: "Vous avez refusé",
        life: 3000,
      });
    },
  });
};

onMounted(async () => {
  await authStore.getUser();
  if (route.query && route.query.success == 1) {
    // Afficher les paramètres dans la console
    console.log("Paramètres de la route :", route.query);
    toast.add({
      severity: "info",
      summary: "Confirmé",
      detail: "Le paiement a été effectué",
      life: 3000,
    });
    // Get the cart items from localStorage
    const cartItems = localStorage.getItem("cartItems");

    // Parse the cartItems string into a JavaScript object
    const content = JSON.parse(cartItems);

    // Check if content is not empty and it's an array
    if (Array.isArray(content) && content.length > 0) {
      // Iterate over each item in the content array
      content.forEach(async (item) => {
        // Log the id of the current item to the console
        console.log("Item id:", item.id);
        await cartStore.updateAnimalStatusToPaye(item.id);
        // You can perform other operations with the item here
      });
    } else {
      console.log("Cart is empty or invalid.");
    }
    await cartStore.successPaypalPayment(route.query);
    await cartStore.lastNonPayeCommande();
    window.location.reload();
  }
  if (route.query.success == 0) {
    toast.add({
      severity: "error",
      summary: "Rejeté",
      detail: "Le paiement a été annulé",
      life: 3000,
    });
  }
});
</script>
<template>
  <div class="bg-white">
    <!-- Mobile menu -->
    <TransitionRoot as="template" :show="open">
      <Dialog as="div" class="relative z-40 lg:hidden" @close="open = false">
        <TransitionChild
          as="template"
          enter="transition-opacity ease-linear duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="transition-opacity ease-linear duration-300"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black bg-opacity-25" />
        </TransitionChild>

        <div class="fixed inset-0 z-40 flex">
          <TransitionChild
            as="template"
            enter="transition ease-in-out duration-300 transform"
            enter-from="-translate-x-full"
            enter-to="translate-x-0"
            leave="transition ease-in-out duration-300 transform"
            leave-from="translate-x-0"
            leave-to="-translate-x-full"
          >
            <DialogPanel
              class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-xl"
            >
              <div class="flex px-4 pb-2 pt-5">
                <button
                  type="button"
                  class="relative -m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400"
                  @click="open = false"
                >
                  <span class="absolute -inset-0.5" />
                  <span class="sr-only">Close menu</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>

              <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                <div
                  v-for="page in navigation.pages"
                  :key="page.name"
                  class="flow-root"
                >
                  <router-link
                    :to="{ name: page.routeName }"
                    class="-m-2 block p-2 font-medium text-gray-900"
                    :class="{
                      ' text-indigo-600 ':
                        page.routeName === props.routeCurrentName,
                    }"
                    >{{ page.name }}</router-link
                  >
                </div>
              </div>

              <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                <div class="flow-root" v-if="authStore.user">
                  <router-link
                    :to="{ name: 'home' }"
                    class="-m-2 block p-2 font-medium text-gray-900"
                  >
                    {{ authStore.user.name }}
                  </router-link>
                </div>
                <div class="flow-root" v-else>
                  <router-link
                    :to="{ name: 'login' }"
                    class="-m-2 block p-2 font-medium text-gray-900"
                    >Se connecter
                  </router-link>
                </div>
                <div class="flow-root">
                  <router-link
                    v-if="!authStore.user"
                    :to="{ name: 'register' }"
                    class="-m-2 block p-2 font-medium text-gray-900"
                    >Inscrivez-vous
                  </router-link>
                  <router-link
                    v-else
                    :to="{ name: '' }"
                    @click="authStore.handleLogout()"
                    class="-m-2 block p-2 font-medium text-gray-900"
                    >Se déconnecter
                  </router-link>
                </div>
              </div>

              <div class="border-t border-gray-200 px-4 py-6">
                <a href="#" class="-m-2 flex items-center p-2">
                  <img
                    src="https://uxwing.com/wp-content/themes/uxwing/download/flags-landmarks/morocco-flag-icon.png"
                    alt=""
                    class="block h-auto w-5 flex-shrink-0"
                  />
                  <span class="ml-3 block text-base font-medium text-gray-900"
                    >MAD</span
                  >
                  <span class="sr-only">, change currency</span>
                </a>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <header class="relative bg-white">
      <nav aria-label="Top" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="border-b border-gray-200">
          <div class="flex h-16 items-center">
            <button
              type="button"
              class="relative rounded-md bg-white p-2 text-gray-400 lg:hidden"
              @click="open = true"
            >
              <span class="absolute -inset-0.5" />
              <span class="sr-only">Open menu</span>
              <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>

            <!-- Logo -->
            <div class="ml-4 flex lg:ml-0">
              <router-link :to="{ name: 'home' }">
                <img class="h-16 w-auto" src="/public/images/logo.ico" alt="" />
              </router-link>
            </div>

            <!-- Flyout menus -->
            <PopoverGroup class="hidden lg:ml-8 lg:block lg:self-stretch">
              <div class="flex h-full space-x-8">
                <router-link
                  v-for="page in navigation.pages"
                  :key="page.name"
                  :to="{ name: page.routeName }"
                  class="flex items-center pt-px text-sm font-medium transition-colors duration-200 ease-out"
                  :class="{
                    'border-indigo-600 text-indigo-600 border-b-2':
                      page.routeName === props.routeCurrentName,
                  }"
                >
                  {{ page.name }}
                </router-link>
              </div>
            </PopoverGroup>

            <div class="ml-auto flex items-center">
              <div
                class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6"
              >
                <router-link
                  v-if="authStore.user && authStore.user.type === 'admin'"
                  :to="{ name: 'dashboardAnimaux' }"
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                >
                  {{ authStore.user.name }}
                </router-link>
                <router-link
                  v-else-if="authStore.user && authStore.user.type !== 'admin'"
                  :to="{ name: '' }"
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                >
                  {{ authStore.user.name }}
                </router-link>
                <router-link
                  v-else
                  :to="{ name: 'login' }"
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                >
                  Se connecter
                </router-link>
                <span class="h-6 w-px bg-gray-200" aria-hidden="true" />
                <router-link
                  v-if="!authStore.user"
                  :to="{ name: 'register' }"
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                  >Inscrivez-vous
                </router-link>
                <router-link
                  v-else
                  :to="{ name: '' }"
                  @click="authStore.handleLogout()"
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                  >Se déconnecter
                </router-link>
              </div>

              <div class="hidden lg:ml-8 lg:flex">
                <a
                  href="#"
                  class="flex items-center text-gray-700 hover:text-gray-800"
                >
                  <img
                    src="https://uxwing.com/wp-content/themes/uxwing/download/flags-landmarks/morocco-flag-icon.png"
                    alt=""
                    class="block h-auto w-5 flex-shrink-0"
                  />
                  <span class="ml-3 block text-sm font-medium">MAD</span>
                  <span class="sr-only">, change currency</span>
                </a>
              </div>

              <!-- Cart -->
              <div class="ml-4 flow-root lg:ml-6">
                <a
                  href="#"
                  @click="visible = true"
                  class="group -m-2 flex items-center p-2"
                >
                  <ShoppingBagIcon
                    class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                    aria-hidden="true"
                  />
                  <span
                    class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800"
                    >{{ cartStore.items ? cartStore.items.length : 0 }}
                  </span>
                  <span class="sr-only">items in cart, view bag</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
  </div>

  <MonDialog
    v-model:visible="visible"
    modal
    header="Panier"
    :style="{ width: '70vw' }"
    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
  >
    <div class="card">
      <div class="flex justify-end mt-2">
        <Button
          label="Payer"
          :disabled="!authStore.user || cartStore.cartItemCount == 0"
          icon="pi pi-paypal"
          @click="
            cartStore.initiatePaypalPayment(cartStore.calculateTotalPrice)
          "
        />
      </div>
      <br />
      <DataTable
        :value="cartStore.items"
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
            <ColorPicker v-model="slotProps.data.couleur_animal" disabled />
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
        <Column field="date_de_naissance_animal" header="Date de Naissance">
          <template #body="slotProps">
            {{ slotProps.data.date_de_naissance_animal }}
          </template>
        </Column>
        <Column field="prix_animal" header="Prix">
          <template #body="slotProps">
            {{ slotProps.data.prix_animal }} MAD
          </template>
        </Column>
        <Column field="Actions" header="Actions">
          <template #body="slotProps">
            <center>
              <i
                title="Supprimer Animal"
                class="pi pi-minus text-red-500 cursor-pointer text-lg"
                @click="confirm1(slotProps.data)"
              ></i>
            </center>
          </template>
        </Column>

        <!-- Ajoutez d'autres colonnes selon vos besoins -->

        <template #footer>
          <div class="flex justify-between items-center">
            <div>
              Au total il y a
              {{ cartStore.cartItemCount }} Animaux.
            </div>
            <div>Prix Total {{ cartStore.calculateTotalPrice }} MAD.</div>
          </div>
        </template>
      </DataTable>
    </div>
  </MonDialog>
</template>
