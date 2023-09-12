<script setup>
import { ref, defineProps, defineEmits } from 'vue'
import { updateProfileInfo } from '@/services/functions'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'

const props = defineProps(['modalActive', 'user_name', 'user_bio'])
const emit = defineEmits(['closeModal', 'reloadPage'])

let name = ref(props.user_name)
let bio = ref(props.user_bio)
let isButtonDisabled = ref(false)

const closeModal = () => {
    emit('closeModal')
}

const updateInfos = () => {
    isButtonDisabled.value = true
    let parameters = {
        name: name.value.trim(),
        bio: bio.value.trim()
    }
    setTimeout(function () {
        updateProfileInfo(parameters)
        emit('closeModal')
        emit('reloadPage')
        isButtonDisabled.value = false
    }, 1000);

}

</script>

<template>
    <TransitionRoot appear :show="props.modalActive" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel
                            class="w-full max-w-xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                Profile information
                            </DialogTitle>

                            <div class="mt-6">
                                <p class="text-gray-600 mb-2">Name*</p>

                                <input type="text" v-model="name" id="name"
                                    class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-black appearance-none focus:outline-none focus:ring-0 focus:border-black peer" />
                                <p class="text-sm text-gray-600 mt-1">Appears on your Profile page, as your byline, and in
                                    your
                                    responses.</p>
                            </div>

                            <div class="mt-10">
                                <p class="text-gray-600 mb-2">Bio</p>

                                <input type="text" v-model="bio" id="bio"
                                    class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-black appearance-none focus:outline-none focus:ring-0 focus:border-black peer" />
                                <p class="text-sm text-gray-600 mt-1">Appears on your Profile and next to your stories.</p>
                            </div>

                            <div class="flex flex-row-reverse mt-10">
                                <template v-if="!isButtonDisabled">
                                    <button :disabled="isButtonDisabled" @click="updateInfos"
                                        class="ml-5 px-7 py-2 text-base tracking-tighter text-white bg-green-600 rounded-full">
                                        Save
                                    </button>
                                    <button @click="closeModal"
                                        class="px-7 py-2 text-base tracking-tighter text-green-600 bg-white border border-green-600 rounded-full">
                                        Cancel
                                    </button>
                                </template>

                                <template v-else>
                                    <button disabled type="button"
                                        class="px-7 py-2 text-base tracking-tighter text-white bg-green-400 rounded-full">
                                        <svg aria-hidden="true" role="status"
                                            class="inline w-4 h-4 mx-1 text-white animate-spin" viewBox="0 0 100 101"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="#E5E7EB" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentColor" />
                                        </svg>
                                        Saving...
                                    </button>
                                </template>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>