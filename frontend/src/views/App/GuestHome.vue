<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
</script>

<template>
    <GuestLayout>
        <div
            class="relative grid grid-cols-1 mx-4 md:mx-auto text-white max-w-7xl gap-x-16 lg:grid-cols-2 lg:px-8 lg:pt-24">
            <div class="mt-20 md:mx-36 text-black md:block flex gap-3 justify-center order-2 md:order-1">
                <div class="flex justify-end">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-24 h-24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>
                </div>

                <div class="flex justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-24 h-24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6zM7.5 6h.008v.008H7.5V6zm2.25 0h.008v.008H9.75V6z" />
                    </svg>
                </div>

                <div class="flex justify-center md:mt-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-24 h-24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                    </svg>
                </div>

            </div>

            <div class="mt-24 text-black order-1 md:order-2">
                <p class="text-5xl">
                    Accessible platform for writers, journalists, bloggers and content creators.
                </p>

                <p class="mt-5 text-2xl">
                    Share your stories and ideas with a wide audience.
                </p>

                <p class="md:mt-10 mt-5 flex justify-start md:justify-end">
                    <router-link to="/login"
                        class="px-8 py-3 border border-black font-semibold text-white bg-black rounded-lg">
                        Sign In</router-link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>