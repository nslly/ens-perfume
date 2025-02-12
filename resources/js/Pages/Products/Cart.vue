<template>
    <Head title="Cart" />

    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Shopping Cart</h1>

            <div v-if="items.length > 0" class="bg-white shadow-md rounded-lg p-4">
                <div v-for="cart in items" :key="cart.id" class="flex items-center border-b pb-4 mb-4">
                    <!-- Product Image -->
                    <img :src="cart.image" alt="Product Image" class="w-24 h-24 object-cover rounded-md mr-4">

                    <div class="flex-1">
                        <!-- Product Name -->
                        <h2 class="text-lg font-semibold text-gray-900">{{ cart.name }}</h2>

                        <!-- Product Price -->
                        <p class="text-gray-700">Price: ${{ cart.price }}</p>

                        <!-- Quantity Selector -->
                        <div class="flex items-center mt-2">
                            <button @click="decreaseQuantity(cart)" class="px-3 py-1 bg-gray-200 rounded-l">
                                -
                            </button>
                            <span class="px-4 py-1 border">{{ cart.quantity }}</span>
                            <button @click="increaseQuantity(cart)" class="px-3 py-1 bg-gray-200 rounded-r">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Remove Button -->
                    <button @click="removeItem(cart.id)" class="ml-4 text-red-600 hover:text-red-800">
                        Remove
                    </button>
                </div>

                <!-- Total Price -->
                <div class="flex justify-between items-center mt-6">
                    <p class="text-lg font-semibold text-gray-900">Total: ${{ totalPrice }}</p>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Proceed to Checkout
                    </button>
                </div>
            </div>

            <!-- Empty Cart Message -->
            <div v-else class="text-center py-10 text-gray-500">
                <p>Your cart is empty.</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import { defineProps, computed } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';

    const props = defineProps({
        items: Array,  // Changed to Array for easier looping
    });

    // Computed property to calculate total price
    const totalPrice = computed(() => {
        return props.items.reduce((total, cart) => total + cart.price * cart.quantity, 0);
    });

    // Quantity controls (replace these with real API calls if needed)
    const increaseQuantity = (cart) => {
        cart.quantity++;
    };

    const decreaseQuantity = (cart) => {
        if (cart.quantity > 1) cart.quantity--;
    };

    const removeItem = (id) => {
        console.log("Removing item with ID:", id);
    };
</script>
