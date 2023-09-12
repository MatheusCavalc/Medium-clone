<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import HeaderProfile from '@/components/HeaderProfile.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';
import DeleteStoryModal from '@/components/Modals/DeleteStoryModal.vue'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import axios from 'axios';
import moment from 'moment';
import { ref, onMounted } from 'vue';

let storyId = ref('')
let modalDeleteStory = ref(false)
let my_stories = ref('')
let user_name = ref('')
let loading = ref('')
loading.value = true

const getStories = () => {
    axios.get('http://localhost/api/profile')
        .then((response) => {
            my_stories.value = response.data.stories
            user_name.value = response.data.user_name
            loading.value = false
        })
}

const toggleModalDeleteStory = (id) => {
    storyId.value = id
    modalDeleteStory.value = !modalDeleteStory.value
}

onMounted(getStories)
</script>

<template>
    <AuthLayout>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-20">
            <div class="bg-white sm:rounded-lg">
                <div class="grid grid-cols-3 gap-12">

                    <div class="col-span-2 mt-14">
                        <template v-if="loading">
                            <div class="text-center h-screen place-items-center">
                                <div role="status" class="mt-48">
                                    <LoadingSpinner />
                                </div>
                            </div>
                        </template>

                        <template v-else>
                            <div class="flex justify-between">
                                <p class="block text-5xl font-medium tracking-tight">{{ user_name }}</p>

                                <Menu as="div" class="relative block pr-16">
                                    <MenuButton
                                        class="font-medium tracking-tighter text-2xl text-gray-500 hover:text-black">
                                        ...
                                    </MenuButton>
                                    <div>
                                        <transition enter-active-class="transition ease-out duration-100"
                                            enter-from-class="transform opacity-0 scale-95"
                                            enter-to-class="transform opacity-100 scale-100"
                                            leave-active-class="transition ease-in duration-75"
                                            leave-from-class="transform opacity-100 scale-100"
                                            leave-to-class="transform opacity-0 scale-95">
                                            <MenuItems
                                                class="absolute right-0 z-10 ml-6 mt-2 w-40 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                <MenuItem v-slot="{ active }">
                                                <a href="/profile"
                                                    :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-center text-sm text-gray-700']">
                                                    Copy link to profile
                                                </a>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                <a href="/profile"
                                                    :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-center text-sm text-gray-700']">
                                                    Design your profile
                                                </a>
                                                </MenuItem>
                                            </MenuItems>
                                        </transition>
                                    </div>
                                </Menu>
                            </div>

                            <HeaderProfile />

                            <div v-for="story in my_stories" :key="story.id" class="mt-12 border-b border-b-gray-200 mr-16">
                                <p class="text-gray-500">{{ moment(story.created_at).format('MMMM D,YYYY') }}</p>
                                <router-link :to="{ path: 'story/' + story.slug + '/' + story.id }">
                                    <p class="mt-3 text-xl font-extrabold tracking-tighter">{{ story.title_preview }}</p>
                                </router-link>
                                <p class="mt-2 text-sm">{{ story.content_preview }}</p>

                                <div class="mt-10 mb-11 flex justify-between">
                                    <p
                                        class="block bg-gray-100 text-gray-800 text-center text-xs mr-2 px-2.5 py-1 rounded-full">
                                        {{ story.tags[0] }}
                                    </p>

                                    <Menu as="div" class="relative inline-block text-left">
                                        <div>
                                            <MenuButton
                                                class="font-medium tracking-tighter text-2xl text-gray-900 hover:text-black">
                                                ...
                                            </MenuButton>
                                        </div>

                                        <transition enter-active-class="transition duration-100 ease-out"
                                            enter-from-class="transform scale-95 opacity-0"
                                            enter-to-class="transform scale-100 opacity-100"
                                            leave-active-class="transition duration-75 ease-in"
                                            leave-from-class="transform scale-100 opacity-100"
                                            leave-to-class="transform scale-95 opacity-0">
                                            <MenuItems
                                                class="-top-2 transform -translate-y-full absolute -right-14 w-32 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                <div class="px-1 py-1">
                                                    <MenuItem v-slot="{ active }">
                                                    <router-link :to="'/p/' + story.id + '/edit'"
                                                        :class="[active ? 'bg-gray-100' : '', 'block pl-2 py-2 text-left text-sm text-gray-700']">
                                                        Edit story
                                                    </router-link>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <a href="/profile"
                                                        :class="[active ? 'bg-gray-100' : '', 'block pl-2 py-2 text-left text-sm text-gray-700']">
                                                        Pin story
                                                    </a>
                                                    </MenuItem>
                                                </div>
                                                <div class="px-1 py-1">
                                                    <MenuItem v-slot="{ active }">
                                                    <a href="/profile"
                                                        :class="[active ? 'bg-gray-100' : '', 'block pl-2 py-2 text-left text-sm text-gray-700']">
                                                        Story settings
                                                    </a>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <a href="/profile"
                                                        :class="[active ? 'bg-gray-100' : '', 'block pl-2 py-2 text-left text-sm text-gray-700']">
                                                        Story stats
                                                    </a>
                                                    </MenuItem>
                                                </div>

                                                <div class="px-1 py-1">
                                                    <MenuItem v-slot="{ active }">
                                                    <a href="/profile"
                                                        :class="[active ? 'bg-gray-100' : '', 'block pl-2 py-2 text-left text-sm text-gray-700']">
                                                        Hide responses
                                                    </a>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <a @click="toggleModalDeleteStory(story.id)" href="#"
                                                        :class="[active ? 'bg-gray-100' : '', 'block pl-2 py-2 text-left text-sm text-red-700']">
                                                        Delete story
                                                    </a>
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                    <DeleteStoryModal :modalActive="modalDeleteStory" :story_id="storyId"
                                        @close-modal="toggleModalDeleteStory" @reload-page="getStories" />
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="border-l border-l-gray-200 h-full">
                        <div class="mt-11 ml-10 mr-3">
                            <p>
                                <img class="h-24 w-24 rounded-full"
                                    src="https://avatars.githubusercontent.com/u/105112560?v=4" alt="sexmaster" />
                            </p>

                            <p class="mt-4 mb-5 font-medium">
                                {{ user_name }}
                            </p>

                            <router-link to="/me/settings/account" class="text-sm text-green-700">
                                Edit profile
                            </router-link>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthLayout>
</template>