<template>
  <div class="container">
    <BookList 
      :books="books" 
      @viewBook="viewBook" 
      @editBook="startEditBook" 
      @deleteBook="deleteBook"
      @bookAdded="bookAdded"
    />

    <div v-if="!selectedBook">
      <h2>{{ editingBook ? "Edytuj książkę" : "Dodaj książkę" }}</h2>
      <form @submit.prevent="editingBook ? updateBook() : addBook()">
        <input v-model="newBook.title" placeholder="Tytuł" required />
        <input v-model="newBook.author" placeholder="Autor" required />
        <input v-model="newBook.publication_year" placeholder="Rok wydania" type="number" required />
        <textarea v-model="newBook.description" placeholder="Opis"></textarea>
        <button type="submit">{{ editingBook ? "Zapisz zmiany" : "Dodaj" }}</button>
        <button v-if="editingBook" type="button" @click="cancelEdit">Anuluj</button>
      </form>
    </div>

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
const editingBook = ref(null);
const newBook = ref({ title: '', author: '', publication_year: '', description: '' });

onMounted(async () => {
  const response = await axios.get('http://127.0.0.1:8000/api/books');
  books.value = response.data;
});

const bookAdded = (book) => {
  books.value.push(book);
};

const startEditBook = (book) => {
  editingBook.value = book;
  newBook.value = { ...book };
};

const updateBook = async () => {
  await axios.put(`http://127.0.0.1:8000/api/books/${editingBook.value.id}`, newBook.value);
  books.value = books.value.map(b => (b.id === editingBook.value.id ? { ...newBook.value, id: b.id } : b));
  cancelEdit();
};

const deleteBook = async (id) => {
  await axios.delete(`http://127.0.0.1:8000/api/books/${id}`);
  books.value = books.value.filter(book => book.id !== id);
};

const addBook = async () => {
  const response = await axios.post('http://127.0.0.1:8000/api/books', newBook.value);
  books.value.push(response.data);
  newBook.value = { title: '', author: '', publication_year: '', description: '' };
};

const viewBook = (book) => {
  selectedBook.value = book;
};

const closeBook = () => {
  selectedBook.value = null;
};

const cancelEdit = () => {
  editingBook.value = null;
  newBook.value = { title: '', author: '', publication_year: '', description: '' };
};
</script>
