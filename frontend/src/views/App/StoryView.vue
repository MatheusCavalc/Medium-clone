<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';
import AuthorInfos from '@/components/AuthorInfos.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.bubble.css';
import { ref, onMounted } from 'vue';
import moment from 'moment';
import { useRoute } from 'vue-router';
import axios from "axios";

const route = useRoute()

let id = route.params.id

let authId = ref('')
let user = ref('')
let is_follow = ref('')
let story = ref('')
let loading = ref('')
let can_follow = ref('')
loading.value = true

const getStory = () => {
    axios.get('http://localhost/api/stories/' + id).then((response) => {
        authId.value = response.data.authId
        user.value = response.data.user
        story.value = response.data.story
        loading.value = false
        is_follow.value = response.data.is_follow
        can_follow.value = response.data.can_follow
    })
}

onMounted(getStory)

</script>

<template>
    <AuthLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-16">
            <div class="bg-white overflow-hidden sm:rounded-lg">

                <template v-if="loading">
                    <div class="text-center h-screen place-items-center">
                        <div role="status" class="mt-48">
                            <LoadingSpinner />
                        </div>
                    </div>
                </template>

                <template v-else>
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
                                <div class="">
                                    <QuillEditor v-model:content="story.title" contentType="html" readOnly="true"
                                        theme="bubble" :toolbar="[[{ 'header': 2 }]]" />
                                </div>

                                <div id="text" class="session-read -mt-1 my-5">
                                    <QuillEditor v-model:content="story.content" contentType="html" readOnly="true"
                                        theme="bubble"
                                        :toolbar="[['bold', 'italic', 'link'], [{ 'header': 1 }, { 'header': 2 }, 'blockquote'], ['image']]" />
                                </div>

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
                                <AuthorInfos :authId="authId" :user="user" :is_follow="is_follow"
                                    :can_follow="can_follow" />
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AuthLayout>
</template>

<style>
.session-read .ql-editor p {
    --x-height-multiplier: 0.375;
    --baseline-multiplier: 0.17;
    font-family: medium-content-serif-font, Georgia, Cambria, "Times New Roman", Times, serif;
    letter-spacing: .01rem;
    font-weight: 400;
    font-style: normal;
    font-size: 22px;
    line-height: 1.58;
    letter-spacing: -.003em;
}
</style>