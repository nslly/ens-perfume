<template>
    <Head title="Products" />

    <AppLayout>
        <div class="overflow-x-auto bg-white rounded-lg shadow-sm">
            <div class="flex flex-col gap-3 p-4 sm:flex-row sm:justify-between sm:items-center">
                <h1 class="text-xl font-semibold text-[#0D0D60]">Product Management</h1>
                <Link href="/admin/products/create">
                    <PrimaryButton class="flex items-center gap-2">
                        <i class="text-2xl material-icons">add</i>
                        Create Product
                    </PrimaryButton>
                </Link>
            </div>

            <table class="min-w-full text-sm">
                <thead class="bg-[#0D0D60] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left uppercase">Image</th>
                        <th class="px-4 py-3 text-left uppercase">Name</th>
                        <th class="px-4 py-3 text-left uppercase">Description</th>
                        <th class="px-4 py-3 text-left uppercase">Volume</th>
                        <th class="px-4 py-3 text-left uppercase">Qty</th>
                        <th class="px-4 py-3 text-left uppercase">Price</th>
                        <th class="px-4 py-3 text-left uppercase">Discount</th>
                        <th class="px-4 py-3 text-left uppercase">Gender</th>
                        <th class="px-4 py-3 text-left uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-if="items.resource.data.length === 0">
                        <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                            No products found.
                        </td>
                    </tr>

                    <tr v-for="product in items.resource.data" :key="product.id" class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex justify-center">
                                <img
                                    v-if="product.image?.length"
                                    :src="`/storage/${product.image}`"
                                    alt="Product"
                                    class="object-cover w-12 h-12 rounded"
                                />
                                <span v-else class="text-gray-400">No Image</span>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-gray-700">{{ product.name }}</td>

                        <td class="max-w-xs px-4 py-3 text-gray-700 truncate" :title="product.description">
                            {{ product.description }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">{{ product.volume }} ml</td>

                        <td class="px-4 py-3 text-gray-700">{{ product.quantity }}</td>

                        <td class="px-4 py-3 font-semibold text-green-600">₱{{ product.price }}</td>

                        <td class="px-4 py-3 text-red-500">{{ product.discount }}%</td>

                        <td class="px-4 py-3 text-gray-700 capitalize">{{ product.gender }}</td>

                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-2">
                                <Link :href="`/admin/products/${product.slug}/edit`">
                                    <button class="flex items-center gap-1 px-3 py-1 text-sm text-white bg-[#0D0D60] rounded hover:bg-[#0d0d60d8]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M4 13.5V21h7.5L20.768 11.732a2.5 2.5 0 10-3.536-3.536L4 17.5z" />
                                        </svg>
                                        Edit
                                    </button>
                                </Link>

                                <button
                                    @click="openDeleteModal(product.slug)"
                                    class="flex items-center gap-1 px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-wrap items-center justify-between gap-4 mt-6">
            <div class="text-sm text-gray-600">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </div>
            <div class="flex gap-2">
                <button
                    :disabled="!pagination.prev_page_url"
                    @click="goToPage(pagination.prev_page_url)"
                    class="px-4 py-2 text-sm font-medium transition duration-200 rounded-lg"
                    :class="pagination.prev_page_url ? 'bg-[#0D0D60] text-white hover:bg-[#0d0d60d8]' : 'bg-gray-200 text-gray-500 cursor-not-allowed'"
                >
                    Previous
                </button>
                <button
                    :disabled="!pagination.next_page_url"
                    @click="goToPage(pagination.next_page_url)"
                    class="px-4 py-2 text-sm font-medium transition duration-200 rounded-lg"
                    :class="pagination.next_page_url ? 'bg-[#0D0D60] text-white hover:bg-[#0d0d60d8]' : 'bg-gray-200 text-gray-500 cursor-not-allowed'"
                >
                    Next
                </button>
            </div>
        </div>

        <!-- Modals -->
        <Modal v-model:show="deleteModal" title="Delete Product" @confirm="removeItem" confirmText="Delete">
            <p>Are you sure you want to delete this product?</p>
        </Modal>
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




    const pagination = ref(props.items.pagination);


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