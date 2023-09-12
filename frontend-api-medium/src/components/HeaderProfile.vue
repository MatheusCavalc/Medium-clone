<script setup>
import { ref, onMounted } from 'vue';

let currentUrl = window.location.pathname;
let home = ref('')
let list = ref('')
let about = ref('')

let current = "ml-8 mb-1.5 text-sm border-b border-b-black pb-[17px] tracking-tight"
let not_current = "ml-8 text-sm tracking-tight text-gray-500 hover:text-black"

const style = () => {
    if (currentUrl == "/profile" || currentUrl.startsWith('/@')) {
        home.value = 'mb-1.5 text-sm border-b border-b-black pb-[17px] tracking-tight'
        list.value = not_current
        about.value = not_current
    } if (currentUrl == "/list") {
        list.value = current
        home.value = not_current
        about.value = not_current
    } if (currentUrl == "/about") {
        about.value = current
        list.value = not_current
        home.value = not_current
    }
}

onMounted(style)
</script>

<template>
    <div class="sticky top-0 bg-white border-b border-b-gray-200 pb-3.5 mt-7 mr-16">
        <div class="pt-4">
            <span :class="home">
                <router-link to="/profile">Home</router-link>
            </span>
            <span :class="list">
                <router-link to="/">Lists</router-link>
            </span>
            <span :class="about">
                <router-link to="/following">About</router-link>
            </span>
        </div>
    </div>
</template>