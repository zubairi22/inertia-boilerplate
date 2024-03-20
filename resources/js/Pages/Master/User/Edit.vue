<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const { user, roles } = defineProps(['user', 'roles']);

const form = useForm({
    name: user.name,
    email: user.email,
    password: '',
    role: user.role
});

</script>

<template>
    <Head title="Edit Pengguna"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <Link class="hover:text-gray-500" :href="route('master.users.index')">Pengguna</Link> / Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-4xl bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="form.patch(route('master.users.update', user))">
                            <div>
                                <div>
                                    <InputLabel for="name" value="Name"/>

                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />

                                    <InputError class="mt-2" :message="form.errors.name"/>
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="email" value="Email"/>

                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                        autocomplete="username"
                                    />

                                    <InputError class="mt-2" :message="form.errors.email"/>
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="password" value="Password"/>

                                    <TextInput
                                        id="password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password"
                                        autocomplete="new-password"
                                    />

                                    <InputError class="mt-2" :message="form.errors.password"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="role" value="Role"/>

                                    <select v-model="form.role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option disabled value="">Pilih Role</option>
                                        <option v-for="(option) in roles" :value="option.id">{{ option.name }}</option>
                                    </select>

                                    <InputError class="mt-2" :message="form.errors.role"/>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">SIMPAN</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
