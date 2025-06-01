<template>
<div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><router-link to="/main-dashboard">Dashboard</router-link></li>
      <li class="breadcrumb-item"><router-link to="/sales">Lead Management</router-link></li>
      <li class="breadcrumb-item"><router-link to="/sales">All Forms</router-link></li>
    </ol>
  </nav>

  <h4>All Forms</h4>

  <div class="d-flex justify-content-end">
    <Button className="btn btn-primary" style="font-weight:700"><PlusOutlined /> Create Form</Button>
  </div>
</div>

  
</template>
<script>
import { Button,PlusOutlined } from '@ant-design/icons-vue';
export default{
  name:'FormDashboard',
  components:{
    Button,
    PlusOutlined
  }
}
</script>
