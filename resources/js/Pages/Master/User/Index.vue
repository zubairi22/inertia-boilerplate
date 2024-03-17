<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import LinkButton from "@/Components/LinkButton.vue";
import PageNav from "@/Components/PageNav.vue";
import TableHead from "@/Components/TableHead.vue";
import {inject, watch} from "vue";
import {throttle} from "lodash";
import DeleteButton from "@/Components/DeleteButton.vue";
import CorrectionSVG from "@/Components/Svg/CorrectionSVG.vue";

defineProps(['users']);

const swal = inject('$swal')
const form = useForm({
    search: '',
});

const throttledSearch = throttle(() => {
    if (form.search) {
        router.get('/users', {search: form.search}, {
            only: ['users'],
            preserveState: true,
            preserveScroll: true,
        })
    } else {
        router.get('/users')
    }
}, 500);

const deleteUser = (user) => {
    swal({
        title: "Hapus Pengguna",
        text: "Data pengguna pada aplikasi ini akan dihapus secara permanen",
        icon: "warning",
        confirmButtonText: "Hapus",
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('users.destroy' , user))
        }
    });
}

watch(() => form.search, () => {
    throttledSearch();
});
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pengguna</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between">
                            <div>
                                <LinkButton class="px-4" :href="route('users.create')">Tambah Pengguna</LinkButton>
                            </div>
                            <div class="md:text-right mb-3">
                                <input
                                    type="search"
                                    id="user-search"
                                    v-model="form.search"
                                    class="inline-block w-42 lg:w-80 rounded-lg border border-gray-300 bg-gray-50 p-2 pl-5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-gray-500 dark:focus:ring-gray-500"
                                    placeholder="Cari Pengguna"
                                />
                            </div>
                        </div>
                        <div>
                            <table class="table-auto w-full text-sm text-left whitespace-no-wrap">
                                <thead>
                                <tr>
                                    <TableHead class="rounded-tl rounded-bl w-36">Nomor</TableHead>
                                    <TableHead>Username</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead class="w-8"/>
                                    <TableHead class="rounded-tr rounded-br w-8"/>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(user, i) in users.data">
                                    <td class="px-4 py-4">{{ i + 1 }}</td>
                                    <td class="px-4 py-4">{{ user.name }}</td>
                                    <td class="px-4 py-4">{{ user.email }}</td>
                                    <td>
                                        <LinkButton class="bg-yellow-600 dark:bg-yellow-500" :href="route('users.edit', user)">
                                            <CorrectionSVG/>
                                        </LinkButton>
                                    </td>
                                    <td>
                                        <DeleteButton @click="deleteUser(user)"/>
                                    </td>
                                </tr>
                                <tr v-if="!users.total">
                                    <td class="px-4 py-4 text-base" colspan="2">Pengguna tidak ditemukan</td>
                                </tr>
                                </tbody>
                            </table>
                            <PageNav :links="users.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
