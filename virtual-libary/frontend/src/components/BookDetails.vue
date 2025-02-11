<template>
    <div v-if="book">
      <div class="book-details-container">
        <h2>{{ book.title }}</h2>
        <p><strong>Autor:</strong> {{ book.author }}</p>
        <p><strong>Rok wydania:</strong> {{ book.publication_year }}</p>
        <p><strong>Opis:</strong> {{ book.description }}</p>
      </div>

      <div class="review-container">
        <h3>Recenzje:</h3>
            <ul v-if="reviews.length > 0">
            <li v-for="review in reviews" :key="review.id" class="review-item">
                <div class="review-content">
                <strong>{{ review.reviewer_name }}</strong> ({{ review.rating }}⭐): 
                {{ review.content }}
                </div>
                <div class="book-actions">
                    <button @click="editReview(review)">Edytuj</button>
                    <button @click="deleteReview(review.id)" class="delete-btn">Usuń</button>
                </div>
            </li>
            </ul>
            <p v-else>Brak recenzji.</p>
        </div>
        <div class="edit-review-container">
            <h4>{{ editingReview ? 'Edytuj recenzję' : 'Dodaj recenzję' }}</h4>
            <form @submit.prevent="editingReview ? updateReview() : addReview()">
                <input v-model="reviewForm.reviewer_name" placeholder="Imię" required />
                <input v-model="reviewForm.rating" type="number" min="1" max="5" placeholder="Ocena" required />
                <textarea v-model="reviewForm.content" placeholder="Treść recenzji" required></textarea>
                <button type="submit">{{ editingReview ? 'Zapisz zmiany' : 'Dodaj recenzję' }}</button>
                <button type="button" v-if="editingReview" @click="cancelEdit">Anuluj</button>
            </form>
        </div>

      
      
  
      <button @click="closeBook">Zamknij</button>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, watch, defineProps, defineEmits } from 'vue';
  import axios from 'axios';
  
  const props = defineProps(['book']);
  const emit = defineEmits(['close']);
  const reviews = ref([]);
  const editingReview = ref(null);
  const reviewForm = ref({
    reviewer_name: '',
    rating: 5,
    content: ''
  });
  
  const fetchReviews = async () => {
    if (props.book) {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/books/${props.book.id}/reviews`);
        reviews.value = response.data;
      } catch (error) {
        console.error("Błąd podczas pobierania recenzji:", error);
      }
    }
  };
  
  onMounted(fetchReviews);
  watch(() => props.book, fetchReviews, { deep: true });
  
  const addReview = async () => {
    try {
      const response = await axios.post(`http://127.0.0.1:8000/api/reviews`, {
        ...reviewForm.value,
        book_id: props.book.id
      });
      reviews.value.push(response.data);
      resetForm();
    } catch (error) {
      console.error("Błąd podczas dodawania recenzji:", error);
    }
  };
  
  const editReview = (review) => {
    editingReview.value = review;
    reviewForm.value = { ...review };
  };
  
  const updateReview = async () => {
    try {
      await axios.put(`http://127.0.0.1:8000/api/reviews/${editingReview.value.id}`, reviewForm.value);
      fetchReviews();
      resetForm();
    } catch (error) {
      console.error("Błąd podczas aktualizacji recenzji:", error);
    }
  };
  
  const deleteReview = async (id) => {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/reviews/${id}`);
      fetchReviews();
    } catch (error) {
      console.error("Błąd podczas usuwania recenzji:", error);
    }
  };
  
  const resetForm = () => {
    reviewForm.value = { reviewer_name: '', rating: 5, content: '' };
    editingReview.value = null;
  };
  
  const cancelEdit = () => {
    resetForm();
  };
  
  const closeBook = () => {
    emit('close');
  };
  </script>
  