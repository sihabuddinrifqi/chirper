<script setup>
import 'quill/dist/quill.snow.css';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import WysiwygEditor from '@/Components/WysiwygEditor.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

dayjs.extend(relativeTime);

const props = defineProps(['chirp']);

const form = useForm({
    message: props.chirp.message,
    image: null, // Properti untuk file gambar
});

const editing = ref(false);

// Fungsi untuk menangani perubahan pada input file
const handleFileUpload = (event) => {
    form.image = event.target.files[0]; // Simpan file ke form
};

// Fungsi untuk mendeteksi dan mengganti hashtags dengan link
const formattedMessage = (message) => {
    // Menggunakan regex untuk menemukan kata yang dimulai dengan #
    return message.replace(/#(\w+)/g, (match, hashtag) => {
        // Mengganti hashtag dengan link yang mengarah ke pencarian hashtag
        return `<a href="/chirps/hashtag/${hashtag}" class="text-blue-500">#${hashtag}</a>`;
    });
};
</script>

<template>
    <div class="p-6 flex space-x-2">
        <!-- Avatar Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>

        <div class="flex-1">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800">{{ chirp.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs(chirp.created_at).fromNow() }}</small>
                    <small v-if="chirp.created_at !== chirp.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>

                <!-- Dropdown for Edit/Delete -->
                <Dropdown v-if="chirp.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('chirps.destroy', chirp.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>

            <!-- Edit Form -->
            <form v-if="editing" @submit.prevent="form.put(route('chirps.update', chirp.id), { onSuccess: () => editing = false })">
                <!-- WYSIWYG Editor -->
                <WysiwygEditor v-model="form.message" />
                <InputError :message="form.errors.message" class="mt-2" />

                <!-- Input file untuk gambar -->
                <input
                    type="file"
                    class="mt-4 w-full text-gray-500"
                    @change="handleFileUpload"
                    accept="image/*"
                />
                <InputError :message="form.errors.image" class="mt-2" />

                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>

            <!-- Tampilkan Chirp -->
            <div v-else>
                <!-- Tampilkan konten WYSIWYG -->
                <div v-html="formattedMessage(chirp.message)" class="mt-4 text-lg text-gray-900"></div>
                <!-- Tampilkan gambar jika ada -->
                <img
                    v-if="chirp.image"
                    :src="`/storage/${chirp.image}`"
                    alt="Chirp Image"
                    class="mt-4 rounded-lg"
                />
            </div>
        </div>
    </div>
</template>
