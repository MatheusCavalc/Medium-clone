<script setup>
//import LoadingSpinner from '@/components/LoadingSpinner.vue';
import AuthorInfos from '@/components/AuthorInfos.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import Paragraph from "@editorjs/paragraph";
import EditorJS from '@editorjs/editorjs';
import ImageTool from '@editorjs/image';
import { useRoute } from 'vue-router';
import Header from "@editorjs/header";
import { ref, onMounted } from 'vue';
import List from "@editorjs/list";
import Link from '@editorjs/link';
import moment from 'moment';
import axios from "axios";

const route = useRoute()
let id = route.params.id

let authId = ref('')
let user = ref('')
let is_follow = ref('')
let story = ref([])
//let loading = ref('')
let can_follow = ref('')
let content = ref('')
//loading.value = true

const getStory = () => {
    axios.get('http://localhost/api/stories/' + id).then((response) => {
        authId.value = response.data.authId
        user.value = response.data.user
        story.value = response.data.story
        //loading.value = false
        is_follow.value = response.data.is_follow
        can_follow.value = response.data.can_follow
        content.value = response.data.story.content

        /* eslint-disable */
        const editor = new EditorJS({
            holder: 'editorjs',
            readOnly: true,
            minHeight: 30,
            tools: {
                header: Header,
                list: List,
                linkTool: Link,
                paragraph: Paragraph,
                image: ImageTool,
            },
            data: content.value
        });
    })
}

onMounted(() => {
    getStory();
})
</script>

<template>
    <AuthLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-16">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="grid grid-cols-3 gap-10">
                    <div class="col-span-2 mt-14">
                        <div class="flex flex-row items-left">
                            <p class="ml-4 block">
                                <img class="h-12 w-12 rounded-full"
                                    src="https://avatars.githubusercontent.com/u/105112560?v=4" alt="sexmaster" />
                            </p>
                            <div class="absolute ml-20">
                                <template v-if="authId == user.id">
                                    <router-link to="/profile">
                                        <p class="block">{{ user.name }}</p>
                                    </router-link>
                                </template>

                                <template v-else>
                                    <router-link :to="'/' + user.username">
                                        <p class="block">{{ user.name }}</p>
                                    </router-link>
                                </template>

                                <p class="mt-0.5 text-gray-500">{{ moment(story.created_at).format('MMM D, YYYY') }}</p>
                            </div>
                        </div>
                        <div class="my-7">
                            <div class="bg-white rounded-lg" id="editorjs" :readonly="true" />

                            <div class="ml-2 mt-6">
                                <span v-for="tag in story.tags" :key="tag.id"
                                    class="bg-gray-100 text-gray-800 text-sm mr-2 px-2.5 py-2 rounded-full">
                                    {{ tag }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-l border-l-gray-200 h-screen">
                        <div class="mt-28 ml-10 mr-3">
                            <AuthorInfos :authId="authId" :user="user" :is_follow="is_follow" :can_follow="can_follow" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
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
