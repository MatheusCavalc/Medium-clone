<script setup>
import EditorLayout from '@/layouts/EditorLayout.vue';
import TagInput from '@/components/TagInput.vue';
import { postStory } from '@/services/functions';
import Paragraph from "@editorjs/paragraph";
import EditorJS from '@editorjs/editorjs';
import ImageTool from '@editorjs/image';
import Header from "@editorjs/header";
import Link from '@editorjs/link';
import List from "@editorjs/list";
import { ref } from 'vue';

const editorOpen = ref(true)

let tags = ref('')
let image = ref('');
let title_preview = ''
let content_preview = ''

const isButtonDisabled = ref(false)

const onFileChange = (e) => {
    image.value = e.target.files[0];
};

const addTags = (tag) => {
    tags.value = tag;
}

function submit() {
    isButtonDisabled.value = true
    editor.save().then((outputData) => {
        let formData = new FormData();
        formData.append('tags', tags.value);
        formData.append('image', image.value);
        formData.append('content', JSON.stringify(outputData));
        formData.append('title_preview', title_preview);
        formData.append('content_preview', content_preview);
        postStory(formData)
    }).catch((error) => {
        isButtonDisabled.value = false
        console.log('Saving failed: ', error)
    });
}

const editor = new EditorJS({
    holder: "editorjs",
    autofocus: true,
    initialBlock: "paragraph",
    minHeight: 30,
    tools: {
        header: {
            class: Header,
            config: {
                placeholder: 'Enter a header',
                levels: [1, 3],
                defaultLevel: 1
            }
        },
        list: {
            class: List
        },
        linkTool: {
            class: Link,
        },
        paragraph: {
            class: Paragraph,
            config: {
                placeholder: "."
            }
        },
        image: {
            class: ImageTool,
            config: {
                endpoints: {
                    byFile: 'http://localhost/api/upload-image', // Your backend file uploader endpoint
                    byUrl: 'http://localhost/api/fetchUrl', // Your endpoint that provides uploading by Url
                }
            }
        }
    }
});

</script>

<template>
    <EditorLayout>
        <div v-show="editorOpen" class="mx-auto mt-2 max-w-7xl sm:px-6 lg:px-28 pb-20">
            <div class="px-32 pt-10 pb-32 overflow-hidden bg-white sm:rounded-lg">

                <div class="bg-white pb-40">
                    <div class="" id="editorjs" />
                </div>

            </div>

            <button @click="editorOpen = false"
                class="px-5 py-2 text-sm font-bold text-white bg-green-600 rounded-full ml-9">
                Publish
            </button>
        </div>

        <div v-show="!editorOpen">
            <nav class="px-2 py-1 bg-white rounded sm:px-4">
                <div class="flex flex-wrap items-center justify-between max-w-full mr-36">
                    <p></p>
                    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                        <ul
                            class="flex flex-col p-4 mt-4 bg-white border border-gray-100 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0">
                            <li>
                                <button @click="editorOpen = true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div>
                <div class="mx-auto mt-20 mb-20 max-w-7xl sm:px-6 lg:px-36">
                    <div class="overflow-hidden bg-white sm:rounded-lg">

                        <div class="grid grid-cols-2 gap-7">
                            <div>
                                <p class="font-semibold">Story Preview</p>

                                <div class="h-48 my-2 w-96">
                                    <div class="flex items-center justify-center">
                                        <label for="dropzone-file"
                                            class="flex flex-col items-center justify-center h-48 rounded-lg cursor-pointer w-96 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                    </path>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                        class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF
                                                    (MAX.
                                                    800x400px)</p>
                                            </div>
                                            <input id="dropzone-file" type="file" @change="onFileChange" class="hidden" />
                                        </label>
                                    </div>
                                </div>

                                <div class="container-confirm">
                                    <div class="my-3">
                                        <input type="text" v-model="title_preview" id="title_preview" maxlength="100"
                                            class="text-gray-900 text-xl block w-full p-2.5 font-bold"
                                            placeholder="Title Preview" required>
                                    </div>
                                    <hr class="h-px -m-2 bg-gray-200 border-0 dark:bg-gray-700">
                                    <div class="my-3">
                                        <input type="text" v-model="content_preview" id="content_preview" maxlength="140"
                                            class="text-gray-900 sm:text-sm block w-full p-2.5"
                                            placeholder="Content Preview" required>
                                    </div>
                                    <hr class="h-px -m-2 bg-gray-200 border-0 dark:bg-gray-700">
                                </div>
                                <p class="mt-5">
                                    Note: Changes here will affect how your story appears in public places like Medium’s
                                    homepage and in subscribers’ inboxes — not the contents of the story itself.
                                </p>
                            </div>

                            <div class="ml-8">
                                <p>Publishing to: <span class="font-semibold">Oi</span></p>

                                <p class="my-2"> Add or change topics (up to 5) so readers know what your story is about</p>

                                <div>
                                    <TagInput @send-data="addTags" />
                                </div>

                                <template v-if="!isButtonDisabled">
                                    <button :disabled="isButtonDisabled" @click="submit"
                                        class="p-3 mt-4 text-sm text-white bg-green-600 rounded-full">
                                        Publish now
                                    </button>
                                </template>

                                <template v-else>
                                    <button disabled type="button"
                                        class="p-3 mt-4 text-sm text-white bg-green-400 rounded-full">
                                        <svg aria-hidden="true" role="status"
                                            class="inline w-4 h-4 mx-1 text-white animate-spin" viewBox="0 0 100 101"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="#E5E7EB" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentColor" />
                                        </svg>
                                        Loading...
                                    </button>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </EditorLayout>
</template>

<style>
h1 {
    font-size: 56px;
    font-weight: 700;
    margin: inherit;
}

h3 {
    font-size: 24px;
    font-weight: 700;
    color: #5d6165;
    margin: 16px 0 8px 0;
}
</style>