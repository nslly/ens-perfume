<template>
    <Head title="Products" />

    <AppLayout>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg">
            <thead>
                <tr class="bg-blue-500 text-white">
                <th class="px-4 py-2">Image</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Volume</th>
                <th class="px-4 py-2">Quantity</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Discount</th>
                <th class="px-4 py-2">Gender</th>
                <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id" class="border-b">
                <td class="px-4 py-2 text-center">
                    <img v-if="product.images.length" :src="product.images[0]" alt="Product Image" class="w-12 h-12 rounded">
                    <span v-else>No Image</span>
                </td>
                <td class="px-4 py-2">{{ product.name }}</td>
                <td class="px-4 py-2 truncate w-40">{{ product.description }}</td>
                <td class="px-4 py-2">{{ product.volume }} ml</td>
                <td class="px-4 py-2">{{ product.quantity }}</td>
                <td class="px-4 py-2 font-bold text-green-600">₱{{ product.price.toFixed(2) }}</td>
                <td class="px-4 py-2 text-red-500">{{ product.discount }}%</td>
                <td class="px-4 py-2 capitalize">{{ product.gender }}</td>
                <td class="px-4 py-2">
                    <button class="bg-blue-500 text-white px-2 py-1 rounded text-sm mr-1">Edit</button>
                    <button class="bg-red-500 text-white px-2 py-1 rounded text-sm">Delete</button>
                </td>
                </tr>
            </tbody>
            </table>
        </div>




    </AppLayout>
</template>




<script setup>
    import AppLayout from '@/Layouts/Admin/App.vue';
    import { useAuth } from '@/Composables/useAuth.js';
    import { defineProps } from 'vue';
    import { Head } from '@inertiajs/vue3';

    const props = defineProps({
        products: Object
    })

    console.log(props.products);
    const { page } = useAuth();
</script>