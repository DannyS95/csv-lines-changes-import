<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  name: null,
  avatar: null,
})

function submit() {
  form.post('/users')
}
</script>

<template>
  <form @submit.prevent="submit">
    <label for="oldData" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">oldData</label>
    <input
        id="oldData"
        type="file" @input="form.avatar = $event.target.files[0]"
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
    />
    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
      {{ form.progress.percentage }}%
    </progress>

    <label for="recentData" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">recentData</label>
    <input
        id="recentData" type="file"
        @input="form.avatar = $event.target.files[0]"
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
    />
    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
      {{ form.progress.percentage }}%
    </progress>
    <button type="submit">Submit</button>
  </form>
</template>
