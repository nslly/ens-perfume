<template>
    <div v-if="product.maxQuantity">
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

                    <div v-if="authenticated">
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
                <div class="flex mt-2 justify-center items-center flex-col">
                    <div class="mt-2 flex justify-center items-center">
                        <p class="text-sm text-gray-400">
                            <span class="font-semibold text-[#1F2123]">{{ product.maxQuantity }}</span> available stock
                        </p>
                    </div>
                    <div v-if="product.quantity >= product.maxQuantity" class="mt-2">
                        <p class="text-red-500 text-sm italic">
                            Reach limit stock of the item.
                        </p>
                    </div>
                </div>

                
            </form>

            <Alert 
                v-if="alertMessage" 
                :type="alertType" 
                :message="alertMessage" 
            />

            
        </div>
    </div>

</template>

<script setup>
    import { defineProps, ref } from "vue";
    import { useForm, Link } from '@inertiajs/vue3'
    import SecondaryButton from '@/Components/Button/Secondary.vue';
    import Alert from '@/Components/Modal/Alert.vue'
    import { useAuth } from '@/Composables/useAuth';


    /**
     * Props
     */
    const props = defineProps({
        product: {
            type: Object,
            required: true
        }
    });

    
    /**
     * State
     */

    const { authenticated, page } = useAuth();


    const alertType = ref('');
    const alertMessage = ref('');
    
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
     */

    const addToCart = async (product) => {

        loading.value = true;

        const form = useForm({
            product_id: product.id,
            quantity: product.quantity,
            price: product.finalPrice,
        });

        form.post('/cart', {
            preserveScroll: true,
            onSuccess: () => {
                alertType.value = 'success'
                alertMessage.value = page.props.flash.success
                form.reset();
            },
            onError: () => {
                alertType.value = 'error'
                alertMessage.value = page.props.flash.error
            },
            onFinish: () => {
                loading.value = false;
        }
    });
};
</script>
