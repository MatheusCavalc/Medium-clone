<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';
import HeaderProfile from '@/components/HeaderProfile.vue';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from "axios";
import moment from 'moment';

const route = useRoute()

let username = route.params.username
let loading = ref(true)
let user = ref('')
let stories = ref('')
let is_follow = ref('')
let can_follow = ref('')
let button_label = ref('')

const getUser = () => {
    axios.get('http://localhost/api/' + username).then((response) => {
        user.value = response.data.user
        stories.value = response.data.stories
        is_follow.value = response.data.is_follow
        can_follow.value = response.data.can_follow
        loading.value = false
        button_label.value = response.data.is_follow ? 'Unfollow' : 'Follow'
    })
}

const follow = () => {
    event.preventDefault()
    axios.post('http://localhost/api/follows', {
        userId: user.value.id,
    }).then(() => {
        button_label.value = 'Unfollow'
        is_follow.value = true
    }).catch(error => {
        console.log(error)
    });
}

const unfollow = () => {
    event.preventDefault()
    axios.post('http://localhost/api/unfollows', {
        userId: user.value.id,
    }).then(() => {
        button_label.value = 'Follow'
        is_follow.value = false
    }).catch(error => {
        console.log(error)
    });
}

onMounted(getUser)
</script>

<template>
    <AuthLayout>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-20">
            <div class="bg-white sm:rounded-lg">
                <div class="grid grid-cols-3 gap-12">

                    <div class="col-span-2 mt-14">

                        <template v-if="loading">
                            <LoadingSpinner />
                        </template>

                        <template v-else>
                            <div class="flex justify-between">
                                <p class="block text-5xl font-medium tracking-tight">{{ user.name }}</p>

                                <p
                                    class="relative block font-medium tracking-tighter text-2xl text-gray-500 hover:text-black pr-16">
                                    ...
                                </p>
                            </div>

                            <HeaderProfile />

                            <div v-for="story in stories" :key="story.id" class="mt-12 border-b border-b-gray-200 pb-12">
                                <p class="text-gray-500">{{ moment(story.created_at).format('MMMM D,YYYY') }}</p>
                                <router-link :to="{ path: 'story/' + story.slug + '/' + story.id }">
                                    <p class="mt-5 text-3xl font-extrabold tracking-tighter">{{ story.title_preview }}</p>
                                </router-link>
                                <p class="mt-8 mb-10 text-lg">{{ story.content_preview }}</p>

                                <span class="bg-gray-100 text-gray-800 text-xs mr-2 px-2.5 py-1 rounded-lg">
                                    {{ story.tags[0] }}
                                </span>
                            </div>
                        </template>
                    </div>

                    <div class="border-l border-l-gray-200 h-screen">
                        <div class="mt-9 ml-10 mr-3">
                            <p>
                                <img class="h-24 w-24 rounded-full"
                                    src="https://avatars.githubusercontent.com/u/105112560?v=4" alt="sexmaster" />
                            </p>

                            <p class="mt-4 font-medium">
                                {{ user.name }}
                            </p>

                            <p class="mt-1 text-gray-500">
                                744 Followers
                            </p>

                            <p class="mt-3 text-gray-500 text-sm tracking-tight">
                                {{ user.bio }}
                            </p>

                            <div v-if="can_follow" class="flex mt-5">
                                <template v-if="is_follow">
                                    <button @click="unfollow"
                                        class="block px-4 py-2 text-base tracking-tighter text-green-600 bg-white border border-green-600 rounded-full">
                                        {{ button_label }}
                                    </button>
                                </template>

                                <template v-else>
                                    <button @click="follow"
                                        class="block px-4 py-2 text-base tracking-tighter text-white bg-green-600 rounded-full">
                                        {{ button_label }}
                                    </button>
                                </template>

                                <button
                                    class="block ml-2 px-2.5 py-1 text-base tracking-tight text-white bg-green-600 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>