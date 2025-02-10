<template>
    <div>
      <BookList 
        :books="books" 
        @viewBook="viewBook" 
        @editBook="editBook" 
        @deleteBook="deleteBook"
        @bookAdded="bookAdded"
      />
      
      <BookDetail 
        v-if="selectedBook" 
        :book="selectedBook" 
        @close="closeBook"
      />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import BookList from '../components/BookList.vue';
  import BookDetail from '../components/BookDetails.vue';
  
  const books = ref([]);
  const selectedBook = ref(null);
  
  onMounted(async () => {
    const response = await axios.get('http://127.0.0.1:8000/api/books');
    books.value = response.data;
  });
  
  const bookAdded = (book) => {
    books.value.push(book);
  };
  
  const editBook = async (book) => {
    await axios.put(`http://127.0.0.1:8000/api/books/${book.id}`, book);
  };
  
  const deleteBook = async (id) => {
    await axios.delete(`http://127.0.0.1:8000/api/books/${id}`);
    books.value = books.value.filter(book => book.id !== id);
  };
  
  const viewBook = (book) => {
    selectedBook.value = book;
  };
  
  const closeBook = () => {
    selectedBook.value = null;
  };
  </script>
  