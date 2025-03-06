<template>
    <Head title="Product Edit" />

    <AppLayout>
        <div class="h-full p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Edit Product</h1>

            <form @submit.prevent="updateProduct(items.product.slug)">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input 
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 p-2 w-full border rounded"
                        />
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select 
                            id="category"
                            v-model="form.category_id"
                            class="mt-1 p-2 w-full border rounded"
                        >
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                        <select 
                            id="brand"
                            v-model="form.brand_id"
                            class="mt-1 p-2 w-full border rounded"
                        >
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Volume -->
                    <div>
                        <label for="volume" class="block text-sm font-medium text-gray-700">Volume (ml)</label>
                        <input 
                            id="volume"
                            v-model="form.volume"
                            type="number"
                            min="1"
                            class="mt-1 p-2 w-full border rounded"
                        />
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input 
                            id="quantity"
                            v-model="form.quantity"
                            type="number"
                            min="1"
                            class="mt-1 p-2 w-full border rounded"
                        />
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input 
                            id="price"
                            v-model="form.price"
                            type="number"
                            step="0.01"
                            class="mt-1 p-2 w-full border rounded"
                        />
                    </div>

                    <!-- Discount -->
                    <div>
                        <label for="discount" class="block text-sm font-medium text-gray-700">Discount (%)</label>
                        <input 
                            id="discount"
                            v-model="form.discount"
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            class="mt-1 p-2 w-full border rounded"
                        />
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select 
                            id="gender"
                            v-model="form.gender"
                            class="mt-1 p-2 w-full border rounded"
                        >
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Unisex</option>
                        </select>
                    </div>

                    <!-- Image Upload -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                        <input 
                            id="image"
                            type="file"
                            @change="handleImageUpload"
                            class="mt-1 p-2 w-full border rounded"
                        />

                        <!-- Preview Uploaded Image -->
                        <!-- <div v-if="imagePreview" class="mt-3">
                            <img :src="imagePreview" alt="Product Image" class="w-32 h-32 object-cover rounded">
                        </div> -->
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea 
                        id="description"
                        v-model="form.description"
                        class="mt-1 p-2 w-full border rounded"
                    ></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-2 mt-6">
                    <SecondaryButton type="button" @click="goBack">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton                         
                        :disabled="form.processing"
                        type="submit">
                        {{ form.processing ? 'Updating...' : 'Update Product' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <Alert 
            v-if="alertMessage" 
            :type="alertType" 
            :message="alertMessage" 
        />
    </AppLayout>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/Admin/App.vue';
import PrimaryButton from '@/Components/Button/Primary.vue';
import SecondaryButton from '@/Components/Button/Secondary.vue';
import Alert from '@/Components/Modal/Alert.vue'
import { useAuth } from '@/Composables/useAuth';



// Props
const props = defineProps({
    items: Object,
    categories: Array, // Pass available categories for selection
    brands: Array, // Pass available brands for selection
});

const alertType = ref('');
const alertMessage = ref('');

const { page } = useAuth();

console.log(props.items.product);
// Form State
const form = useForm({
    name: props.items.product.name,
    price: props.items.product.price,
    category_id: props.items.product.category_id,
    brand_id: props.items.product.brand_id,
    volume: props.items.product.volume,
    quantity: props.items.product.quantity,
    discount: props.items.product.discount,
    gender: props.items.product.gender,
    image: null,
    description: props.items.product.description,
});



// Update Product Method
const updateProduct = async (slug) => {
    form.put(`/admin/products/${slug}`, {
        preserveScroll: true,
        onSuccess: () => {
            alertType.value = 'success';
            alertMessage.value = page.props.flash.success;
        },
        onError: () => {
            alertType.value = 'error';
            alertMessage.value = page.props.flash.error;
        }
    })
};

// Cancel and go back
const goBack = () => {
    window.history.back();
};
</script>
