<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
      <router-link class="navbar-brand fw-bold text-dark bg-light px-2 py-1 rounded" to="/">PulseCRM</router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-2">

          <li class="nav-item">
            <router-link class="nav-link text-white fw-bold" to="/register">Register</router-link>
          </li>

          <li class="nav-item">
            <router-link class="nav-link text-white fw-bold" to="/login">Login</router-link>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" data-bs-toggle="dropdown">
              Dashboard
            </a>
            <ul class="dropdown-menu">
              <li><router-link class="dropdown-item" to="admin">Admin</router-link></li>
              <li><router-link class="dropdown-item" to="sales">Sales</router-link></li>
              <li><router-link class="dropdown-item" to="support">Support</router-link></li>
            </ul>
          </li>

          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" data-bs-toggle="dropdown">
              Sales
            </a>
            <ul class="dropdown-menu">
              <li><router-link class="dropdown-item" to="/add-sales-pipeline">Add Sales</router-link></li>
              <li><router-link class="dropdown-item" to="/sales">View Sales</router-link></li>
              <li><router-link class="dropdown-item" to="/support">Support</router-link></li>
            </ul>
          </li> -->

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" data-bs-toggle="dropdown">
              Charts
            </a>
            <ul class="dropdown-menu">
              <li><router-link class="dropdown-item" to="/admin-chart">Admin Chart</router-link></li>
              <li><router-link class="dropdown-item" to="/sales-manager-chart">Sales Chart</router-link></li>
              <li><router-link class="dropdown-item" to="/support-chart">Support Chart</router-link></li>
              <li><router-link class="dropdown-item" to="/login-chart">Login Chart</router-link></li>
            </ul>
          </li>

          <li class="nav-item">
            <button @click="logout" class="btn btn-danger fw-bold">Logout</button>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
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
body {
  background-image: url('@/assets/crm-image.avif');
  background-repeat: no-repeat;
  background-size: cover;         
  background-position: center;    
  background-attachment: fixed;  
  image-rendering: auto;         
  min-height: 100vh;
}



</style>
