<template>
    <Head title="Products" />

    <AppLayout>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <div class="flex px-4 py-6 justify-end items-center">
                <Link href="/admin/products/create">
                    <PrimaryButton>
                        Create Product 
                        <i class="material-icons mr-2 text-2xl fill-current">
                            add
                        </i>

                    </PrimaryButton>
                </Link>
            </div>
            <table class="min-w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Image</th>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Description</th>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Volume</th>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Quantity</th>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Discount</th>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Gender</th>
                        <th class="px-4 py-3 text-left text-sm font-medium uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-if="items.resource.data.length === 0">
                        <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                            No products found.
                        </td>
                    </tr>
                    <tr
                        v-for="product in items.resource.data"
                        :key="product.id"
                        class="hover:bg-gray-50 transition-colors"
                    >
                        <td class="px-4 py-3">
                            <div class="flex justify-center">
                                <img
                                    v-if="product.images.length"
                                    :src="product.images[0]"
                                    alt="Product Image"
                                    class="w-12 h-12 rounded object-cover"
                                />
                                <span v-else class="text-gray-400">No Image</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ product.name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate" :title="product.description">
                            {{ product.description }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ product.volume }} ml</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ product.quantity }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-green-600">₱{{ product.price }}</td>
                        <td class="px-4 py-3 text-sm text-red-500">{{ product.discount }}%</td>
                        <td class="px-4 py-3 text-sm text-gray-700 capitalize">{{ product.gender }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <Link :href="`/admin/products/${product.slug}/edit`">
                                    <button
                                    class="flex items-center bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition-colors"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-1"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                            ></path>
                                        </svg>
                                        Edit
                                    </button>
                                </Link>
                                <!-- Remove Button -->
                                <Modal v-model:show="deleteModal" title="Delete Item" @confirm="removeItem" confirmText="Delete">
                                    <p>Are you sure you want to delete this cart?</p>
                                        
                                </Modal>
                                <button
                                    @click="openDeleteModal(product.slug)" 
                                    class="flex items-center bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors"
                                >
                                    <svg
                                        class="w-4 h-4 mr-1"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        ></path>
                                    </svg>
                                    Delete
                                </button>

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex items-center justify-end space-x-4">
            <button 
                :disabled="!pagination.prev_page_url" 
                @click="goToPage(pagination.prev_page_url)" 
                class="px-4 py-2 text-sm font-medium border rounded-lg transition-all duration-300"
                :class="pagination.prev_page_url ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
            >
                Previous
            </button>

            <span class="text-gray-700 text-sm">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </span>

            <button 
                :disabled="!pagination.next_page_url" 
                @click="goToPage(pagination.next_page_url)" 
                class="px-4 py-2 text-sm font-medium border rounded-lg transition-all duration-300"
                :class="pagination.next_page_url ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
            >
                Next
            </button>
        </div>
    </AppLayout>
</template>

<script setup>
    import AppLayout from '@/Layouts/Admin/App.vue';
    import { Head, router, Link } from '@inertiajs/vue3';
    import { ref } from 'vue'
    import Modal from '@/Components/Modal/Modal.vue';
    import Alert from '@/Components/Modal/Alert.vue';
    import PrimaryButton from '@/Components/Button/Primary.vue';

    import { useAuth } from '@/Composables/useAuth';




    const props = defineProps({
        items: Object,
    });

    const deleteModal = ref(false);
    const itemToDelete = ref(null);
    const alertType = ref('');
    const alertMessage = ref('');
    const { page } = useAuth();




    // Pagination
    const pagination = ref(props.items.pagination);


    // Go to the next or previous page
    const goToPage = (url) => {
        if (url) {
            router.get(url);
        }
    };


    
    const openDeleteModal = (slug) => {
        itemToDelete.value = slug;
        deleteModal.value = true;
    };


    const removeItem = async () => {
        router.delete(`/admin/products/${itemToDelete.value}`, {
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