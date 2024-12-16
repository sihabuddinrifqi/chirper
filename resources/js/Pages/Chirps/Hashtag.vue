<script setup>
import Chirp from '@/Components/Chirp.vue'; // Import komponen Chirp

defineProps(['chirps', 'hashtag']);
</script>

<template>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Judul halaman -->
        <h1 class="text-2xl font-semibold mb-4">Chirps with #{{ hashtag }}</h1>

        <!-- Jika ada chirps, tampilkan -->
        <div v-if="chirps.length > 0" class="bg-white shadow-sm rounded-lg divide-y">
            <!-- Gunakan komponen Chirp untuk setiap chirp -->
            <Chirp
                v-for="chirp in chirps"
                :key="chirp.id"
                :chirp="chirp"
            />
        </div>

        <!-- Jika tidak ada chirps -->
        <div v-else>
            <p class="text-gray-500">No chirps found with this hashtag.</p>
        </div>
    </div>
</template>
