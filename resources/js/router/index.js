import { createRouter, createWebHistory } from 'vue-router'

import ProductsIndex from '../components/products/ProductsIndex.vue'
import ProductsCreate from "../components/products/ProductsCreate.vue";
import ProductsEdit from "../components/products/ProductsEdit.vue";

import CategoriesIndex from '../components/categories/CategoriesIndex.vue'
import CategoriesCreate from "../components/categories/CategoriesCreate.vue";
import CategoriesEdit from "../components/categories/CategoriesEdit.vue";

const routes = [
    {
        path: '/dashboard',
        name: 'products.index',
        component: ProductsIndex
    },
    {
        path: '/products/add',
        name: 'products.create',
        component: ProductsCreate
    },
    {
        path: '/products/:id/edit',
        name: 'products.edit',
        component: ProductsEdit,
        props: true
    },
    {
        path: '/categories',
        name: 'categories.index',
        component: CategoriesIndex
    },
    {
        path: '/categories/add',
        name: 'categories.create',
        component: CategoriesCreate
    },
    {
        path: '/categories/:id/edit',
        name: 'categories.edit',
        component: CategoriesEdit,
        props: true
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})
