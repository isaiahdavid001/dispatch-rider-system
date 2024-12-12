<template>
    <div>
      <h2>Your Bookings</h2>
      <ul>
        <li v-for="booking in bookings" :key="booking.id">
          <div>
            <strong>Pickup:</strong> {{ booking.pickup_location }} <br>
            <strong>Drop-off:</strong> {{ booking.dropoff_location }} <br>
            <strong>Status:</strong>
            <span v-if="booking.status === 'pending'">Pending</span>
            <span v-if="booking.status === 'accepted'">Accepted</span>
            <span v-if="booking.status === 'completed'">Completed</span>
          </div>
  
          <!-- If booking is pending, show 'Accept Booking' button -->
          <button v-if="booking.status === 'pending'" @click="acceptBooking(booking.id)">
            Accept Booking
          </button>
  
          <!-- If booking is accepted, show 'Mark as Received' button -->
          <button v-if="booking.status === 'accepted'" @click="completeBooking(booking.id)">
            Mark as Received
          </button>
  
          <!-- If booking is completed, show a message indicating completion -->
          <span v-if="booking.status === 'completed'">Booking Completed</span>
  
          <!-- Show Google map for Pickup and Dropoff locations -->
          <div v-if="booking.status === 'accepted' || booking.status === 'completed'">
            <GoogleMap
              :center="{lat: pickupLocation.lat, lng: pickupLocation.lng}"
              :zoom="12"
              style="height: 400px; width: 100%;"
            >
              <!-- Marker for Pickup Location -->
              <GmapMarker :position="{lat: pickupLocation.lat, lng: pickupLocation.lng}" />
              <!-- Marker for Drop-off Location -->
              <GmapMarker :position="{lat: dropoffLocation.lat, lng: dropoffLocation.lng}" />
            </GoogleMap>
          </div>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { GoogleMap, GmapMarker } from 'vue2-google-maps';
  
  export default {
    components: {
      GoogleMap,
      GmapMarker,
    },
    data() {
      return {
        bookings: [],
        pickupLocation: { lat: 0, lng: 0 },
        dropoffLocation: { lat: 0, lng: 0 },
      };
    },
    created() {
      this.fetchBookings();
    },
    methods: {
      // Fetch user's bookings from the API
      async fetchBookings() {
        const token = localStorage.getItem('token'); // Get the stored token
        try {
          const response = await axios.get('http://localhost:8000/api/bookings', {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.bookings = response.data;
        } catch (error) {
          console.error('Error fetching bookings:', error.response.data);
        }
      },
  
      // Accept a booking (user accepts a pending booking)
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
          alert('Booking accepted!');
          this.fetchBookings(); // Refresh the bookings list
        } catch (error) {
          console.error('Error accepting booking:', error.response.data);
        }
      },
  
      // Mark booking as completed (user receives item)
      async completeBooking(bookingId) {
        const token = localStorage.getItem('token');
        try {
          await axios.post(
            `http://localhost:8000/api/booking/${bookingId}/complete`,
            {},
            {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            }
          );
          alert('Booking marked as completed!');
          this.fetchBookings(); // Refresh the bookings list
        } catch (error) {
          console.error('Error completing booking:', error.response.data);
        }
      },
  
      // Update the pickup and dropoff locations when a booking is accepted
      updateMapCoordinates(booking) {
        // Example: You can fetch coordinates from your API or use a geocoding service.
        this.pickupLocation = { lat: parseFloat(booking.pickup_lat), lng: parseFloat(booking.pickup_lng) };
        this.dropoffLocation = { lat: parseFloat(booking.dropoff_lat), lng: parseFloat(booking.dropoff_lng) };
      }
    },
    watch: {
      bookings: function(newBookings) {
        // Assuming booking contains lat/lng fields for pickup and dropoff
        if (newBookings.length > 0) {
          const firstBooking = newBookings[0]; // You can customize this logic based on your data
          this.updateMapCoordinates(firstBooking);
        }
      },
    }
  };
  </script>
  
  <style scoped>
  button {
    margin-top: 10px;
    padding: 8px 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }
  
  button:hover {
    background-color: #45a049;
  }
  
  span {
    font-weight: bold;
    color: #007bff;
  }
  </style>
  