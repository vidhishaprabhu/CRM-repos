import { createRouter, createWebHistory } from "vue-router";
import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
import AdminDashboard from '../components/AdminDashboard.vue';
import SalesDashboard from '../components/SalesDashboard.vue';
import SupportDashboard from '../components/SupportDashboard.vue';

const routes = [
  { path: '/register', component: Register },
  { path: '/login', component: Login },
  { path: '/admin-dashboard', component: AdminDashboard, meta: { requiresAuth: true, role: 'Admin' } },
  { path: '/sales-dashboard', component: SalesDashboard, meta: { requiresAuth: true, role: 'Sales Manager' } },
  { path: '/support-dashboard', component: SupportDashboard, meta: { requiresAuth: true, role: 'Support' } }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('api-token');
  const userRole = localStorage.getItem('user-role'); 

  if (to.meta.requiresAuth) {
    if (!token) {
      next('/login'); 
    } else {
      if (to.meta.role && to.meta.role !== userRole) {
        alert('Access Denied: Unauthorized Role');
        next('/login'); 
      } else {
        next(); 
      }
    }
  } else {
    next(); 
  }
});

export default router;
