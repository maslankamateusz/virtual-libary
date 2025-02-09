<template>
    <div>
      <h2>Lista Książek</h2>
      <ul>
        <li v-for="book in books" :key="book.id">
          <a href="#" @click.prevent="$emit('viewBook', book)"> {{ book.title }} - {{ book.author }}</a>
          <button @click="$emit('editBook', book)">Edytuj</button>
          <button @click="$emit('deleteBook', book.id)">Usuń</button>
        </li>
      </ul>
  
      <h3>Dodaj książkę</h3>
      <input v-model="newBook.title" placeholder="Tytuł" />
      <input v-model="newBook.author" placeholder="Autor" />
      <input v-model="newBook.publication_year" placeholder="Rok wydania" type="number" />
      <textarea v-model="newBook.description" placeholder="Opis"></textarea>
      <button @click="addBook">Dodaj</button>
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
  