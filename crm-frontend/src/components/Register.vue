<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4 shadow-sm">
          <h2 class="text-center mb-4">Register</h2>
          <form @submit.prevent="register">
            <div class="mb-3">
              <input 
                type="text" 
                class="form-control" 
                placeholder="Enter your name" 
                v-model="name"
              >
            </div>
            <div class="mb-3">
              <input 
                type="email" 
                class="form-control" 
                placeholder="Enter your email" 
                v-model="email"
              >
            </div>
            <div class="mb-3">
              <input 
                type="password" 
                class="form-control" 
                placeholder="Enter your password" 
                v-model="password"
              >
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <p v-if="error" class="text-danger text-center mt-3">{{ error }}</p>
            <p v-else-if="message" class="text-success mt-5">{{message}}</p>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import api from '../api';
export default {

  data() {
    return {
      name: '',
      email: '',
      password: '',
      error: '',
      message:''
    }
  },
  methods: {
    async register() {
      try {
        const response = await api.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
        });
        this.error='';
        this.message="Registration was Successfully done !!";
        this.$router.push('/login');

      } catch (error) {
        this.error = 'Registration Failed !!. Please Try Again.'

      }
    }
  }

}
</script>

