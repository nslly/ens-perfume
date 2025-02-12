<template>
    <div class="max-w-7xl mx-auto relative">
        <Swiper 
            v-bind="swiperConfig" 
            :modules="[Navigation, Pagination]"
            class="mySwiper product-carousel"
        >
            <SwiperSlide v-for="product in cartProducts" :key="product.id">
                <div class="max-w-sm rounded overflow-hidden shadow-lg flex flex-col items-center justify-center bg-white mx-auto">
                    <img class="w-full h-64 object-cover" :src="product.image" :alt="product.name" />
                    <div class="py-4 flex justify-center items-center flex-col">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ product.name }}</div>
                            <p class="text-gray-700 text-base">
                                {{ product.description }}
                            </p>
                        </div>
                        <div class="px-6 pt-4 pb-2">
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                ${{ product.price }}
                            </span>
                        </div>

                        <!-- Quantity Input and Add to Cart Button -->
                        <form @submit.prevent="addToCart(product)">
                            <input 
                                v-model="product.price"
                                type="hidden" 
                            />
                            {{ product.price }}
                            <div class="flex justify-center items-center gap-2">
                                <input 
                                    type="number" 
                                    v-model="product.quantity" 
                                    min="1" 
                                    class="w-16 px-2 py-1 border border-gray-300 rounded text-center"
                                    @input="validateQuantity(product)"
                                />
                                <SecondaryButton 
                                    class="text-sm"
                                    type="submit"
                                    :disabled="loading"
                                >
                                    {{ loading ? 'Adding...' : 'Add to cart' }}
                                </SecondaryButton>
                            </div>

                            <!-- Display Success & Error Messages -->
                            <div v-if="messages[product.id]" class="text-sm mt-2" 
                                :class="messages[product.id].type === 'error' ? 'text-red-500' : 'text-green-500'">
                                {{ messages[product.id].text }}
                            </div>
                        </form>
                    </div>
                </div>
            </SwiperSlide>
        </Swiper>
    </div>
</template>

<script setup>
    import { defineProps, ref, computed } from "vue";
    import { useForm, usePage } from '@inertiajs/vue3'
    import { Swiper, SwiperSlide } from "swiper/vue";
    import { Navigation, Pagination } from 'swiper/modules';
    import { swiperConfig } from '@/Utils/swiper.js'

    import SecondaryButton from '@/Components/Button/Secondary.vue';

    // Props
    const props = defineProps({
        products: {
            type: Array,
            required: true
        }
    });

    // Reactive Variables
    const cartProducts = ref(props.products.map(product => ({ ...product, quantity: 1 }))); // Local copy
    const messages = ref({});  // Store success & error messages
    const loading = ref(false); // Loading state



    // Function to validate quantity input
    const validateQuantity = (product) => {
        if (product.quantity < 1 || isNaN(product.quantity)) {
            product.quantity = 1;
        }
    };


    const addToCart = async (product) => {

        if (product.quantity < 1) {
            messages.value[product.id] = { type: 'error', text: "Quantity must be at least 1." };
            return;
        }

        loading.value = true;
        messages.value[product.id] = null; // Clear previous messages

        const form = useForm({
            product_id: product.id,
            quantity: product.quantity,
            price: product.price,
        });

        form.post('/cart', {
            preserveScroll: true,
            onSuccess: () => {
                messages.value[product.id] = { type: 'success', text: 'Added to cart successfully!' };
            },
            onError: (err) => {
                messages.value[product.id] = { type: 'error', text: err.message || "Failed to add to cart." };
            },
            onFinish: () => {
                loading.value = false;
            }
    });
};
</script>

<style scoped>
.product-carousel {
    padding-bottom: 50px; /* Space for pagination dots */
}

/* Custom Swiper Navigation Buttons */
.swiper-button-next,
.swiper-button-prev {
    font-size: 10px;
    color: #ffffff;
    background: #0d0d60;
    padding: 34px;
    border-radius: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 50%;
    transform: translateY(-50%);
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 20px;
}

/* Pagination Dots Styling */
:deep(.swiper-pagination-bullet) {
    width: 10px;
    height: 10px;
    background: #0d0d60;
    opacity: 0.5;
}

:deep(.swiper-pagination-bullet-active) {
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .swiper-button-next,
    .swiper-button-prev {
        display: none;
    }
}
</style>
