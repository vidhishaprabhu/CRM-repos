<template>
  <div v-if="form">
    <div class="card shadow-sm mt-4">
  <div class="card-body">
    <h1 class="text-center">{{ form.title }}</h1>
    <p class="text-center">{{ form.description }}</p>
    <div v-if="form.logo" class="text-center mb-4">
      <img :src="form.logo" alt="Form Logo" class="img-fluid" style="max-height: 120px;" />
    </div>
    <form @submit.prevent="submitForm">
      <!-- Full Name -->
      <div v-if="form.fields.fullName" class="mb-3">
        <label>Full Name</label>
        <input type="text" v-model="formData.fullName" class="form-control" required />
      </div>

      <!-- Email -->
      <div v-if="form.fields.email" class="mb-3">
        <label>Email</label>
        <input type="email" v-model="formData.email" class="form-control" required />
      </div>

      <!-- Phone -->
      <div v-if="form.fields.phone" class="mb-3">
        <label>Phone</label>
        <input type="text" v-model="formData.phone" class="form-control" />
      </div>

      <!-- Organisation -->
      <div v-if="form.fields.org" class="mb-3">
        <label>Organisation</label>
        <input type="text" v-model="formData.org" class="form-control" />
      </div>

      <!-- Message -->
      <div v-if="form.fields.message" class="mb-3">
        <label>Message</label>
        <textarea v-model="formData.message" class="form-control"></textarea>
      </div>

      <!-- Custom Fields -->
      <div
        v-for="(field, index) in form.fields.customFields"
        :key="index"
        class="mb-3"
      >
        <label>{{ field.label }}</label>
        <input
          :type="field.type"
          v-model="formData.customFields[index].value"
          class="form-control"
        />
      </div>

      <!-- Centered Submit Button -->
      <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary fw-bolder">Submit</button>
      </div>
    </form>
  </div>
</div>


    <a-card>
      <p class="mt-3 text-success fw-bolder text-center" style="font-size:200%" v-if="submitted">{{form.submit_message}}</p>
    </a-card>
  </div>

  <div v-else>
    <p>Loading form...</p>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
  //     computed: {
  //   formId() {
  //     return this.$route.params.id;
  //   }
  // },
      form: null,
      formData: {
        logo:'',
        fullName: '',
        email: '',
        phone: '',
        org: '',
        message: '',
        customFields: []
      },
      submitted: false
    };
  },
  async created() {
    const formId = this.$route.params.id;

    try {
     const response = await axios.get(`http://127.0.0.1:8000/api/form/${formId}`);
this.form = response.data;

// 👇 Parse fields if stored as JSON string
if (typeof this.form.fields === 'string') {
  this.form.fields = JSON.parse(this.form.fields);
}


      // Initialize custom fields
      if (this.form.fields.customFields) {
        this.formData.customFields = this.form.fields.customFields.map(field => ({
          label: field.label,
          type: field.type,
          value: ''
        }));
      }
    } catch (error) {
      console.error('Error loading form:', error);
    }
  },
  methods: {
    submitForm() {
      console.log('Form submitted:', this.formData);
      this.submitted = true;

      // Optional: Send to backend if you want
      // this.$axios.post('/api/form-submit', this.formData)
    }
  }
};
</script>

<style scoped>
form {
  max-width: 600px;
  margin: auto;
}
</style>
