<template>
  <nav class="navbar navbar-expand-lg bg-primary shadow-sm position-sticky top-0">
    <div class="container">
      <router-link class="navbar-brand fw-bold bg-light" to="/">CRM Application</router-link>

      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/register">Register</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/login">Login</router-link>
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
export default {
  name: 'App', 
  
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.nav-link{
  color: aliceblue;
}



body, html {
  margin: 0;
  padding: 0;
  background: url('@/assets/back-image.jpg');
}
</style>
