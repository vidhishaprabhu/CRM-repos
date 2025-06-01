<template>
<a-card>
  <div class="d-flex align-items-center justify-content-between">
    <!-- Left side: Breadcrumb + Title stacked vertically -->
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

    <!-- Right side: Publish Button -->
    <button class="btn btn-primary" disabled>
      <CheckOutlined class="me-1" />
      Publish Form
    </button>
  </div>
</a-card>
<a-card v-if="current === 1" class="mt-3">
  <h3>1. Select Sales Pipeline</h3>
</a-card>
<a-card v-if="current === 2" class="mt-3">
  <h3>2. Select Fields</h3>
</a-card>
<a-card v-if="current === 3" class="mt-3">
  <h3>3. Configure Form</h3>
</a-card>
<div class="d-flex gap-3">
  <button class="btn btn-primary" @click="nextStep" :disabled="current === 3">Next</button>
  <button class="btn btn-primary" @click="prevStep" :disabled="current === 1">Previous</button>
</div>

  
</template>
<script>
import { Button,CheckOutlined,ArrowLeftOutlined} from '@ant-design/icons-vue';
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
    }
  }

}
</script>
