<template>
  <div class="container mt-5">
    <img :src="require('@/assets/back-image1.jpg')" alt="Background" class="img-fluid mb-3 d-block mx-auto" />
    
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add Lead</h5>
      </div>

      <div class="card-body">
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input v-model="form.full_name" type="text" class="form-control" />
            <div v-if="errors.full_name" class="text-danger">{{ errors.full_name[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input v-model="form.email" type="text" class="form-control" />
            <div v-if="errors.email" class="text-danger">{{ errors.email[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input v-model="form.phone" type="number" class="form-control" />
            <div v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Company</label>
            <input v-model="form.company" type="text" class="form-control" />
            <div v-if="errors.company" class="text-danger">{{ errors.company[0] }}</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Job Title</label>
            <input v-model="form.job_title" type="text" class="form-control" />
            <div v-if="errors.job_title" class="text-danger">{{ errors.job_title[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Lead Source</label>
            <select v-model="form.lead_source" class="form-select">
              <option value="" disabled>Select Lead Source</option>
              <option>Website</option>
              <option>Referral</option>
              <option>Social</option>
              <option>Media</option>
              <option>Event</option>
              <option>Other</option>
            </select>
            <div v-if="errors.lead_source" class="text-danger">{{ errors.lead_source[0] }}</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select v-model="form.status" class="form-select">
              <option value="" disabled>Select Status</option>
              <option>New</option>
              <option>Contacted</option>
              <option>Qualified</option>
              <option>Lost</option>
            </select>
            <div v-if="errors.status" class="text-danger">{{ errors.status[0] }}</div>
          </div>

          

          <div class="mb-3">
            <label class="form-label">Assigned-To</label>
            <input v-model="form.assigned_to" type="text" class="form-control" />
            <div v-if="errors.assigned_to" class="text-danger">{{ errors.assigned_to[0] }}</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea v-model="form.notes" class="form-control" rows="3"></textarea>
            <div v-if="errors.notes" class="text-danger">{{ errors.notes[0] }}</div>
          </div>
          <button type="submit" class="btn btn-primary w-100">Save Lead</button>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
import api from '../api'; 

export default {
  name: 'LeadForm',
  data() {
    return {
      form: {
        full_name: '',
        email: '',
        phone: '',
        company: '',
        job_title: '',
        lead_source: '',
        status: '',
        assigned_to:'',
        notes:'',
      },
      errors: {} 
    };
  },
  methods: {
    async submitForm() {
      this.errors = {}; 
      try {
        await api.post('/lead', this.form);
        alert('Lead added successfully');

        this.form = {
          full_name: '',
          email: '',
          phone: '',
          company: '',
          job_title: '',
          lead_source: '',
          status: '',
          assigned_to:'',
          notes:''
        };
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          alert('Something went wrong. Please try again.');
        }
      }
    }
  }
};
</script>

<style scoped>
.text-danger {
  font-size: 0.9rem;
}
</style>

