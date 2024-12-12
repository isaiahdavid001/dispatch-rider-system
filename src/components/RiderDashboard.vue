<template>
    <div>
      <h2>Pending Bookings</h2>
      <ul>
        <li v-for="booking in pendingBookings" :key="booking.id">
          {{ booking.pickup_location }} -> {{ booking.dropoff_location }}
          <button @click="acceptBooking(booking.id)">Accept</button>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        pendingBookings: [],
      };
    },
    created() {
      this.fetchPendingBookings();
    },
    methods: {
      async fetchPendingBookings() {
        const token = localStorage.getItem('token');
        try {
          const response = await axios.get('http://localhost:8000/api/pending-bookings', {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.pendingBookings = response.data;
        } catch (error) {
          console.error(error.response.data);
        }
      },
      async acceptBooking(bookingId) {
        const token = localStorage.getItem('token');
        try {
          await axios.post(
            `http://localhost:8000/api/booking/${bookingId}/accept`,
            {},
            {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            }
          );
          alert('Booking accepted');
          this.fetchPendingBookings(); // Refresh the list of pending bookings
        } catch (error) {
          console.error(error.response.data);
        }
      },
    },
  };
  </script>
  