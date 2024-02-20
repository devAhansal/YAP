import { defineStore } from "pinia";

// Function to load cart from localStorage
const loadCartFromLocalStorage = () => {
  const cartItems = localStorage.getItem("cartItems");
  return cartItems ? JSON.parse(cartItems) : [];
};

export const useCartStore = defineStore("cart", {
  state: () => ({
    items: loadCartFromLocalStorage(), // Load cart from localStorage
  }),
  actions: {
    addToCart(product) {
      // Check if the product already exists in the cart
      const existingProductIndex = this.items.findIndex(
        (item) => item.id === product.id
      );
      if (existingProductIndex !== -1) {
        // If the product already exists, you can handle it here (e.g., increase quantity)
        return {
          code: 400,
          message: "Le produit existe déjà dans le panier",
        };
      } else {
        // If the product doesn't exist, add it to the cart
        this.items.push(product);
        localStorage.setItem("cartItems", JSON.stringify(this.items));
        return {
          code: 200,
          message: "Le produit a été ajouter dans le panier",
        };
      }
    },
    removeFromCart(product) {
      // Trouver l'index de l'élément avec l'ID du produit
      console.log(this.items);
      console.log(product);
      const index = this.items.findIndex((item) => item.id === product.id);
      // Vérifier si l'élément a été trouvé dans le tableau
      if (index !== -1) {
        // Supprimer l'élément du tableau
        this.items.splice(index, 1);
        localStorage.setItem("cartItems", JSON.stringify(this.items)); // Save cart to localStorage
      }
    },
    clearCart() {
      this.items = [];
      localStorage.removeItem("cartItems"); // Clear cart from localStorage
    },
  },
  getters: {
    calculateTotalPrice() {
      let totalPrice = 0;
      // Vérifie si le panier contient des articles
      if (this.items && this.items.length > 0) {
        // Boucle à travers les articles du panier
        this.items.forEach((item) => {
          // Ajoute le prix de l'article au prix total
          totalPrice += item.prix_animal;
        });
      }
      // Retourne le prix total
      return totalPrice;
    },
    cartItemCount() {
      return this.items.length;
    },
  },
});
