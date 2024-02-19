import { defineStore } from "pinia";
import axios from "axios";

export const usePanierStore = defineStore("panier", {
  state: () => ({
    Panier: [],
  }),
  getters: {
    panier: (state) => state.Panier,
  },
  actions: {
    addProduct(product) {
      this.Panier = product;
    },
    removeProduct(product) {},
    savePanier() {},
    savePanier(client) {},
  },
});
