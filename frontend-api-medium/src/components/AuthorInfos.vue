<script setup>
import { defineProps, ref } from 'vue';
import axios from 'axios';

const props = defineProps(['authId', 'user', 'is_follow', 'can_follow']);

let button_label = ref('')
let is_follow = ref('')

button_label.value = props.is_follow ? 'Unfollow' : 'Follow'
is_follow.value = props.is_follow ? true : false

const follow = () => {
    event.preventDefault()
    axios.post('http://localhost/api/follows', {
        userId: props.user.id,
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
        userId: props.user.id,
    }).then(() => {
        button_label.value = 'Follow'
        is_follow.value = false
    }).catch(error => {
        console.log(error)
    });
}
</script>

<template>
    <div class="">
        <div class="">
            <p>
                <img class="h-24 w-24 rounded-full" src="https://avatars.githubusercontent.com/u/105112560?v=4"
                    alt="sexmaster" />
            </p>

            <p class="mt-4 font-medium">
                <template v-if="props.authId == props.user.id">
                    <router-link to="/profile">{{ props.user.name }}</router-link>
                </template>

                <template v-else>
                    <router-link :to="'/' + props.user.username">{{ props.user.name }}</router-link>
                </template>
            </p>

            <p class="mt-1 text-gray-500">
                744 Followers
            </p>

            <p class="mt-3 text-gray-500 text-sm tracking-tight">
                {{ props.user.bio }}
            </p>

            <div v-if="props.can_follow" class="flex mt-5">
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

                <button class="block ml-2 px-2.5 py-1 text-base tracking-tight text-white bg-green-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </button>
            </div>

        </div>
    </div>
</template>