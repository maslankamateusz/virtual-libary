import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import BookView from '../views/BookView.vue';

const routes = [
  { path: '/', component: HomeView },
  { path: '/books/:id', component: BookView }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
