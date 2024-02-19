import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/catalogue",
      name: "catalogue",
      component: () => import("../views/AnimauxView.vue"),
    },
    {
      path: "/conseils",
      name: "conseils",
      component: () => import("../views/ConseilsView.vue"),
    },
    {
      path: "/propos",
      name: "propos",
      component: () => import("../views/ProposView.vue"),
    },
    {
      path: "/details-animal",
      name: "detailsanimal",
      component: () => import("../views/DetailsAnimal.vue"),
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../views/Auth/Login.vue"),
    },
    {
      path: "/register",
      name: "register",
      component: () => import("../views/Auth/Register.vue"),
    },
    {
      path: "/forgot-password",
      name: "forgotpassword",
      component: () => import("../views/Auth/ForgotPassword.vue"),
    },
    {
      path: "/password-reset/:token",
      name: "ResetPassword",
      component: () => import("../views/Auth/ResetPassword.vue"),
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: () => import("../views/Admin/DashboardView.vue"),
    },
    {
      path: "/dashboard/animaux",
      name: "dashboardAnimaux",
      component: () => import("../views/Admin/AnimauxView.vue"),
    },
    {
      path: "/dashboard/partenaires",
      name: "dashboardPartenaires",
      component: () => import("../views/Admin/PartenairesView.vue"),
    },
    {
      path: "/dashboard/commandes",
      name: "dashboardCommandes",
      component: () => import("../views/Admin/CommandesView.vue"),
    },
  ],
});

export default router;
