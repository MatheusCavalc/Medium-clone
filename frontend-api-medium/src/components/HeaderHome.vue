<script setup>
import { ref, onMounted } from 'vue';

let currentUrl = window.location.pathname;
let home = ref('')
let following = ref('')

const style = () => {
    if (currentUrl == "/") {
        home.value = "ml-8 mb-1.5 text-sm border-b border-b-black pb-[18px] tracking-tight"
        following.value = 'ml-8 text-sm tracking-tight text-gray-500 hover:text-black'
    } if (currentUrl == "/following") {
        following.value = "ml-8 mb-1.5 text-sm border-b border-b-black pb-[18px] tracking-tight"
        home.value = 'ml-8 text-sm tracking-tight text-gray-500 hover:text-black'
    }
}

onMounted(style)
</script>

<template>
    <div class="sticky top-0 bg-white border-b border-b-gray-200 pb-3.5 ml-4 mr-16">
        <div class="pt-4">
            <span class="font-thin text-2xl leading-5 tracking-tight text-gray-500">
                <router-link to="/">+</router-link>
            </span>
            <span :class="home">
                <router-link to="/">For you</router-link>
            </span>
            <span :class="following">
                <router-link to="/following">Following</router-link>
            </span>
        </div>
    </div>
</template>