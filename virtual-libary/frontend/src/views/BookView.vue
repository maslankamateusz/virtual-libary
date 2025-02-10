<template>
    <div v-if="book">
      <h1>{{ book.title }}</h1>
      <p><strong>Autor:</strong> {{ book.author }}</p>
      <p><strong>Rok wydania:</strong> {{ book.publication_year }}</p>
      <p><strong>Opis:</strong> {{ book.description }}</p>
  
      <h2>Recenzje</h2>
      <ul>
        <li v-for="review in reviews" :key="review.id">
          <strong>{{ review.reviewer_name }}</strong>: {{ review.content }} ({{ review.rating }}⭐)
        </li>
      </ul>
  
      <h2>Dodaj recenzję</h2>
      <form @submit.prevent="addReview">
        <input v-model="newReview.reviewer_name" placeholder="Twoje imię" required />
        <input v-model="newReview.rating" type="number" min="1" max="5" placeholder="Ocena (1-5)" required />
        <textarea v-model="newReview.content" placeholder="Treść recenzji" required></textarea>
        <button type="submit">Dodaj recenzję</button>
      </form>
    </div>
  </template>
  
  <script lang="ts">
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useRoute } from 'vue-router';
  
  export default {
    setup() {
      const route = useRoute();
      const book = ref(null);
      const reviews = ref([]);
      const newReview = ref({ reviewer_name: '', rating: 5, content: '' });
  
      const fetchBook = async () => {
        const response = await axios.get(`http://127.0.0.1:8000/api/books/${route.params.id}`);
        book.value = response.data;
      };
  
      const fetchReviews = async () => {
        const response = await axios.get(`http://127.0.0.1:8000/api/books/${route.params.id}/reviews`);
        reviews.value = response.data;
      };
  
      const addReview = async () => {
        await axios.post('http://127.0.0.1:8000/api/reviews', {
          book_id: route.params.id,
          reviewer_name: newReview.value.reviewer_name,
          rating: newReview.value.rating,
          content: newReview.value.content
        });
        newReview.value = { reviewer_name: '', rating: 5, content: '' };
        fetchReviews();
      };
  
      onMounted(() => {
        fetchBook();
        fetchReviews();
      });
  
      return { book, reviews, newReview, addReview };
    }
  };
  </script>
  