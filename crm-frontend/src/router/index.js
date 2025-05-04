import { createRouter, createWebHistory } from "vue-router";
import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
import AdminDashboard from '../components/AdminDashboard.vue';
import SalesDashboard from '../components/SalesDashboard.vue';
import SupportDashboard from '../components/SupportDashboard.vue';
import Dashboard from '../components/Dashboard.vue';
import LoginChart from '../components/LoginChart.vue';

const routes = [
  { path: '/register', component: Register },
  { path: '/login', component: Login },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true }, children: [
    { path: '/admin', component: AdminDashboard, meta: { requiresAuth: true, role: 'Admin' } },
    { path: '/sales', component: SalesDashboard, meta: { requiresAuth: true, role: 'Sales Manager' } },
    { path: '/support', component: SupportDashboard, meta: { requiresAuth: true, role: 'Support' } },
  ] },
  { path: '/login-chart', component: LoginChart, meta: { requiresAuth: true } },
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
