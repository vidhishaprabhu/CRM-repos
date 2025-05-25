<template>
  <div>
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><router-link to="/main-dashboard">Dashboard</router-link></li>
    <li class="breadcrumb-item"><router-link to="/sales">Lead Management</router-link></li>
  </ol>
</nav>
    <div class="card shadow-sm mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Lead Management</h5>

        <div>
          <router-link to="/add-sales-pipeline">
            <button class="btn btn-primary me-2" style="color:white;font-weight:700" v-if="loggedInUser">
              <PlusOutlined style="color:white;"/> New Sales Pipeline
            </button>
          </router-link>

          <router-link to="/add-leads">
            <button class="btn btn-primary" style="color:white;font-weight:700" v-if="loggedInUser">
              <PlusOutlined style="color:white;"/> New Leads
            </button>
          </router-link>
          <div class="nav-tabs-custom">
    <router-link
      v-for="tab in tabs"
      :key="tab.name"
      :to="tab.route"
      class="tab-link"
      :class="{ active: $route.path === tab.route }"
    >
      {{ tab.name }}
    </router-link>
  </div>
        </div>
      </div>
    </div>
  </div>
   
    <br />
  </div>
</template>

<script>
import api from '../api';
import { PlusOutlined,HomeOutlined } from '@ant-design/icons-vue';

export default {
  data() {
    return {
      tabs: [
        { name: 'All Sales Pipelines', route: '' },
        { name: 'Reports', route: '' },
        { name: 'Forms', route: '' },
        { name: 'All leads', route: '' },
      ],
      name: '',
      email: '',
      loggedInUser: null,
      error: '',
    };
  },
  components: {
    PlusOutlined,
    HomeOutlined
  },
  mounted() {
    this.fetchLoggedInUser();
  },
  methods: {
    async fetchLoggedInUser() {
      try {
        const token = localStorage.getItem('api-token');
        const response = await api.get('/user', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        this.loggedInUser = response.data;
      } catch (error) {
        this.error = 'Error in fetching the logged in user data';
      }
    },
  },
};
</script>
<style scoped>
.center-btn {
  display: flex;
  justify-content: center;
  align-items: center; 
  width: 100%;
  margin: 20px 0; 
}
.nav-tabs-custom {
  display: flex;
  gap: 2rem; 
  border-bottom: 1px solid #ddd;
  padding-bottom: 0.5rem;
  margin-top:2vw;
}

.tab-link {
  text-decoration: none;
  color: #333;
  padding-bottom: 5px;
  position: relative;
  font-weight: 500;
}

.tab-link.active::after {
  content: '';
  position: absolute;
  bottom: -1px;
  left: 0;
  height: 2px;
  width: 100%;
  background-color: purple;
}
</style>
