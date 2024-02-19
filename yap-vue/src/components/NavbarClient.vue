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
                <div class="flow-root" v-if="User && User.name">
                  <router-link
                    :to="{ name: 'home' }"
                    class="-m-2 block p-2 font-medium text-gray-900"
                  >
                    {{ User.name }}
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
                    :to="{ name: 'register' }"
                    class="-m-2 block p-2 font-medium text-gray-900"
                    >Inscrivez-vous
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
                  :to="{ name: '' }"
                  v-if="User && User.name"
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                  >{{ User.name }}
                </router-link>
                <router-link
                  :to="{ name: 'login' }"
                  v-else
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                  >Se connecter
                </router-link>
                <span class="h-6 w-px bg-gray-200" aria-hidden="true" />

                <router-link
                  v-if="User && User.name"
                  :to="{ name: '' }"
                  @click="logout"
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                  >Se déconnecter
                </router-link>
                <router-link
                  v-else
                  :to="{ name: 'register' }"
                  class="text-sm font-medium text-gray-700 hover:text-gray-800"
                  >Inscrivez-vous
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

              <!-- Search -->
              <div class="flex lg:ml-6">
                <a href="#" class="p-2 text-gray-400 hover:text-gray-500">
                  <span class="sr-only">Search</span>
                  <MagnifyingGlassIcon class="h-6 w-6" aria-hidden="true" />
                </a>
              </div>

              <!-- Cart -->
              <div class="ml-4 flow-root lg:ml-6">
                <a href="#" class="group -m-2 flex items-center p-2">
                  <ShoppingBagIcon
                    class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                    aria-hidden="true"
                  />
                  <span
                    class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800"
                    >0</span
                  >
                  <span class="sr-only">items in cart, view bag</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
  </div>
</template>

<script setup>
import { defineProps } from "vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { useToast } from "primevue/usetoast";
const toast = useToast();
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

const props = defineProps({
  // Define your props here
  routeCurrentName: String,
});

const navigation = {
  pages: [
    { name: "Catalogue", routeName: "catalogue" },
    { name: "Conseils", routeName: "conseils" },
    { name: "À propos", routeName: "propos" },
  ],
};

const User = ref(null);

const getUsers = async () => {
  try {
    const response = await axios.get("api/user");
    User.value = response.data;
  } catch (error) {
    console.error("Error fetching user data:", error);
    User.value = null;
  }
};
const logout = async () => {
  await axios.post("api/logout");
  router.push("/");
};
onMounted(() => {
  getUsers();
});

const open = ref(false);
</script>
