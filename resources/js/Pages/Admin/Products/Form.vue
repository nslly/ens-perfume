<template>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <!-- Product Name -->
        <div>
            <TextInput
                id="name"
                label="Product Name" 
                placheholder="Enter Product"
                v-model="form.name"
                type="text"
                class="w-full p-2 mt-1 border rounded"
                :error="errors.name ?? ''"
            />
        </div>

        <!-- Category -->
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select 
                id="category"
                v-model="form.category_id"
                class="w-full p-2 mt-1 border rounded"
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
                class="w-full p-2 mt-1 border rounded"
            >
                <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                    {{ brand.name }}
                </option>
            </select>
        </div>

        <!-- Volume -->
        <div>
            <TextInput
                id="volume"
                label="Volume (ml)" 
                placheholder="Enter Volume"
                v-model="form.volume"
                type="number"
                min=1
                class="w-full p-2 mt-1 border rounded"
                :error="errors.volume ?? ''"
            />
        </div>

        <!-- Quantity -->
        <div>
            <TextInput
                id="quantity"
                label="Quantity" 
                placheholder="Enter Quantity"
                v-model="form.quantity"
                type="number"
                min="1"
                :error="errors.quantity ?? ''"
            />
        </div>

        <!-- Price -->
        <div>
            <TextInput
                id="price"
                label="Price" 
                placheholder="Enter Price"
                v-model="form.price"
                type="number"
                step="0.01"
                :error="errors.pricess ?? ''"
            />
        </div>

        <!-- Discount -->
        <div>
            <TextInput
                id="discount"
                label="Discount" 
                placheholder="Enter Discount"
                v-model="form.discount"
                type="number"
                step="0.01"
                min="0"
                max="100"
                :error="errors.discount ?? ''"
            />

        </div>

        <!-- Gender -->
        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <select 
                id="gender"
                v-model="form.gender"
                class="w-full p-2 mt-1 border rounded"
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
                class="w-full p-2 mt-1 border rounded"
                :error="errors.image ?? ''"
            />

            <!-- Preview Uploaded Image -->
            <!-- <div v-if="imagePreview" class="mt-3">
                <img :src="imagePreview" alt="Product Image" class="object-cover w-32 h-32 rounded">
            </div> -->
        </div>
    </div>

    <!-- Description -->
    <div class="mt-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea 
            id="description"
            v-model="form.description"
            class="w-full p-2 mt-1 border rounded"
        ></textarea>
    </div>

    <slot name="action-button">
    </slot>

</template>

<script setup>
import AppLayout from '@/Layouts/Admin/App.vue';
import PrimaryButton from '@/Components/Button/Primary.vue';
import TextInput from '@/Components/Input/Textbox.vue'
import { ref } from 'vue';
import SecondaryButton from '@/Components/Button/Secondary.vue';



const errors = ref({})


// Props
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});


const handleImageUpload = (event) => {
    const file = event.target.files[0];
    form.image = file;
};




</script>
