<template>
    <p class="text-center mb-6 text-primary" v-if="loggedInUser">
      Hello {{ loggedInUser.name }}
    </p>
    <h2 class="text-center mb-6 text-primary" v-if="loggedInUser">Welcome to {{loggedInUser.name}}!</h2>
    <h2>Getting Started</h2>
    <br>
  <div class="container" :style="backgroundStyle">
    
    <h1 class="text-center mb-6 text-primary">List Of Registered Users</h1>

    <table class="table table-striped mt-4">
      <thead>
        <tr>
          <th class="text-primary">Sl</th>
          <th class="text-primary">Name</th>
          <th class="text-primary">Email</th>
          <th class="text-primary">Delete</th>
          <th class="text-primary">Edit</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in users" :key="user.id">
          <td class="text-primary fw-bolder">{{ index + 1 }}</td>
          <td class="text-primary fw-bolder">{{ user.name }}</td>
          <td class="text-primary fw-bolder">{{ user.email }}</td>
          <td>
            <button type="button" @click="deleteUser(user.id)" class="btn btn-danger">Delete</button>
          </td>
          <td>
            <button type="button" @click="openEditModal(user)" class="btn btn-success">Edit</button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="error" class="text text-danger">{{ error }}</p>

    <div v-if="isEditModalVisible" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
            <button type="button" class="close" @click="closeEditModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateUser">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" v-model="editUserData.name" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="editUserData.email" class="form-control" required />
              </div>
              <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../api'; 
import bgImage from '@/assets/back-image1.jpg';

export default {
  data() {
    return {
      users: [],
      loggedInUser: null, 
      error: '',
      isEditModalVisible: false,
      editUserData: {
        id: null,
        name: '',
        email: ''
      }
    };
  },
  computed: {
    backgroundStyle() {
      return {
        backgroundImage: `url(${bgImage})`,
        backgroundSize: "cover",
        backgroundRepeat: "no-repeat",
        backgroundPosition: "center",
        minHeight: "100vh"
      };
    }
  },
  mounted() {
    this.fetchUsers();
    this.fetchLoggedInUser();
  },
  methods: {
    async fetchUsers() {
      try {
        const token = localStorage.getItem('api-token');
        const response = await api.get('/users', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.users = response.data;
      } catch (error) {
        this.error = "There is an error in fetching the user data";
      }
    },

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

    async deleteUser(id) {
      if (!confirm('Are you sure you want to delete the user?')) return;
      try {
        const token = localStorage.getItem('api-token');
        await api.delete(`/users/${id}`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.fetchUsers();
      } catch (error) {
        this.error = 'Failed to delete the user';
      }
    },

    openEditModal(user) {
      this.editUserData = {
        id: user.id,
        name: user.name,
        email: user.email
      };
      this.isEditModalVisible = true;
    },

    closeEditModal() {
      this.isEditModalVisible = false;
      this.editUserData = {
        id: null,
        name: '',
        email: ''
      };
    },

    async updateUser() {
      try {
        const token = localStorage.getItem('api-token');
        const { id, name, email } = this.editUserData;

        await api.put(`/users/${id}`, { name, email }, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.closeEditModal();
        this.fetchUsers();
      } catch (error) {
        this.error = 'Failed to update user';
      }
    }
  }
};
</script>

<style scoped>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-dialog {
  max-width: 500px;
}
</style>
