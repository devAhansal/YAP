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
    removeFromCart(index) {
      this.items.splice(index, 1);
      localStorage.setItem("cartItems", JSON.stringify(this.items)); // Save cart to localStorage
    },
    clearCart() {
      this.items = [];
      localStorage.removeItem("cartItems"); // Clear cart from localStorage
    },
  },
  getters: {
    cartTotal() {
      return this.items.reduce((total, product) => total + product.price, 0);
    },
    cartItemCount() {
      return this.items.length;
    },
  },
});
