<template>
<a-card>
  <div class="d-flex align-items-center justify-content-between">
    <div>
      <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <router-link to="/main-dashboard">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link to="/form-dashboard">All Forms</router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <router-link to="/create-form">Create Form</router-link>
          </li>
        </ol>
      </nav>
      <h4 class="mb-0">Create Form</h4>
    </div>
    <button class="btn btn-primary" disabled>
      <CheckOutlined class="me-1" />
      Publish Form
    </button>
  </div>
</a-card>
<a-card v-if="current === 1" class="mt-8">
  <h3 class="mb-3">1. Select Sales Pipeline</h3>

  <div class="p-3 rounded" style="background-color: #f8f9fa;">
    <label style="font-weight:700">Select Sales Pipeline <span style="color:red">*</span></label>
    <CheckOutlined 
  v-if="marksteps"
  class="ms-2"
  style="background-color: #28a745; color: white; border-radius: 50%; padding: 6px; font-size: 16px;"
/>

    <select class="form-select" v-model="selectedPipeline" required>
    <option v-for="pipeline in salesPipelines"
    :key="pipeline.id"
    :value="pipeline.deal_title">{{pipeline.deal_title}}</option>
    </select>
    
    <button class="btn btn-primary mt-5" @click="markthestep">Save & Continue </button>
  </div>
</a-card>


<a-card v-if="current === 2" class="mt-3">
  <h3>2. Select Fields</h3>
</a-card>
<a-card v-if="current === 3" class="mt-3">
  <h3>3. Configure Form</h3>
 
</a-card>
<div class="d-flex gap-3 mt-5">
  <button class="btn btn-primary" @click="nextStep" :disabled="current === 3">Next</button>
  <button class="btn btn-primary" @click="prevStep" :disabled="current === 1">Previous</button>
</div>

  
</template>
<script>
import { Button,CheckOutlined,ArrowLeftOutlined} from '@ant-design/icons-vue';
import api from '../api'; 
export default{
  name:'CreateForm',
  components:{
    Button,
    CheckOutlined,
    ArrowLeftOutlined
  },
  data() {
    return {
      current:1,
      selectedPipeline: "",
      salesPipelines: [],
      marksteps:false,
    };
  },
  methods:{
    nextStep(){
      if(this.current <3){
        this.current++;
      }
    },
    prevStep(){
      if(this.current >1){
        this.current--;
      }
    },
    markthestep(){
      this.marksteps=true;
      this.nextStep();
    }
    
  },
  mounted() {
    api.get('/get-pipeline') 
      .then(response => {
        this.salesPipelines = response.data;
      })
      .catch(error => {
        console.error('Error fetching sales pipelines:', error);
      });
  },

}
</script>
