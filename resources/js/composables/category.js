import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useCategories() {
    const category = ref([])
    const pagination = ref({})
    const categories = ref([])

    const errors = ref('')
    const router = useRouter()

    const getCategories = async (page=1) => {
        let response = await axios.get(`/api/admin/categories?page=${page}`)
        pagination.value = response.data.meta
        categories.value = response.data.data
    }

    const getCategory = async (id) => {
        let response = await axios.get(`/api/admin/categories/${id}`)
        category.value = response.data.data
    }

    const storeCategory = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/admin/categories', data)
            await router.push({ name: 'categories.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }

    }

    const updateCategory = async (id) => {
        errors.value = ''
        try {
            await axios.put(`/api/admin/categories/${id}`, category.value)
            await router.push({ name: 'categories.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }

    const destroyCategory = async (id) => {
        await axios.delete(`/api/admin/categories/${id}`)
    }


    return {
        errors,
        category,
        categories,
        getCategory,
        getCategories,
        storeCategory,
        updateCategory,
        destroyCategory,
        pagination,
    }
}
