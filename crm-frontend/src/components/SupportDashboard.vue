<template>
<div>
  <p class="text-center mb-6 text-primary" v-if="loggedInUser">
      Hello {{ loggedInUser.name }}
    </p>
    <h2 class="text-center mb-6 text-primary" v-if="loggedInUser">Welcome to {{loggedInUser.name}}!</h2>
    <h2>Getting Started</h2>
    <br>
</div>
  
</template>
<script>
import api from '../api'; 
export default{
  data(){
    return{
      id:'',
      name:'',
      email:'',
      loggedInUser: null, 
    }
  },
  mounted() {
    this.fetchLoggedInUser();
  },
  methods:{
    async fetchLoggedInUser() {
      try {
        const token = localStorage.getItem('api-token');
        const response = await api.get('/user', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.loggedInUser = response.data;
      } catch (error) {
        this.error = "Failed to fetch logged-in user";
      }
    },
  }
  
}
</script>
