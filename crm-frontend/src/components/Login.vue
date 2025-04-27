<template>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4 shadow-sm">
        <h2 class="text-center mb-4">Login</h2>
        <form @submit.prevent="login">
          <div class="mb-3">
            <input type="email" class="form-control" placeholder="Enter your Email" v-model="email"/>
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" placeholder="Enter your Password" v-model="password"/>
          </div>
          <button type="submit" class="btn btn-primary mt-5">Login</button>
          <p v-if="error" class="text-danger mt-5">{{error}}</p>
        </form>
      </div>

    </div>
  </div>
</div>
  
</template>
<script>
import api from '../api';
export default{
  data(){
    return{
      email:'',
      password:'',
      error:''
    }
  },
  methods:{
    async login(){
      try{
        const response=await api.post('/login',{
          email:this.email,
          password:this.password,
        });
        const token =response.data.token;
        localStorage.setItem('api-token',token);
        alert("Login was Successfull");

      }
      catch(error){
        this.error="Login Failed!!. Please Try Again";
      }
    }

  }
}
</script>
