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
  align-items: center; /* Optional: centers vertically if container has height */
  width: 100%;
  margin: 20px 0; /* Optional: space above/below */
}
</style>
