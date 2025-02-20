<template>
    <Head title="Admin Login" />

    <div class="flex items-center justify-center w-screen h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-[550px]">
            <h1 class="text-2xl font-bold flex justify-center items-center">Admin Login</h1>
            <form @submit.prevent="login">
                <div class="py-8 px-6 rounded-xl space-y-8">
                    <div class="space-y-6">
                        <TextInput 
                            v-model="form.email" 
                            label="Email" 
                            type="email"
                            placeholder="Enter your email"
                            :error="errors.email ?? ''"

                        />

                        <TextInput 
                            v-model="form.password" 
                            label="Password" 
                            type="password"
                            placeholder="Enter your password"
                            :error="errors.password ?? ''" 


                        />
                    </div>
                    <p v-if="errors.error" class="text-red-500 text-sm">{{ errors.error }}</p>
                    
                    <div class="flex justify-between items-center spacex-8">
                        <Checkbox v-model="form.remember" label="Remember Me" />
                    </div>
                    <div class="w-full">
                        <PrimaryButton type="submit" class="text-lg w-full">
                            Login 
                        </PrimaryButton>
                    </div>

                </div>
            </form>

        </div>
    </div>
</template>

<script setup>
    import { Head, useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import TextInput from '@/Components/Input/Textbox.vue';
    import PrimaryButton from '@/Components/Button/Primary.vue';
    import Checkbox from '@/Components/Input/Checkbox.vue';


    /**
     * 
     * States
     */


    const errors = ref({});

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });


    /**
     * 
     * Functions
     */


    const login = () => {
        form.post('/admin/login', {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Login successful')
            },
            onError: (err) => {
                console.log(err);
                errors.value = { ...err }
            }
        });
        
    };
</script>
