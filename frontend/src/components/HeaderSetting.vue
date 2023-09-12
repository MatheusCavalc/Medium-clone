<script setup>
import { ref, onMounted } from 'vue';

let currentUrl = window.location.pathname;
let account = ref('')
let publishing = ref('')
let notifications = ref('')
let member_and_payment = ref('')
let security = ref('')

let current = "ml-8 mb-1.5 text-sm border-b border-b-black pb-[17px] tracking-tight"
let not_current = "ml-8 text-sm tracking-tight text-gray-500 hover:text-black"

const style = () => {
    if (currentUrl == "/me/settings/account") {
        account.value = 'mb-1.5 text-sm border-b border-b-black pb-[17px] tracking-tight'
        publishing.value = not_current
        notifications.value = not_current
        member_and_payment.value = not_current
        security.value = not_current
    } if (currentUrl == "/publishing") {
        publishing.value = current
        account.value = not_current
        notifications.value = not_current
        member_and_payment.value = not_current
        security.value = not_current
    } if (currentUrl == "/notifications") {
        notifications.value = current
        publishing.value = not_current
        account.value = not_current
        member_and_payment.value = not_current
        security.value = not_current
    } if (currentUrl == "/member_and_payment") {
        member_and_payment.value = current
        notifications.value = not_current
        publishing.value = not_current
        account.value = not_current
        security.value = not_current
    }
    if (currentUrl == "/security") {
        security.value = current
        notifications.value = not_current
        publishing.value = not_current
        account.value = not_current
        member_and_payment.value = not_current
    }
}

onMounted(style)
</script>

<template>
    <div class="sticky top-0 bg-white border-b border-b-gray-200 pb-3.5 mt-10 mr-16">
        <div class="pt-4">
            <span :class="account">
                <router-link to="/me/settings/account">Account</router-link>
            </span>
            <span :class="publishing">
                <router-link to="/">Publishing</router-link>
            </span>
            <span :class="notifications">
                <router-link to="/following">Notifications</router-link>
            </span>
            <span :class="member_and_payment">
                <router-link to="/following">Membership and Payment</router-link>
            </span>
            <span :class="security">
                <router-link to="/following">Security and apps</router-link>
            </span>
        </div>
    </div>
</template>