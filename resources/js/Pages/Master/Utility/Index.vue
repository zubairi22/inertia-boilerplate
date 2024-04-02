<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import TableHead from "@/Components/TableHead.vue";
import {inject, ref} from "vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps(['roles', 'menus']);

const swal = inject('$swal')
const createRoleForm = ref(false)
const formRole = useForm({
    name: '',
});

const formRolePost = () => {
    formRole.post(route('master.utility.role.store'), {
        preserveScroll: true,
        onSuccess: () => createRoleForm.value = false,
        onFinish: () => formRole.reset(),
    })
}

const formRoleDelete = (role) => {
    swal({
        title: "Hapus Role",
        text: "Role akan dihapus secara permanen, pengguna dengan role yang dihapus menjadi tidak memiliki role",
        icon: "warning",
        confirmButtonText: "Hapus",
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('master.utility.role.destroy', role))
        }
    });
}

</script>

<template>
    <Head title="Utility"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Utility</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 md:space-x-4 space-y-4 md:space-y-0">
                    <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <PrimaryButton class="px-4 mb-2" @click="createRoleForm = true">Tambah Role</PrimaryButton>
                            <table class="table-auto w-full text-sm text-left whitespace-no-wrap">
                                <thead>
                                <tr>
                                    <TableHead class="rounded-tl rounded-bl">Role</TableHead>
                                    <TableHead class="rounded-tr rounded-br w-8"/>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(role) in roles.data">
                                    <td class="px-4 py-4">{{ role.name }}</td>
                                    <td>
                                        <DeleteButton @click="formRoleDelete(role)"/>
                                    </td>
                                </tr>
                                <tr v-if="!roles.total">
                                    <td class="px-4 py-4 text-base" colspan="2">Role tidak ditemukan</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <PrimaryButton class="px-4 mb-2" @click="createRoleForm = true">Tambah Menu</PrimaryButton>
                            <table class="table-auto w-full text-sm text-left whitespace-no-wrap">
                                <thead>
                                <tr>
                                    <TableHead class="rounded-tl rounded-bl">Role</TableHead>
                                    <TableHead class="rounded-tr rounded-br w-8"/>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(role) in roles.data">
                                    <td class="px-4 py-4">{{ role.name }}</td>
                                    <td>
                                        <DeleteButton @click="formRoleDelete(role)"/>
                                    </td>
                                </tr>
                                <tr v-if="!roles.total">
                                    <td class="px-4 py-4 text-base" colspan="2">Role tidak ditemukan</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>


    </AuthenticatedLayout>

    <Modal max-width="lg" :show="createRoleForm" @close="createRoleForm = !createRoleForm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Form Penambahan Role
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Masukan nama role yang ingin ditambahkan
            </p>

            <div class="mt-6">

                <TextInput
                    id="role_name"
                    v-model="formRole.name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Admin, User, Etc"
                    @keyup.enter="formRolePost"
                />

                <InputError :message="formRole.errors.role" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="createRoleForm = !createRoleForm"> Batal </SecondaryButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': formRole.processing }"
                    :disabled="formRole.processing"
                    @click="formRolePost"
                >
                    Tambah
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
