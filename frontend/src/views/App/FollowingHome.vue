<script setup>
import { ref, onMounted } from 'vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';
import ToWrite from '@/components/ToWrite.vue';
import HeaderHome from '@/components/HeaderHome.vue';
import axios from 'axios';
import moment from 'moment';

const currentPage = ref(1);
let stories = ref('')

let loading = ref(false)
let loadingPage = ref(true)

let arrayLength = ref('')

const getStories = async () => {
    try {
        loading.value = true;
        const response = await axios.get('http://localhost/api/following?page=1', {
            params: {
                perPage: 3,
                page: currentPage.value,
            },
        });
        stories.value = [...stories.value, ...response.data.data];
        loadingPage.value = false

        currentPage.value++;
        loading.value = false;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {

    getStories();
    window.addEventListener('scroll', () => {
        if (arrayLength.value != stories.value.length) {
            if (
                window.innerHeight + window.scrollY >=
                document.documentElement.scrollHeight
            ) {
                arrayLength.value = stories.value.length
                getStories();
            }
        }
    });
})
</script>

<template>
    <AuthLayout>
        <div class="mx-auto mt-5 max-w-7xl sm:px-6 lg:px-16">
            <div class="bg-white sm:rounded-lg">

                <template v-if="loadingPage">
                    <div class="text-center h-screen place-items-center">
                        <div role="status" class="mt-48">
                            <LoadingSpinner />
                        </div>
                    </div>
                </template>

                <template v-else>
                    <div class="grid grid-cols-3 gap-11">
                        <div class="col-span-2">

                            <HeaderHome />

                            <div v-for="story in stories" :key="story.id"
                                class="overflow-hidden border-b border-b-gray-200 mt-11 mb-7 ml-4 mr-16">
                                <div class="flex flex-row items-left">
                                    <p class="block">
                                        <img class="w-6 h-6 rounded-full"
                                            src="https://avatars.githubusercontent.com/u/105112560?v=4" alt="sexmaster" />
                                    </p>
                                    <router-link :to="'/' + story.username">
                                        <p class="block ml-2 text-sm">{{ story.name }}</p>
                                    </router-link>
                                    <p class="block mx-1 -my-1 text-gray-500">.</p>
                                    <p class="block text-sm text-gray-500">{{ moment(story.created_at).format('MMMM D, YYYY') }}</p>
                                </div>

                                <router-link :to="{ path: 'story/' + story.slug + '/' + story.id }" class="cursor-pointer">
                                    <div class="flex mt-2 mb-8 overflow-hidden">
                                        <div class="flex-initial">
                                            <div class="container-home">
                                                <div class="my-2 session-title">
                                                    <h1 class="font-extrabold tracking-tighter">{{ story.title_preview }}
                                                    </h1>
                                                </div>

                                                <div class="my-2 session-content">
                                                    <p class="font-light text-gray-800 tracking-normal">{{
                                                        story.content_preview }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <template v-if="story.image">
                                            <div class="flex-initial ml-20">
                                                <img class="object-scale-down w-36 h-32" :alt="story.title_preview"
                                                    :src="`http://localhost/api/image/${story.image}`" />
                                            </div>
                                        </template>
                                    </div>
                                </router-link>

                                <div class="mt-5 mb-10">
                                    <span class="bg-gray-100 text-gray-800 text-xs mr-2 px-2.5 py-1 rounded-lg">
                                        {{ JSON.parse(story.tags)[0] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="border-l border-l-gray-200">
                            <ToWrite />
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </AuthLayout>
</template>

<style>
.session-title {
    font-family: sohne, "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: rgb(41, 41, 41);
    font-size: 26px;
    font-weight: 700;
    line-height: 28px;
    letter-spacing: 0px;
    overflow: hidden;
}

.session-content {
    --x-height-multiplier: 0.375;
    --baseline-multiplier: 0.17;
    font-family: source-serif-pro, Georgia, Cambria, "Times New Roman", Times, serif;
    font-weight: 400;
    font-style: normal;
    font-size: 18px;
    height: 70px;
    width: 480px;
    line-height: 24px;
    letter-spacing: -.003em;
    overflow: hidden;
}
</style>
