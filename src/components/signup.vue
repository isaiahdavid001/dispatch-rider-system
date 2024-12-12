<template>
    <div>
      <h2>Signup</h2>
      <form @submit.prevent="signup">
        <input v-model="name" placeholder="Name" required />
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <button type="submit">Signup</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
      };
    },
    methods: {
      async signup() {
        try {
          const response = await axios.post('http://localhost:8000/api/register', {
            name: this.name,
            email: this.email,
            password: this.password,
          });
          alert(response.data.message);
        } catch (error) {
          console.error(error.response.data);
        }
      },
    },
  };
  </script>
  