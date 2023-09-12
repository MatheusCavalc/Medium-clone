<script setup>
import { ref, watch, nextTick, onMounted, defineEmits } from 'vue';
const emit = defineEmits(['sendData'])

const tags = ref([]);
const newTag = ref('')
const paddingLeft = ref(10);
const tagsUl = ref(null)

const addTag = (tag) => {
    if (tags.value.length > 4) {
        tags.value.splice(4, 1);
        tags.value.push(tag);
        newTag.value = ""
    } else {
        tags.value.push(tag);
        newTag.value = ""
    }
    emit('sendData', tags.value)
}

const removeTag = (index) => {
    tags.value.splice(index, 1);
    emit('sendData', tags.value)
}

const setLeftPadding = () => {
    const extraCushion = 15
    paddingLeft.value = tagsUl.value.clientWidth + extraCushion;
}

watch(tags, () => nextTick(setLeftPadding), { deep: true });
onMounted(setLeftPadding)
</script>

<template>
    <div class="tag-input">
        <input v-model="newTag" type="text" @keydown.enter="addTag(newTag)" @keydown.prevent.tab="addTag(newTag)"
            @keydown.delete="newTag.length || removeTag(tags.length - 1)" :style="{ 'padding-left': + paddingLeft + 'px', 'padding-bottom': '16px', 'padding-top': '16px' }"
            class="block w-full p-3 mt-3 text-sm rounded-lg text-gray-900 border border-gray-300 bg-gray-50 focus:border-white focus:ring-white"
            placeholder="Add a topic..."
        />

        <ul class="tags" ref="tagsUl">
            <li v-for="tag in tags" :key="tag" class="tag">
                {{ tag }}
                <button class="delete" @click="removeTag(index)">x</button>
            </li>
        </ul>
    </div>
</template>

<style scoped>
ul {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 7px;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 10px;
    max-width: 75%;
    overflow-x: auto;
}

.tag {
    background: white;
    padding: 5px;
    border-radius: 4px;
    color: black;
    white-space: nowrap;
    transition: 0.1s ease background;
}

input {
    width: 100%;
    padding: 10px;
}

.delete {
    color: gray;
    background: none;
    outline: none;
    border: none;
    cursor: pointer;
    padding-left: 4px;
    padding-bottom: 2px;
    font-size: 12px;
}

.tag-input {
    position: relative;
}
</style>