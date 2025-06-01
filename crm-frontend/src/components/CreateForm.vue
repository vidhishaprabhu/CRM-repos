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
    <CheckOutlined v-if="marksteps" class="ms-2" style="background-color: #28a745; color: white; border-radius: 50%; padding: 6px; font-size: 16px;" />

    <select class="form-select" v-model="selectedPipeline" required>
      <option v-for="pipeline in salesPipelines" :key="pipeline.id" :value="pipeline.deal_title">{{pipeline.deal_title}}</option>
    </select>
    <div v-if="errorMessage.deal_title" class="text text-danger mt-3">
      {{ errorMessage.deal_title }}
    </div>

    <button class="btn btn-primary mt-5" @click="markthestep">Save & Continue </button>
  </div>
</a-card>

<a-card v-if="current === 2" class="mt-3" style="background-color: #f8f9fa;">
  <div class="p-3 rounded mt-4" style="background-color: #f8f9fa;">
    <div class="d-flex align-items-center gap-2 ">
      <h3>2. Select Fields</h3>
      <CheckOutlined v-if="markstepsone" class="ms-2" style="background-color: #28a745; color: white; border-radius: 50%; padding: 6px; font-size: 16px;" />
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
      <label class="form-check-label" for="flexSwitchCheckDefault">Full Name</label>
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
      <label class="form-check-label" for="flexSwitchCheckDefault">Email</label>
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
      <label class="form-check-label" for="flexSwitchCheckDefault">Phone Number</label>
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
      <label class="form-check-label" for="flexSwitchCheckDefault">Organisation Name</label>
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
      <label class="form-check-label" for="flexSwitchCheckDefault">Message</label>
    </div>
    <div class="mt-4">
      <p style="color:blue">
        <PlusOutlined /> Add New Custom Field</p>
    </div>
    <button class="btn btn-primary" @click="markthestepone">Save & Continue</button>
  </div>

</a-card>
<a-card v-if="current === 3" class="mt-3">
  <h3>3. Configure Form</h3>
  <div class="p-4 border rounded" style="max-width: 400px;">
    <label for="logoInput" class="form-label fw-bold">1. Add Business Logo <span style="color: red">*</span></label>
    
    <input
      type="file"
      ref="logoInput"
      id="logoInput"
      class="form-control"
      accept="image/*"
      @change="handleLogoUpload"
    />

    <div v-if="logoPreview" class="position-relative mt-3 d-inline-block">
      <!-- Close icon -->
      <CloseOutlined
        class="position-absolute"
        style="top: 0; right: 0; background: white; border-radius: 50%; padding: 2px; cursor: pointer;"
        @click="removeLogo"
      />
      <!-- Image Preview -->
      <img
        :src="logoPreview"
        alt="Logo Preview"
        class="img-thumbnail"
        style="max-height: 200px;"
      />
    </div>
    <div class="mt-3">
      <label style="font-weight:700">2. Form Title <span style="color:red">*</span></label>
      <input type="text" class="form-control" placeholder="Enter Form Title" required>
    </div>
    <div class="mt-3">
      <label style="font-weight:700">3. Add Form Description <span style="color:red">*</span></label>
      <textarea
      id="message"
      class="form-control"
      rows="6"
    ></textarea>
    </div>
    <div class="mt-3">
      <label style="font-weight:700">4. Form Name <span style="color:red">*</span></label>
      <input type="text" class="form-control" placeholder="Enter Form Name" required>
    </div>
    <div class="mt-3">
      <label style="font-weight:700">5. Submit Message <span style="color:red">*</span></label>
      <textarea
      ref="submitMessage"
      id="messages"
      class="form-control"
      v-model="messageText"
      rows="6"
    ></textarea>
    <div class="mt-3 d-flex justify-content-center">
      <button class="btn btn-primary">Save & Continue</button>
    </div>
    </div>
  </div>

    
 

</a-card>

<div class="d-flex gap-3 mt-5">
  <button class="btn btn-primary" @click="nextStep" :disabled="current === 3">Next</button>
  <button class="btn btn-primary" @click="prevStep" :disabled="current === 1">Previous</button>
</div>
<div class="mt-5 text-center">
  <p style="font-weight:700">Preview</p>
  <div class="p-3 rounded" style="background-color: #f8f9fa;">
    <label style="font-weight:700">Full Name <span style="color:red">*</span></label>
    <input type="text" class="form-control" placeholder="Enter Full Name" required>
    <label style="font-weight:700">Email <span style="color:red">*</span></label>
    <input type="email" class="form-control" placeholder="Enter Email" required>
    <label style="font-weight:700">Phone Number <span style="color:red">*</span></label>
    <input type="number" class="form-control" placeholder="Enter Phone Number" required>
    <label style="font-weight:700">Organisation Name <span style="color:red">*</span></label>
    <input type="text" class="form-control" placeholder="Enter Organisation Name" required>
    <label style="font-weight:700">Message <span style="color:red">*</span></label>
    <textarea
      id="messages"
      class="form-control"
      rows="6"
    ></textarea>
    <button type="submit" class="btn btn-primary mt-4">Submit</button>
    <p class="mt-4">Powered By <strong>PulseCRM</strong></p>
  </div>
</div>
</template>

<script>
import {
  Button,
  CheckOutlined,
  ArrowLeftOutlined,
  PlusOutlined,
  CloseOutlined
} from '@ant-design/icons-vue';
import api from '../api';
export default {
  name: 'CreateForm',
  components: {
    Button,
    CheckOutlined,
    ArrowLeftOutlined,
    PlusOutlined,
    CloseOutlined
  },
  data() {
    return {
      messageText:"Thank you for your submission!",
      current: 1,
      selectedPipeline: "",
      salesPipelines: [],
      marksteps: false,
      errorMessage: {},
      markstepsone: false,
      logoFile: null,
      logoPreview: null,
    };
  },
  methods: {
    nextStep() {
      if (this.current < 3) {
        this.current++;
      }
    },
    prevStep() {
      if (this.current > 1) {
        this.current--;
      }
    },
    markthestep() {
      if (!this.selectedPipeline) {
        this.errorMessage.deal_title = 'Please select a sales pipeline.';
        this.marksteps = false;
      } else {
        this.errorMessage.deal_title = '';
        this.marksteps = true;
        this.nextStep();
      }
    },
    markthestepone() {
      // if (!this.selectedPipeline) {
      //   this.errorMessage.deal_title = 'Please select a sales pipeline.';
      //   this.marksteps = false; 
      // } else {
      //   this.errorMessage.deal_title = '';  
      //   this.marksteps = true;
      //   this.nextStep();
      // }
      this.markstepsone = true;
      this.nextStep();

    },
    handleLogoUpload(event) {
      const file = event.target.files[0];
      if (file && file.type.startsWith("image/")) {
        this.logoFile = file;

        const reader = new FileReader();
        reader.onload = (e) => {
          this.logoPreview = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.logoFile = null;
        this.logoPreview = null;
        alert("Please upload a valid image file.");
      }
    },
    removeLogo(){
      this.logoFile = null;
      this.logoPreview = null;
      this.$refs.logoInput.value = null; // Clear the file input
    }

  },
  mounted() {
    api.get('/get-pipeline')
      .then(response => {
        this.salesPipelines = response.data;
        this.errorMessage - response.data.errorMessage || {};
      })
      .catch(error => {
        if (error.response && error.response.data && error.response.data.errorMessage) {
          this.errorMessage = error.response.data.errorMessage;
        } else {
          this.errorMessage = {
            general: "Failed to load sales pipelines. Please try again."
          };
        }
      });
  },

}
</script>
