import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useProducts() {
    const product = ref([])
    const pagination = ref({})
    const products = ref([])

    const errors = ref('')
    const router = useRouter()

    const getProducts = async (page=1) => {
        let response = await axios.get(`/api/admin/products?page=${page}`)
        pagination.value = response.data.meta
        products.value = response.data.data
    }

    const getProduct = async (id) => {
        let response = await axios.get(`/api/admin/products/${id}`)
        product.value = response.data.data
    }

    const storeProduct = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/admin/products', data)
            await router.push({ name: 'products.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }

    }

    const updateProduct = async (id) => {
        errors.value = ''
        try {
            await axios.put(`/api/admin/products/${id}`, product.value)
            await router.push({ name: 'products.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }

    const destroyProduct = async (id) => {
        await axios.delete(`/api/admin/products/${id}`)
    }


    return {
        errors,
        product,
        products,
        getProduct,
        getProducts,
        storeProduct,
        updateProduct,
        destroyProduct,
        pagination,
    }
}
