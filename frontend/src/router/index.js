import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
     path:'/',
    name: 'movies',
    component: () => import('../pages/MoviesPage.vue')
  },
  {
    path:'/favoritos',
    name: 'favoritos',
    component: () => import('../pages/FavoritosPage.vue')
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
