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
  <div class="p-3 rounded" style="background-color: #f8f9fa;">
    <p class="mb-3" style="font-size:130%;font-weight:700">1. Select Sales Pipeline</p>
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
      <p style="font-size:130%;font-weight:700">2. Select Fields</p>
      <CheckOutlined v-if="markstepsone" class="ms-2" style="background-color: #28a745; color: white; border-radius: 50%; padding: 6px; font-size: 16px;" />
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" v-model="showFullName">
      <label class="form-check-label" for="flexSwitchCheckDefault">Full Name</label>
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" v-model="showEmail">
      <label class="form-check-label" for="flexSwitchCheckDefault">Email</label>
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" v-model="showPhone">
      <label class="form-check-label" for="flexSwitchCheckDefault">Phone Number</label>
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" v-model="showOrg">
      <label class="form-check-label" for="flexSwitchCheckDefault">Organisation Name</label>
    </div>
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" v-model="showMsg">
      <label class="form-check-label" for="flexSwitchCheckDefault">Message</label>
    </div>
    <div
  class="form-check form-switch mt-3"
  v-for="(field, index) in customFields"
  :key="index"
>
  <input
    class="form-check-input"
    type="checkbox"
    role="switch"
    :id="'custom-switch-' + index"
    v-model="field.model"
  />
  <label class="form-check-label" :for="'custom-switch-' + index">{{ field.label }}</label>
</div>
    <div>
      <a-button @click="showModal" class="btn btn-primary mb-5 mt-5">
        <PlusOutlined /> Add New Custom Field
      </a-button>
    </div>
    <a-modal v-model:visible="modelVisible" title="Add Custom Field" :footer="null" @cancel="handleCancel">
      <a-form layout="vertical" class="mt-3">
        <a-form-item class="d-flex justify-content-center">
          <div class="d-flex gap-4">
            <a-checkbox v-model:checked="isRequired">This is a mandatory field</a-checkbox>
            <a-checkbox v-model:checked="isVisible">This is hidden field</a-checkbox>
          </div>
        </a-form-item>

        <a-form-item label="Field Type">
          <a-select v-model:value="fieldType" placeholder="Select Field Type">
            <a-select-option value="text">Text</a-select-option>
            <a-select-option value="number">Number</a-select-option>
            <a-select-option value="email">Email</a-select-option>
            <a-select-option value="date">Date</a-select-option>
            <a-select-option value="checkbox">Checkbox</a-select-option>
          </a-select>
        </a-form-item>

        <a-form-item label="Label">
          <a-input v-model:value="label" placeholder="Enter label for the field" />
        </a-form-item>

        <a-form-item>
          <a-button type="primary" @click="submitCustomField">Submit</a-button>
        </a-form-item>
      </a-form>
    </a-modal>

    <button class="btn btn-primary" @click="markthestepone">Save & Continue</button>
  </div>

</a-card>
<a-card v-if="current === 3" class="mt-3">
  <p style="font-size:130%;font-weight:700">3. Configure Form</p>
  <div class="p-4 border rounded" style="max-width: 400px;">
    <label for="logoInput" class="form-label fw-bold">1. Add Business Logo</label>

    <input type="file" ref="logoInput" id="logoInput" class="form-control" accept="image/*" @change="handleLogoUpload" />

    <div v-if="logoPreview" class="position-relative mt-3 d-inline-block">
      <!-- Close icon -->
      <CloseOutlined class="position-absolute" style="top: 0; right: 0; background: white; border-radius: 50%; padding: 2px; cursor: pointer;" @click="removeLogo" />
      <!-- Image Preview -->
      <img :src="logoPreview" alt="Logo Preview" class="img-thumbnail" style="max-height: 200px;"/>
      <div v-if="errors.logo" class="text-danger mt-1">{{ errors.logo }}</div>
    </div>
    <div class="mt-3">
      <label style="font-weight:700">2. Form Title <span style="color:red">*</span></label>
      <input type="text" class="form-control" placeholder="Enter Form Title" required v-model="showFormTitle">
      <div v-if="errors.title" class="text-danger mt-1">{{ errors.title }}</div>
    </div>
    <div class="mt-3">
      <label style="font-weight:700">3. Add Form Description <span style="color:red">*</span></label>
      <textarea id="message" class="form-control" rows="6" v-model="formDescription"></textarea>
      <div v-if="errors.description" class="text-danger mt-1">{{ errors.description }}</div>

    </div>
    <div class="mt-3">
      <label style="font-weight:700">4. Form Name <span style="color:red">*</span></label>
      <input type="text" class="form-control" placeholder="Enter Form Name" required v-model="formName">
      <div v-if="errors.formName" class="text-danger mt-1">{{ errors.formName }}</div>
    </div>
    <div class="mt-3">
      <label style="font-weight:700">5. Submit Message <span style="color:red">*</span></label>
      <textarea ref="submitMessage" id="messages" class="form-control" v-model="messageText" rows="6"></textarea>
      <div v-if="errors.submitMessage" class="text-danger mt-1">{{ errors.submitMessage }}</div>
      <div class="mt-3 d-flex justify-content-center">
        <button class="btn btn-primary" @click="validateForm">Save & Continue</button>
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
    <div
  v-if="
    !showFullName &&
    !showEmail &&
    !showPhone &&
    !showOrg &&
    !showMsg &&
    customFields.every(field => !field.model)
  "
>
  <p class="text-danger fw-bolder">No selected fields found</p>
  
</div>
<div class="mt-3">
  <span style="font-size:250%;font-weight:700">{{showFormTitle}}</span>
      
</div>
<!-- Inside Preview Section -->
<div v-if="logoPreview" class="mb-3 text-center">
  <div class="mt-2">
    <img :src="logoPreview" alt="Business Logo" class="img-thumbnail" style="max-height: 200px;" />
  </div>
</div>



    <div v-if="showFullName">
      <label style="font-weight:700">Full Name <span style="color:red">*</span></label>
      <input type="text" class="form-control" placeholder="Enter Full Name" required>
    </div>
    <div v-if="showEmail">
      <label style="font-weight:700">Email <span style="color:red">*</span></label>
      <input type="email" class="form-control" placeholder="Enter Email" required>
    </div>
    <div v-if="showPhone">
      <label style="font-weight:700">Phone Number <span style="color:red">*</span></label>
      <input type="number" class="form-control" placeholder="Enter Phone Number" required>
    </div>

    <div v-if="showOrg">
      <label style="font-weight:700">Organisation Name <span style="color:red">*</span></label>
      <input type="text" class="form-control" placeholder="Enter Organisation Name" required>
    </div>
    <div v-if="showMsg">
      <label style="font-weight:700">Message <span style="color:red">*</span></label>
      <textarea id="messages" class="form-control" rows="6"></textarea>
    </div>
    <div v-for="(field, index) in customFields" :key="'preview-' + index">
  <div v-if="field.model">
    <label style="font-weight:700">
      {{ field.label }} <span style="color:red">*</span>
    </label>

    <input
      v-if="field.fieldType === 'text'"
      type="text"
      class="form-control"
      :placeholder="`Enter ${field.label}`"
      required
    />

    <input
      v-else-if="field.fieldType === 'number'"
      type="number"
      class="form-control"
      :placeholder="`Enter ${field.label}`"
      required
    />

    <input
      v-else-if="field.fieldType === 'email'"
      type="email"
      class="form-control"
      :placeholder="`Enter ${field.label}`"
      required
    />

    <input
      v-else-if="field.fieldType === 'date'"
      type="date"
      class="form-control"
      required
    />

    <div v-else-if="field.fieldType === 'checkbox'" class="form-check">
      <input
        class="form-check-input"
        type="checkbox"
        :id="'custom-preview-checkbox-' + index"
      />
      <label class="form-check-label" :for="'custom-preview-checkbox-' + index">
        {{ field.label }}
      </label>
    </div>
  </div>
</div>

    <button type="submit" class="btn btn-primary mt-4">Submit</button>
    <p class="mt-4">Powered By <strong>PulseCRM</strong></p>
  </div>
</div>
</template>

<script>
import {
  Button,
  Modal,
  Input,
  Form,
  Select,
  Checkbox,
} from 'ant-design-vue';

import {
  CheckOutlined,
  ArrowLeftOutlined,
  PlusOutlined,
  CloseOutlined
} from '@ant-design/icons-vue';

import api from '../api';

export default {
  name: 'CreateForm',
  components: {
    'a-button': Button,
    'a-modal': Modal,
    'a-input': Input,
    'a-form': Form,
    'a-form-item': Form.Item,
    'a-select': Select,
    'a-select-option': Select.Option,
    'a-checkbox': Checkbox,
    'a-select': Select,
    'a-select-option': Select.Option,
    CheckOutlined,
    ArrowLeftOutlined,
    PlusOutlined,
    CloseOutlined,
  },
  data() {
    return {
      showFormTitle: '',
      formDescription: '',
      formName: '',
      messageText: '',
      logoPreview: null,
      errors: {
      logo: '',
      title: '',
      description: '',
      formName: '',
      submitMessage: ''
    },
      showFormTitle: '',
      customFields:[],
      isRequired: false,
      isVisible: false,
      modelVisible: false,
      showFullName: false,
      showEmail: false,
      showPhone: false,
      showOrg: false,
      showMsg: false,
      messageText: "Thank you for your submission!",
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
    validateForm() {
    let isValid = true;

    // Reset errors
    this.errors = {
      logo: '',
      title: '',
      description: '',
      formName: '',
      submitMessage: ''
    };

    if (!this.logoPreview) {
      this.errors.logo = 'Business logo is required.';
      isValid = false;
    }

    if (!this.showFormTitle.trim()) {
      this.errors.title = 'Form title is required.';
      isValid = false;
    }

    if (!this.formDescription.trim()) {
      this.errors.description = 'Form description is required.';
      isValid = false;
    }

    if (!this.formName.trim()) {
      this.errors.formName = 'Form name is required.';
      isValid = false;
    }

    if (!this.messageText.trim()) {
      this.errors.submitMessage = 'Submit message is required.';
      isValid = false;
    }

    if (isValid) {
      // Continue form submission logic
      alert('Form is valid! You can proceed.');
    }
  },
    submitCustomField() {
    if (this.label && this.fieldType) {
      this.customFields.push({
        label: this.label,
        fieldType: this.fieldType,
        model: true  // For v-model of switch
      });

      // Reset fields
      this.label = '';
      this.fieldType = '';
      this.isRequired = false;
      this.isVisible = true;
      this.modelVisible = false; // If you're closing modal after submit
    }
  },
    showModal() {
      this.modelVisible = true;

    },
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
    removeLogo() {
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
