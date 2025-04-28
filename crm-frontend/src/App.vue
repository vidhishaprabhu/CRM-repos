<template>
  <nav class="navbar navbar-expand-lg bg-primary shadow-sm position-sticky top-0">
    <div class="container">
      <router-link class="navbar-brand fw-bold bg-light" to="/">CRM</router-link>

      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/register">Register</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/login">Login</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/admin-dashboard">Admin</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/sales-dashboard">Sales</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/support-dashboard">Support</router-link>
          </li>
          <li class="nav-item">
            <button @click="logout" class="btn btn-danger">Logout</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <router-view></router-view>
  </div>
</template>


<script>
import api from './api';
export default {
  methods: {
    async logout() {
      try {
        const token = localStorage.getItem('api-token');
        if (!token) {
          alert("No token found. Please log in again.");
          return;
        }
        const response = await api.post('/logout', {}, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        localStorage.removeItem('api-token');
        alert("User logged out successfully");
        this.$router.push('/login');
      } catch (error) {
        this.error = "Logout failed. Please try again.";
      }
    },
  },
};
</script>

<style>

</style>
