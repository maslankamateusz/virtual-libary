<template>
    <div class="book-list">
      <h2>Lista Książek</h2>
      <ul>
        <li v-for="book in books" :key="book.id" class="book-item">
          <div class="book-info">
            <a href="#" @click.prevent="$emit('viewBook', book)">
              {{ book.title }} - {{ book.author }}
            </a>
          </div>
          <div class="book-actions">
            <button @click="$emit('editBook', book)">Edytuj</button>
            <button @click="$emit('deleteBook', book.id)" class="delete-btn">Usuń</button>
          </div>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits } from 'vue';
  import axios from 'axios';
  
  const props = defineProps(['books']);
  const emit = defineEmits(['bookAdded']);
  
  const newBook = ref({ title: '', author: '', publication_year: '', description: '' });
  
  const addBook = async () => {
    const response = await axios.post('http://127.0.0.1:8000/api/books', newBook.value);
    emit('bookAdded', response.data);
    newBook.value = { title: '', author: '', publication_year: '', description: '' };
  };
  </script>
  