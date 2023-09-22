<script setup>
import { ref } from 'vue';

let menu = ref(false)

const showMenu = () => {
    menu.value = !menu.value
}
</script>

<template>
    <nav class="fixed top-0 left-0 z-20 w-full bg-yellow-400 border-black border-b px-2 sm:px-4 py-1 dark:bg-gray-900">
        <div class="max-w-full flex flex-wrap items-center justify-between md:mx-14">
            <router-link to="/" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Writer</span>
            </router-link>
            <button @click="showMenu" data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <div :class="{ 'md:block': menu, 'hidden md:block': !menu }" class="md:block md:w-auto" id="navbar-default">
                <ul
                    class="flex flex-col p-4 mt-4 border border-gray-100 rounded-lg bg-yellow-400 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0">
                    <li>
                        <a href="#"
                            class="block mt-2 py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Our
                            story</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block mt-2 py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Membership</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block mt-2 py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Write</a>
                    </li>
                    <li>
                        <router-link to="/login"
                            class="block mt-2 py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Sign
                            In
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/register">
                            <button class="bg-black text-white text-sm font-bold py-2 px-5 rounded-full">
                                Get Started
                            </button>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div>
        <div class="fixed top-0 left-0 hidden w-full h-4/5 bg-yellow-400 lg:block" aria-hidden="true"></div>

        <slot />
    </div>

</template>