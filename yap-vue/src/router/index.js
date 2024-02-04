import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/animaux',
      name: 'animaux',
      component: () => import('../views/AnimauxView.vue')
    },
    {
      path: '/catalogue',
      name: 'catalogue',
      component: () => import('../views/CatalogueView.vue')
    },
    {
      path: '/conseils',
      name: 'conseils',
      component: () => import('../views/ConseilsView.vue')
    },
    {
      path: '/propos',
      name: 'propos',
      component: () => import('../views/ProposView.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Auth/Login.vue')
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/Auth/Register.vue')
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/DashboardView.vue')
    },
    
  ]
})

export default router
