<template>
    <div>
      <h3>Rate Rider/User</h3>
      <form @submit.prevent="submitRating">
        <label for="rating">Rating (1-5):</label>
        <select v-model="rating" id="rating">
          <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
        </select>
  
        <label for="comment">Comment:</label>
        <input v-model="comment" id="comment" type="text" placeholder="Optional comment" />
  
        <button type="submit">Submit Rating</button>
      </form>
  
      <h3>Average Rating: {{ averageRating }}</h3>
      <ul>
        <li v-for="rate in ratings" :key="rate.id">
          {{ rate.rating }} - {{ rate.comment || 'No comment' }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        rating: null,
        comment: '',
        ratings: [],
        averageRating: null,
      };
    },
    methods: {
      async fetchRatings() {
        const response = await axios.get(`/api/ratings/${this.$route.params.id}`);
        this.ratings = response.data.ratings;
        this.averageRating = response.data.average;
      },
      async submitRating() {
        try {
          await axios.post('/api/ratings', {
            rider_id: this.$route.params.id, // or rated_user_id depending on context
            rating: this.rating,
            comment: this.comment,
          });
          this.fetchRatings();
          this.rating = null;
          this.comment = '';
          alert('Rating submitted successfully!');
        } catch (error) {
          console.error(error);
          alert('Failed to submit rating');
        }
      },
    },
    mounted() {
      this.fetchRatings();
    },
  };
  </script>
  