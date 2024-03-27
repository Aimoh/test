<template>

    <div class="flex mb-4 place-content-end">
        <div class="px-4 py-2 text-blue bg-indigo-600 cursor-pointer hover:bg-indigo-700">
            <router-link :to="{ name: 'categories.create' }" class="text-sm font-medium">Create category</router-link>
        </div>
    </div>
    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">

        <table class="min-w-full border divide-y divide-gray-200">

            <thead>

            <tr>
                <th class="px-6 py-3 bg-gray-50">
                    <span
                        class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Title</span>
                </th>
                <th class="px-6 py-3 bg-gray-50">
                    <span
                        class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Slug</span>
                </th>
                <th class="px-6 py-3 bg-gray-50">
                    <span
                        class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">External_id</span>
                </th>
            </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="item in categories" :key="item.id">
                <tr class="bg-white">
                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                        {{ item.title }}
                    </td>
                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                        {{ item.slug }}
                    </td>
                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                        {{ item.external_id }}
                    </td>
                    <td class="px-6 py-4 text-sm leading-5 text-center text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'categories.edit', params: { id: item.id } }"
                                     class="px-4 py-2 rounded-md text-blue border border-transparent bg-indigo-600 cursor-pointer hover:bg-indigo-700">Edit</router-link>
                        <button @click="deleteCategory(item.id)"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25">
                            Delete
                        </button>
                    </td>
                </tr>

            </template>
            </tbody>
        </table>
        <TailwindPagination
            :data="pagination"
            @pagination-change-page="getCategories"
        />
    </div>

</template>

<script setup>
import useCategories from '../../../js/composables/category'
import {onMounted} from 'vue';
import {TailwindPagination} from "laravel-vue-pagination";

const {categories, getCategories, destroyCategory, pagination} = useCategories()

const deleteCategory = async (id) => {
    if (!window.confirm('You sure?')) {
        return
    }

    await destroyCategory(id)
    await getCategories()
}

onMounted(getCategories)
</script>
