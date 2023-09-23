<script setup>
import EditorLayout from '@/layouts/EditorLayout.vue';
import { putStory } from '@/services/functions'
import Paragraph from "@editorjs/paragraph";
import EditorJS from '@editorjs/editorjs';
import ImageTool from '@editorjs/image';
import Header from "@editorjs/header";
import List from "@editorjs/list";
import Link from '@editorjs/link';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from "axios";

const route = useRoute()
let id = route.params.id

let isButtonDisabled = ref(false)

let content = ref('')
let editor;

const getStory = () => {
    axios.get('http://localhost/api/stories/' + id + '/edit').then((response) => {
        content.value = response.data.story.content

        editor = new EditorJS({
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
                            byFile: 'http://localhost/upload-image', // Your backend file uploader endpoint
                            byUrl: 'http://localhost:8008/fetchUrl', // Your endpoint that provides uploading by Url
                        }
                    }
                }
            },
            data: response.data.story.content
        });
    })
}

const putContent = () => {
    isButtonDisabled.value = true
    editor.save().then((outputData) => {
        let parameters = {
            content: JSON.stringify(outputData)
        }
        putStory(id, parameters)
    }).catch((error) => {
        isButtonDisabled.value = false
        console.log('Saving failed: ', error)
    });

}

onMounted(getStory)
</script>

<template>
    <EditorLayout>
        <div class="pb-20 mx-auto mt-2 max-w-7xl sm:px-6 lg:px-28">

            <div class="px-32 pt-10 pb-32 overflow-hidden bg-white sm:rounded-lg">
                <div class="bg-white">
                    <div class="" id="editorjs" />
                </div>
            </div>

            <template v-if="!isButtonDisabled">
                <button :disabled="isButtonDisabled" @click="putContent"
                    class="px-5 py-2 text-sm font-bold text-white bg-green-600 rounded-full ml-9">
                    Publish
                </button>
            </template>

            <template v-else>
                <button :disabled="isButtonDisabled" @click="putContent"
                    class="px-5 py-2 text-sm font-bold text-white bg-green-400 rounded-full ml-9">
                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 mx-1 text-white animate-spin"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
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
    </EditorLayout>
</template>

<style>
.title .ql-editor p {
    --x-height-multiplier: 0.375;
    --baseline-multiplier: 0.17;
    font-family: medium-content-serif-font, Georgia, Cambria, "Times New Roman", Times, serif;
    letter-spacing: .01rem;
    font-weight: 400;
    font-style: normal;
    font-size: 21px;
    line-height: 1.58;
    letter-spacing: -.003em;
}

.session-write .ql-editor p {
    --x-height-multiplier: 0.375;
    --baseline-multiplier: 0.17;
    font-family: medium-content-serif-font, Georgia, Cambria, "Times New Roman", Times, serif;
    letter-spacing: .01rem;
    font-weight: 400;
    font-style: normal;
    font-size: 21px;
    line-height: 1.58;
    letter-spacing: -.003em;
}

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