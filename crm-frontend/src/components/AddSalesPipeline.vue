<template>
  <div class="container mt-5">
    <img :src="require('@/assets/back-image1.jpg')" alt="Background" class="img-fluid mb-3 d-block mx-auto" />
    
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add Sales Pipeline</h5>
      </div>

      <div class="card-body">
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label class="form-label">Deal Title</label>
            <input v-model="form.deal_title" type="text" class="form-control" />
            <div v-if="errors.deal_title" class="text-danger">{{ errors.deal_title[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input v-model="form.customer_name" type="text" class="form-control" />
            <div v-if="errors.customer_name" class="text-danger">{{ errors.customer_name[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Deal Value ($)</label>
            <input v-model="form.deal_value" type="number" class="form-control" />
            <div v-if="errors.deal_value" class="text-danger">{{ errors.deal_value[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Expected Close Date</label>
            <input v-model="form.expected_close_date" type="date" class="form-control" />
            <div v-if="errors.expected_close_date" class="text-danger">{{ errors.expected_close_date[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Sales Stage</label>
            <select v-model="form.sales_stage" class="form-select">
              <option value="" disabled>Select Stage</option>
              <option>Prospecting</option>
              <option>Qualified</option>
              <option>Proposal Sent</option>
              <option>Negotiation</option>
              <option>Won</option>
              <option>Lost</option>
            </select>
            <div v-if="errors.sales_stage" class="text-danger">{{ errors.sales_stage[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Assigned To</label>
            <input v-model="form.assigned_to" type="text" class="form-control" />
            <div v-if="errors.assigned_to" class="text-danger">{{ errors.assigned_to[0] }}</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea v-model="form.notes" class="form-control" rows="3"></textarea>
            <div v-if="errors.notes" class="text-danger">{{ errors.notes[0] }}</div>
          </div>

          <button type="submit" class="btn btn-primary w-100">Save Deal</button>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
import api from '../api'; 

export default {
  name: 'AddSalesPipeline',
  data() {
    return {
      form: {
        deal_title: '',
        customer_name: '',
        deal_value: '',
        expected_close_date: '',
        sales_stage: '',
        assigned_to: '',
        notes: '',
      },
      errors: {} 
    };
  },
  methods: {
    async submitForm() {
      this.errors = {}; 
      try {
        await api.post('pipeline', this.form);
        alert('Pipeline added successfully');

        this.form = {
          deal_title: '',
          customer_name: '',
          deal_value: '',
          expected_close_date: '',
          sales_stage: '',
          assigned_to: '',
          notes: '',
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
