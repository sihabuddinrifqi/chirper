<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Chirp from '@/Components/Chirp.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import WYSIWYGEditor from '@/Components/WysiwygEditor.vue'; // Import komponen WYSIWYGEditor
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['chirps']);

const form = useForm({
    message: '', // Kolom pesan untuk chirp
    image: null, // Tambahkan properti untuk gambar
});

// Fungsi untuk menangani perubahan pada input file
const handleFileUpload = (event) => {
    form.image = event.target.files[0]; // Simpan file ke form
};

// Fungsi untuk parsing hashtag
const parseHashtags = (message) => {
    return message.replace(/#(\w+)/g, '<a href="/chirps/hashtag/$1">#$1</a>');
};
</script>

<template>
    <Head title="Chirps" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <!-- Formulir tambah chirp -->
            <form 
                @submit.prevent="form.post(route('chirps.store'), { 
                    onSuccess: () => form.reset() 
                })"
            >
                <!-- WYSIWYG Editor menggantikan textarea -->
                <WYSIWYGEditor
                    v-model="form.message"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <InputError :message="form.errors.message" class="mt-2" />

                <!-- Input file untuk gambar -->
                <input 
                    type="file" 
                    class="block mt-4 w-full text-gray-500"
                    @change="handleFileUpload"
                    accept="image/*"
                />
                <InputError :message="form.errors.image" class="mt-2" />

                <!-- Tombol submit -->
                <PrimaryButton class="mt-4">Chirp</PrimaryButton>
            </form>

            <!-- Daftar chirps -->
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Chirp
                    v-for="chirp in chirps"
                    :key="chirp.id"
                    :chirp="chirp"
                />
            </div>
            
        </div>
    </AuthenticatedLayout>
</template>
