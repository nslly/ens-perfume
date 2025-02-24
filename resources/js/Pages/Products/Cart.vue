<template>
    <Head title="Cart" />

    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Shopping Cart</h1>

            <div v-if="items.length > 0" class="bg-white shadow-md rounded-lg p-4">
                <div v-for="cart in items" :key="cart.id" class="flex items-center border-b pb-4 mb-4">
                    <!-- Product Image -->
                    <img :src="cart.product.image" alt="Product Image" class="w-24 h-24 object-cover rounded-md mr-4">

                    <div class="flex-1">
                        <!-- Product Name -->
                        <h2 class="text-lg font-semibold text-gray-900">{{ cart.product.data.name }}</h2>

                        <!-- Product Price -->
                        <p class="text-gray-700">Price: ${{ cart.price }}</p>

                        <!-- Quantity Selector -->
                        <div class="flex items-center mt-2">
                            <button @click="decreaseQuantity(cart)" class="px-3 py-1 bg-[#1F2123] text-[#fafafa] rounded-l">
                                -
                            </button>
                            <span class="px-4 py-1 border">{{ cart.quantity }}</span>
                            <button @click="increaseQuantity(cart)" class="px-3 py-1 bg-[#1F2123] text-[#fafafa] rounded-r">
                                +
                            </button>
                        </div>
                        <div v-if="cart.quantity >= cart.product.data.quantity" class="mt-2">
                            <p class="text-red-500 text-sm italic">
                                You already hit the limit stock of the item.
                            </p>
                        </div>
                    </div>

                    <!-- Remove Button -->
                    <Modal v-model:show="deleteModal" title="Delete Item" @confirm="removeItem" confirmText="Delete">
                        <p>Are you sure you want to delete this cart?</p>
                            
                    </Modal>
                    <button @click="openDeleteModal(cart.id)" class="ml-4 text-red-600 hover:text-red-800">
                        Remove
                    </button>
                    
                </div>
                <Modal v-model:show="checkoutModal" title="Cart Checkout" @confirm="checkout">
                    <form @submit.prevent="confirm">
                        <p>Are you sure you want to checkout these products?</p>
                        <input type="hidden" v-model="totalPrice">
                    </form>
                </Modal>

                <!-- Total Price -->
                <div class="flex justify-between items-center mt-6">
                    <p class="text-lg font-semibold text-gray-900">Total: ${{ totalPrice }}</p>
                    <input type="hidden" v-model="totalPrice">
                    <PrimaryButton @click="checkoutModal = true" class="text-lg">Checkout</PrimaryButton>
                </div>
            </div>

            <!-- Empty Cart Message -->
            <div v-else class="text-center py-10 text-gray-500">
                <p>Your cart is empty.</p>
            </div>
        </div>

        <Alert 
            v-if="alertMessage" 
            :type="alertType" 
            :message="alertMessage" 
        />
    </AppLayout>
</template>

<script setup>
    import { Head, router, useForm } from '@inertiajs/vue3';
    import { defineProps, computed, ref } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Alert from '@/Components/Modal/Alert.vue'
    import PrimaryButton from '@/Components/Button/Primary.vue';
    import Modal from '@/Components/Modal/Modal.vue';
    import { useAuth } from '@/Composables/useAuth';





    /**------------------  
        Vars
    ------------------*/

    const props = defineProps({
        items: Array, 
    });
    

    const checkoutModal = ref(false);
    const deleteModal = ref(false);
    const alertType = ref('');
    const alertMessage = ref('');
    const itemToDelete = ref(null);
    const { user, page } = useAuth();

    
    // Computed property to calculate total price
    const totalPrice = computed(() => {
        return props.items.reduce((total, cart) => total + cart.price * cart.quantity, 0);
    });


    /**------------------  
        Methods
    ------------------*/


    


    const openDeleteModal = (id) => {
        itemToDelete.value = id;
        deleteModal.value = true;
    };


    const increaseQuantity = (cart) => {
        if(cart.product.data.quantity <= cart.quantity) return;
        cart.quantity++;
        updateQuantity(cart, cart.quantity);
    };

    const decreaseQuantity = (cart) => {
        if (cart.quantity > 1) cart.quantity--;
        updateQuantity(cart, cart.quantity);

    };

    const updateQuantity = async (cart, newQuantity) => {
        if (newQuantity < 1) return;
        await router.put(`/cart/${cart.id}`, { quantity: newQuantity }, {
            preserveScroll: true,
            onError: () => {
                alertType.value = 'error';
                alertMessage.value = page.props.flash.error;
            },
        });
    };

    const checkout = async () => {
        const form = useForm({
            'user_id': user.value.id,
            'total_amount': totalPrice.value,
            'payment_method': 'Cash',
        });
        form.post('cart/checkout', {
            preserveScroll: true,
            onSuccess: () => {
                alertType.value = 'success';
                alertMessage.value = page.props.flash.success;
                checkoutModal.value = false;
            },
            onError: () => {
                alertType.value = 'error';
                alertMessage.value = page.props.flash.error;
            }
        })
    } 

    const removeItem = async () => {
        router.delete(`/cart/${itemToDelete.value}`, {
            preserveScroll: true,
            onSuccess: () => {
                alertType.value = 'success';
                alertMessage.value = page.props.flash.success;
                deleteModal.value = false;

            },
            onError: () => {
                alertType.value = 'error';
                alertMessage.value = page.props.flash.error;
            },
        });
        itemToDelete.value = null;

    };
</script>
