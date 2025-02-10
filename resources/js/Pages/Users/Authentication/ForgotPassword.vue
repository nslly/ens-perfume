<template>
    <Head title="Forgot Password" />
    
    <AppLayout>
        <div class="flex justify-center items-center h-screen">
            <form @submit.prevent="submit">
                <div class="bg-white w-96 p-6 rounded-lg shadow-md space-y-6">
                    <h1 class="text-xl font-bold text-center">Forgot Password</h1>
                    
                    <TextInput
                        v-model="form.email"
                        label="Email Address"
                        type="email"
                        placeholder="Enter your email"
                        :error="errors.email ?? ''"
                    />
                    
                    <PrimaryButton type="submit" class="w-full">
                        Send Reset Link
                    </PrimaryButton>

                    <p class="text-sm text-center">
                        <Link href="/login" class="text-blue-500">Back to Login</Link>
                    </p>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import TextInput from '@/Components/Input/Textbox.vue'
import PrimaryButton from '@/Components/Button/Primary.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
    const errors = ref({});
    const form = useForm({
        email: '',
    })

    const submit = () => {
        form.post('/forgot-password')
    }
</script>
