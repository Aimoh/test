import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue/dist/vue.esm-bundler';
import router from './router'

import ProductsIndex from '../js/components/products/ProductsIndex.vue';
import CategoriesIndex from '../js/components/categories/CategoriesIndex.vue';

createApp({
    components: {
        ProductsIndex, CategoriesIndex
    }
}).use(router).mount('#app')

