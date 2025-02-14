<template>
    <div>
        <img class="w-full h-64 object-cover" :src="product.image" :alt="product.name" />
        <div class="py-4 flex justify-center items-center flex-col">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">{{ product.name }}</div>
                <p class="text-gray-700 text-base">
                    {{ product.description }}
                </p>
            </div>
            <div class="px-6 py-4">
                <div class="flex justify-between items-center space-x-2">
                    <span 
                        class="text-sm font-semibold text-gray-500" 
                        :class="{'line-through': product.discount}"
                    >
                        ${{ product.price }}
                    </span>

                    <span 
                        v-if="product.discount" 
                        class="text-xl font-bold text-[#FFBF00]"
                    >
                        ${{ computedPrice(product) }}
                    </span>
                </div>

                <div class="flex items-center justify-center">
                    <span 
                        v-if="product.discount" 
                        class="mt-2 inline-block bg-[#FFBF00] text-[#fafafa] text-xs font-bold px-2 py-1 rounded"
                    >
                        -{{ product.discount }}% OFF
                    </span>
                </div>
                
            </div>

            <form @submit.prevent="addToCart(product)">
                <input 
                    v-model="product.finalPrice"
                    type="hidden" 
                />
                <div class="flex justify-center items-center gap-2">
                    <input 
                        type="number" 
                        v-model="product.quantity" 
                        min="1" 
                        :max="product.maxQuantity"
                        class="w-16 px-2 py-1 border border-gray-300 rounded text-center"
                        @input="validateQuantity(product)"

                    />

                    <div v-if="isAuthenticated">
                        <SecondaryButton 
                            class="text-sm"
                            type="submit"
                            :disabled="loading"
                        >
                                {{ loading ? 'Adding...' : 'Add to cart' }}
                        </SecondaryButton>
                    </div>

                    <div v-else>
                        <Link href="/login">
                            <SecondaryButton class="text-sm">
                                Add to cart
                            </SecondaryButton>
                        </Link>
                    </div>

                </div>

                
            </form>

            <Alert v-if="messages[product.id]" :type="messages[product.id].type" :message="messages[product.id].text" />
            
        </div>
    </div>

</template>

<script setup>
    import { defineProps, ref, computed } from "vue";
    import { useForm, usePage, Link } from '@inertiajs/vue3'
    import SecondaryButton from '@/Components/Button/Secondary.vue';
    import Alert from '@/Components/Modal/Alert.vue'

    /**
     * Props
     */
    const props = defineProps({
        product: {
            type: Object,
            required: true
        }
    });
    
    const page = usePage();
    const flash = computed(() => page.props.flash);



    /**
     * State
     */

    const isAuthenticated = computed(() => page.props.auth.isAuthenticated);

    //Message for error and success
    const messages = ref({}); 

    //loading value 
    const loading = ref(false); 

    const computedPrice = (product) => {
        return product.discount 
            ? Math.floor(product.price - product.price * (product.discount / 100)) 
            : product.price;
    };

    // Function to validate quantity input
    const validateQuantity = (product) => {
        if (product.quantity < 1 || isNaN(product.quantity)) {
            product.quantity = 1;
        }
    };


    /**
     * Functions / Methods
     * 
     * 
     */

    const addToCart = async (product) => {

        if (product.quantity < 1) {
            messages.value[product.id] = { type: 'error', text: "Quantity must be at least 1." };
            return;
        }

        loading.value = true;
        messages.value[product.id] = null; 

        const form = useForm({
            product_id: product.id,
            quantity: product.quantity,
            price: product.finalPrice,
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
