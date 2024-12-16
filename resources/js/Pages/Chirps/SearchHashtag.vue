<template>
    <div>
      <form @submit.prevent="searchHashtag">
        <input v-model="hashtagSearch" type="text" placeholder="Search Hashtags" />
        <button type="submit">Search</button>
      </form>
  
      <div v-if="chirps.length > 0">
        <div v-for="chirp in chirps" :key="chirp.id">
          <p>{{ chirp.message }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        hashtagSearch: '',
        chirps: []
      }
    },
    methods: {
      searchHashtag() {
        if (this.hashtagSearch) {
          this.$inertia.visit(`/chirps/hashtag/${this.hashtagSearch}`);
        }
      }
    }
  }
  </script>
  