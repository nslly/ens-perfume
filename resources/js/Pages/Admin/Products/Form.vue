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
                :error="errors.name ?? ''"
            />
        </div>

        <!-- Category -->
        <div>
            <SelectInput 
                v-model="form.category_id"
                label="Category"
                :options="categories"
                placeholder="Choose a category"
                :error="errors.category_roid ?? ''"
            />
        </div>

        <!-- Brand -->
        <div>
            <SelectInput 
                v-model="form.brand_id"
                label="Brand"
                :options="brands"
                placeholder="Choose a brand"
                :error="errors.brand_id ?? ''"
            />
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
            <SelectInput 
                v-model="form.gender"
                label="Gender"
                :options="[
                    { id: '1', name: 'Male' },
                    { id: '2', name: 'Female' },
                    { id: '3', name: 'Unisex' }
                ]"
                placeholder="Choose Gender"
                :error="errors.gender ?? ''"
            />
        </div>

        <!-- Image Upload -->
        <div class="col-span-2">
            <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
            <input 
                id="image"
                type="file"
                @change="handleImageUpload"
                multiple
                :error="errors.images ?? ''"
            />

            <!-- Preview New Uploaded Images -->
            <div v-if="imagePreview.length" class="grid grid-cols-3 gap-2 mt-3">
                <img v-for="(image, index) in imagePreview" :key="index" :src="image" alt="Preview"
                    class="object-cover w-32 h-32 rounded">
            </div>

            <!-- Display Existing Images from JSON -->
            <div v-if="form.images" class="grid grid-cols-3 gap-2 mt-3">
                <img v-for="(image, index) in form.images" :key="index" :src="image" alt="Existing Image"
                    class="object-cover w-32 h-32 rounded">
            </div>
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
import SelectInput from '@/Components/Input/Select.vue'
import { ref, defineExpose } from 'vue';
import SecondaryButton from '@/Components/Button/Secondary.vue';



const errors = ref({})


// Props
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    brands: {
        type: Array,
        required: true,
    }
});


const imagePreview = ref([]);
const newFiles = ref([]); 

const handleImageUpload = (event) => {
    const files = event.target.files;
    if (!files.length) return;

    imagePreview.value = [];
    newFiles.value = Array.from(files);;

    for (const file of newFiles.value) {

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value.push(e.target.result);
        };
    }
};

//  Expose newFiles so parent can access it
defineExpose({
    newFiles
});


</script>
