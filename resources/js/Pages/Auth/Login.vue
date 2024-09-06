<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const loginWithGoogle = () => {
    window.location.href = '/auth/google/redirect';
};

const loginWithFacebook = () => {
    window.location.href = '/auth/facebook/redirect';
};

const loginWithGithub = () => {
    window.location.href = '/auth/github/redirect';
};

// const loginWithLinkedln = () => {
//     window.location.href = '/auth/linkedln/redirect';
// };

</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div>
            <PrimaryButton @click="loginWithGoogle" class="w-full my-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <span class="mx-auto">
                     Sign in with Google
                </span>
                <img src="/google-icon-logo-svgrepo-com.svg" alt="" width="20px">
            </PrimaryButton>

            <PrimaryButton @click="loginWithFacebook" class="w-full my-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <span class="mx-auto">
                     Sign in with Facebook
                </span>
                <img src="/facebook-icon-logo-svgrepo-com.svg" alt="" width="20px">
            </PrimaryButton>

            <PrimaryButton @click="loginWithGithub" class="w-full my-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <span class="mx-auto">
                     Sign in with Github
                </span>
                <img src="/github-logo-svgrepo-com.svg" alt="" width="20px">
            </PrimaryButton>

            <!-- <PrimaryButton @click="loginWithLinkedln" class="w-full my-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <span class="mx-auto">
                     Sign with Linkedln
                </span>
                <img src="/linkedin-icon-svgrepo-com.svg" alt="" width="20px">
            </PrimaryButton> -->
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
