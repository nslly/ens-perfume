<template>
    <Head title="Reset Password" />
    
    <AppLayout>
        <div class="flex justify-center items-center h-screen">
            <form @submit.prevent="submit">
                <div class="bg-white w-96 p-6 rounded-lg shadow-md space-y-6">
                    <h1 class="text-xl font-bold text-center">Reset Password</h1>
                    
                    <TextInput
                        v-model="form.email"
                        label="Email Address"
                        type="email"
                        placeholder="Enter your email"
                        :error="errors.email ?? ''"
                    />

                    <TextInput
                        v-model="form.password"
                        label="New Password"
                        type="password"
                        placeholder="Enter your new password"
                        :error="errors.password ?? ''"
                    />

                    <TextInput
                        v-model="form.password_confirmation"
                        label="Confirm Password"
                        type="password"
                        placeholder="Confirm your new password"
                        :error="errors.password_confirmation ?? ''"
                    />
                    
                    <PrimaryButton type="submit" class="w-full">
                        Reset Password
                    </PrimaryButton>

                    <p v-if="status" class="text-green-500 text-sm text-center">
                        {{ status }}
                    </p>

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

    const errors = ref({})
    const status = ref('')

    const form = useForm({
        email: '',
        password: '',
        password_confirmation: '',
        token: '', // Token is passed from URL
    })

    const submit = () => {
        form.post('/reset-password', {
            onSuccess: () => {
                status.value = 'Password has been reset successfully. You can now log in.'
            },
            onError: (err) => {
                errors.value = { ...err }
            }
        })
    }
</script>
