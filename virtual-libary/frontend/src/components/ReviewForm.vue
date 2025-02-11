<template>
  <div>
    <input v-model="newReview.reviewer_name" placeholder="Twoje imię" />
    <input v-model="newReview.rating" type="number" min="1" max="5" placeholder="Ocena (1-5)" />
    <textarea v-model="newReview.content" placeholder="Treść recenzji"></textarea>
    <button @click="addReview">Dodaj recenzję</button>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import axios from 'axios';

const props = defineProps(['bookId']);
const emit = defineEmits(['reviewAdded']);
const newReview = ref({ reviewer_name: '', rating: '', content: '' });

const addReview = async () => {
  await axios.post(`http://127.0.0.1:8000/api/books/${props.bookId}/reviews`, newReview.value);
  newReview.value = { reviewer_name: '', rating: '', content: '' };
  emit('reviewAdded');
};
</script>
