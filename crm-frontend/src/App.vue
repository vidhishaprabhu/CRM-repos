<template>
<nav class="navbar navbar-expand-lg bg-primary shadow-sm position-sticky top-0">
  <div class="container">
    <router-link class="navbar-brand fw-bold bg-light" to="/">CRM</router-link>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <router-link class="nav-link text-light fw-bolder" to="/register">Register</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link text-light fw-bolder" to="/login">Login</router-link>
        </li>    
        <div class="dropdown">
          <li class="dropdown-toggle nav-link text-light fw-bolder" data-bs-toggle="dropdown" aria-expanded="false">
            Dashboard
          </li>
          <ul class="dropdown-menu">
            <li>
              <router-link class="dropdown-item" to="/admin">Admin</router-link>
            </li>
            <li>
              <router-link class="dropdown-item" to="/sales">Sales</router-link>
            </li>
            <li>
              <router-link class="dropdown-item" to="/support">Support</router-link>
            </li>
            <li>
              <router-link class="dropdown-item" to="/login-chart">Login-Chart</router-link>
            </li>
          </ul>
        </div>
        <div class="dropdown">
          <li class="dropdown-toggle nav-link text-light fw-bolder" data-bs-toggle="dropdown" aria-expanded="false">
            Charts
          </li>
          <ul class="dropdown-menu">
            <li>
              <router-link class="dropdown-item" to="/admin-chart">Admin-Chart</router-link>
            </li>
            <li>
              <router-link class="dropdown-item" to="/sales-manager-chart">Sales-Chart</router-link>
            </li>
            <li>
              <router-link class="dropdown-item" to="/support-chart">Support-Chart</router-link>
            </li>
            <li>
              <router-link class="dropdown-item" to="/login-chart">Login-Chart</router-link>
            </li>
          </ul>
        </div>
        <li class="nav-item">
          <button @click="logout" class="btn btn-danger fw-bolder">Logout</button>
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
nav {}
</style>
