export const ProductService = {
  getProductsData() {
    return [
      {
        id: "1003",
        code: "244wgerg2",
        name: "Bulldog",
        description: "The Bulldog is a medium-sized breed of dog that is muscular and heavyset.",
        image: "bulldog.jpg",
        price: 290,
        category: "Dogs",
        quantity: 25,
        inventoryStatus: "EN STOCK",
        rating: 5,
      },
      {
        id: "1004",
        code: "h456wer53",
        name: "Poodle",
        description: "The Poodle is a formal dog breed that comes in three varieties: Standard Poodle, Miniature Poodle, and Toy Poodle.",
        image: "poodle.jpg",
        price: 150,
        category: "Dogs",
        quantity: 73,
        inventoryStatus: "EN STOCK",
        rating: 4,
      },
      {
        id: "1005",
        code: "av2231fwg",
        name: "Beagle",
        description: "The Beagle is a small to medium-sized breed of dog. It is similar in appearance to the much larger Foxhound.",
        image: "beagle.jpg",
        price: 120,
        category: "Dogs",
        quantity: 0,
        inventoryStatus: "EN RUPTURE DE STOCK",
        rating: 4,
      },
      {
        id: "1006",
        code: "bib36pfvm",
        name: "Boxer",
        description: "The Boxer is a medium to large-sized breed of short-haired dog, developed in Germany.",
        image: "boxer.jpg",
        price: 320,
        category: "Dogs",
        quantity: 5,
        inventoryStatus: "EN RUPTURE DE STOCK",
        rating: 3,
      },
      {
        id: "1007",
        code: "mbvjkgip5",
        name: "Siberian Husky",
        description: "The Siberian Husky is a medium-sized working dog breed that originated in northeastern Siberia.",
        image: "siberian-husky.jpg",
        price: 340,
        category: "Dogs",
        quantity: 23,
        inventoryStatus: "EN STOCK",
        rating: 5,
      },
      // Add more dog breeds as needed
    ];
    
  },
  getProducts() {
    return Promise.resolve(this.getProductsData());
  },
};
