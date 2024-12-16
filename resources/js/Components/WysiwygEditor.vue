<script setup>
import { onMounted, ref } from 'vue';
import 'quill/dist/quill.snow.css';
import Quill from 'quill';
import { OrderedList } from '@tiptap/extension-ordered-list';

const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue']);

const editorRef = ref(null);
let quill;

onMounted(() => {
    quill = new Quill(editorRef.value, {
        theme: 'snow',
        placeholder: 'Start writing here...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],        // Teks formatting
                [{ header: 1 }, { header: 2 }],                   // Header
                [{ list: 'ordered' }, { list: 'bullet' }],        // List
                ['link', 'image'],                                // Media
                ['clean'],                                        // Clear formatting
            ],
        },
    });

    // Sync editor content with parent component
    quill.on('text-change', () => {
        emit('update:modelValue', quill.root.innerHTML);
    });

    // Set initial value
    quill.root.innerHTML = props.modelValue || '';
});
</script>

<template>
    <div ref="editorRef" class="wysiwyg-editor"></div>
</template>

<style>
.wysiwyg-editor {
    min-height: 150px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    background: #fff;
}
</style>
