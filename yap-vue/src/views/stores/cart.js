import { defineStore } from "pinia";
import axios from "axios";
import { useAuthStore } from "./auth";
// Function to load cart from localStorage
const loadCartFromLocalStorage = () => {
  const cartItems = localStorage.getItem("cartItems");
  return cartItems ? JSON.parse(cartItems) : [];
};
const authStore = useAuthStore();

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
          message: "Le produit a été ajouté dans le panier",
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
    async initiatePaypalPayment(TotalPrice) {
      try {
        const response = await axios.post("api/create-payment", {
          TotalPrice: TotalPrice,
        });
        // Check if the response contains the 'links' array
        if (response.data) {
          window.location.href = response.data.link;
        } else {
          console.error("Invalid response format from the server");
          // Handle the error or display a message to the user
        }
      } catch (error) {
        console.error("Error initiating PayPal payment:", error);
      }
    },
    async successPaypalPayment(data) {
      try {
        const response = await axios.post("api/success-payment", {
          PayerID: data.PayerID,
          token: data.token,
        });
        this.router.push("/catalogue");
        this.clearCart();
      } catch (error) {
        console.error("Error initiating PayPal payment:", error);
      }
    },
    // checkCommandesStatus Paye ou non paye
    async checkCommandesStatus() {
      try {
        const response = await axios.get("/api/check-commandes-status");
        return response.data;
        console.log("Commandes Status:", response.data);
      } catch (error) {
        console.error("Error checking commandes status:", error);
      }
    },
    async AddCommmande() {
      try {
        const response = await axios.post("/api/commandes");
        return response.data;
        console.log("Commande added successfully:", response.data);
        toast.success("Commande added successfully");
      } catch (error) {
        console.error("Error adding commande:", error);
        toast.error("Error adding commande");
      }
    },
    async AddAnimalToCommande(commandeId, AnimalId) {
      try {
        const response = await axios.post("/api/paniers", {
          commande_id: commandeId,
          animal_id: AnimalId,
        });
        console.log("Animal added to commande:", response.data);
        toast.success("Animal added to commande successfully");
      } catch (error) {
        console.error("Error adding animal to commande:", error);
        toast.error("Error adding animal to commande");
      }
    },
    async DeleteAnimalOfCommande(commandeId, AnimalId) {
      try {
        const response = await axios.delete(
          "/api/paniers/" + commandeId + "/" + AnimalId
        );
        return "Animal deleted  successfully";
      } catch (error) {
        return "Error deleting animal";
      }
    },
    async lastNonPayeCommande() {
      try {
        const response = await axios.post("/api/updateToPaye");
        return response.data;
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    },
    async updateAnimalStatusToPaye(animalId) {
      try {
        const response = await axios.put(
          `/api/animal/${animalId}`
        );
        console.log(response.data.message); // Log the success message
        // Handle success (e.g., show a success message to the user)
      } catch (error) {
        console.error("Error updating animal status:", error);
        // Handle error (e.g., show an error message to the user)
      }
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
