<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import HeaderSetting from '@/components/HeaderSetting.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';
import ProfileInformation from '@/components/Modals/ProfileInformation.vue';
import UsernameSubdomain from '@/components/Modals/UsernameSubdomain.vue';
import EmailAddress from '@/components/Modals/EmailAddress.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

let loading = ref(true)
let modalProfileInformation = ref(false)
let modalUsernameSubdomain = ref(false)
let modalEmailAddress = ref(false)
let user_infos = ref('')

const getUserInfo = () => {
    axios.get('http://localhost/api/user/settings')
        .then((response) => {
            user_infos.value = response.data.user_infos
            loading.value = false
        })
}

const toggleModalProfileInformation = () => {
    modalProfileInformation.value = !modalProfileInformation.value
}

const toggleModalUsernameSubdomain = () => {
    modalUsernameSubdomain.value = !modalUsernameSubdomain.value
}

const toggleModalEmailAddress = () => {
    modalEmailAddress.value = !modalEmailAddress.value
}

onMounted(getUserInfo)
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
                            <p class="block text-5xl font-medium tracking-tight">Settings</p>

                            <HeaderSetting />

                            <div @click="toggleModalEmailAddress"
                                class="flex justify-between cursor-pointer hover:text-black mt-12 mb-7">
                                <p class="text-sm">Email address</p>
                                <p class="text-gray-600 text-sm mr-16 hover:text-black">{{ user_infos.email }}</p>
                            </div>
                            <EmailAddress :modalActive="modalEmailAddress" :user_email="user_infos.email"
                                @close-modal="toggleModalEmailAddress" @reload-page="getUserInfo" />

                            <div @click="toggleModalUsernameSubdomain"
                                class="flex justify-between cursor-pointer hover:text-black mt-8 mb-7">
                                <p class="text-sm">Username and subdomain</p>
                                <p class="text-gray-600 text-sm mr-16 hover:text-black">{{ user_infos.username }}</p>
                            </div>
                            <UsernameSubdomain :modalActive="modalUsernameSubdomain" :user_username="user_infos.username"
                                @close-modal="toggleModalUsernameSubdomain" @reload-page="getUserInfo" />

                            <div @click="toggleModalProfileInformation"
                                class="flex justify-between cursor-pointer hover:text-black mt-8 mb-7">
                                <div>
                                    <p class="text-sm">Profile Information</p>
                                    <p class="text-gray-600 text-sm mt-1">Edit your name, bio, etc</p>
                                </div>
                                <p class="text-gray-600 text-sm mr-16 pt-3 hover:text-black">{{ user_infos.name }}</p>
                            </div>
                            <ProfileInformation :user_name="user_infos.name" :user_bio="user_infos.bio"
                                :modalActive="modalProfileInformation" @close-modal="toggleModalProfileInformation"
                                @reload-page="getUserInfo" />

                        </template>
                    </div>

                    <div class="border-l border-l-gray-200 h-screen">

                    </div>
                </div>
            </div>
        </div>

    </AuthLayout>
</template>