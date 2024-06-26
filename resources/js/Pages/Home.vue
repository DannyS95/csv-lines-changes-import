<script setup>
import { useForm } from '@inertiajs/vue3'
import { reactive } from 'vue'

const form = useForm({
    oldFile: null,
    recentFile: null,
})

const csvTable = reactive({
    headers: null,
    data: null,
})

const submit = () => {
    axios.post(route('csvLines.changes'), {
        oldFile: form.oldFile,
        recentFile: form.recentFile
    }, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        csvTable.headers = response.data[0]
        csvTable.data = response.data[1]
    })
    .catch(error => {
        form.errors = error.response.data.errors
    })
}

const handleoldFile = (file) => {
    form.oldFile = file
}

const handlerecentFile = (file) => {
    form.recentFile = file
}

const formReset = () => {
    form.clearErrors()
}

</script>

<template>

<div class="relative overflow-x-auto mt-10" v-if="csvTable.data && csvTable.headers">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th v-for="header in csvTable.headers" scope="col" class="px-6 py-3">
                    {{ header }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="data in csvTable.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td v-for="(value, index) in data" class="px-6 py-4" :class="{'font-medium': index == 0, 'text-gray-900': index == 0, 'whitespace-nowrap': index == 0, 'dark:text-white': index == 0}">
                    {{ value }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
    <div class="relative isolate px-6 pt-14 lg:px-8">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
        </div>
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
    </div>
    <form v-if="!form.errors.oldFile && !form.errors.recentFile" class="mx-auto max-w-4xl mt-10 flex items-center justify-center gap-x-6" @submit.prevent="submit()">
        <label for="oldFile" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old Data</label>
        <input
            id="oldFile"
            type="file" v-on:change="handleoldFile($event.target.files[0])"
            class="z-50 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        />
        <label for="recentFile" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Recent Data</label>
        <input
            id="recentFile" type="file"
            v-on:change="handlerecentFile($event.target.files[0])"
            class="z-50 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        />
        <button class="z-50 py-2.5 mt-2 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
        type="submit">Submit</button>
    </form>

    <!-- Main modal -->
    <div v-if="form.errors.oldFile || form.errors.recentFile" id="default-modal" aria-hidden="true" class="flex items-center justify-center mx-auto z-60 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">
                        Form errors
                    </h3>
                    <button @click="formReset()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p  v-if="form.errors.oldFile" class="font-semibold text-lg leading-relaxed text-gray-500 dark:text-gray-400">
                        {{ form.errors.oldFile[0] }}.
                    </p>
                    <p  v-if="form.errors.recentFile" class="font-semibold text-lg leading-relaxed text-gray-500 dark:text-gray-400">
                        {{ form.errors.recentFile[0] }}.
                    </p>
                </div>
            </div>
        </div>
    </div>

</template>
