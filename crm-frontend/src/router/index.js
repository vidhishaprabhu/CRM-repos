import { createRouter, createWebHistory } from "vue-router";
import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
import AdminDashboard from '../components/AdminDashboard.vue';
import SalesDashboard from '../components/SalesDashboard.vue';
import SupportDashboard from '../components/SupportDashboard.vue';
import LoginChart from '../components/LoginChart.vue';
import AdminChart from '../components/AdminChart.vue';
import SalesChart from '../components/SalesChart.vue';
import SupportChart from '../components/SupportChart.vue';
import AddSalesPipeline from '../components/AddSalesPipeline.vue';
import LeadForm from '../components/LeadForm.vue';
import MainDashboard from '../components/MainDashboard.vue';
import FormDashboard from '../components/FormDashboard.vue';
import CreateForm from '../components/CreateForm.vue';

const routes = [
  { path: '/register', component: Register },
  { path: '/login', component: Login },
  { path: '/main-dashboard',component:MainDashboard},
  { path: '/admin', component: AdminDashboard, meta: { requiresAuth: true, role: 'Admin' } },
  { path: '/sales', component: SalesDashboard, meta: { requiresAuth: true, role: 'Sales Manager' } },
  { path: '/support', component: SupportDashboard, meta: { requiresAuth: true, role: 'Support' } },
  { path: '/login-chart', component: LoginChart, meta: { requiresAuth: true } },
  { path: '/admin-chart', component: AdminChart, meta: { requiresAuth: true,role:'Admin'} },
  { path: '/sales-manager-chart', component: SalesChart, meta: { requiresAuth: true,role:'Sales Manager'} },
  { path: '/support-chart', component: SupportChart, meta: { requiresAuth: true,role:'Support'} },
  { path: '/add-sales-pipeline', component: AddSalesPipeline, meta: { requiresAuth: true, role: 'Sales Manager' } },
  { path: '/add-leads',component:LeadForm,meta:{requiresAuth: true, role: 'Sales Manager'}},
  { path: '/form-dashboard', component: FormDashboard, meta: { requiresAuth: true, role: 'Sales Manager' } },
  { path: '/create-form', component: CreateForm, meta: { requiresAuth: true, role: 'Sales Manager' } },
  {
  path: '/form/:id',
  name: 'form-view',
  component: () => import('@/components/FormView.vue')
}

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
