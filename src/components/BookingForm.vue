<template>
    <div>
      <h2>Make a Booking</h2>
      <form @submit.prevent="createBooking">
        <input v-model="pickupLocation" placeholder="Pickup Location" required />
        <input v-model="dropoffLocation" placeholder="Drop-off Location" required />
        <button type="submit">Create Booking</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        pickupLocation: '',
        dropoffLocation: '',
      };
    },
    methods: {
      async createBooking() {
        try {
          const token = localStorage.getItem('token'); // Get the user's token
          const response = await axios.post(
            'http://localhost:8000/api/booking',
            {
              pickup_location: this.pickupLocation,
              dropoff_location: this.dropoffLocation,
            },
            {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            }
          );
          alert('Booking created successfully');
        } catch (error) {
          console.error(error.response.data);
        }
      },
    },
  };
  </script>
  