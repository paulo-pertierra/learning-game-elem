<script lang="ts" setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { User } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { ref } from 'vue';

const page = usePage();

const users = page.props.users as any;

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "teacher",
    grade_level: 1
});


const addingNewUser = ref(false);

const addNewUser = () => {
    if (form.role === 'admin') (form.grade_level as any) = null;

    form.post('/users', {
        onFinish: () => {
            window.location.reload()
        },
        onError: (error) => console.log(error)
    });
}

const currentUserId = ref(0);
const editingUser = ref(false);

const updateUser = () => {
    (form.password as any) = null;
    (form.password_confirmation as any) = null;
    form.post(`/users/${currentUserId.value}`, {
        onFinish: () => {
            window.location.reload()
        }
    });
}

const closeModal = () => {
    addingNewUser.value = false;
    editingUser.value = false;
}

const confirmingUserDeletion = ref(false);

const closeUserDeletionModal = () => {
    confirmingUserDeletion.value = false;
}

const deleteProcessing = ref(false);
const deleteUser = (id: string) => {
    deleteProcessing.value = true;
    form.delete(`/users/${id}`, {
        onFinish: () => {
            window.location.reload();
            deleteProcessing.value = false;
        }
    })
}

const selectedUserId = ref("");

watch(form, () => {
    console.log(form.grade_level);
})
</script>

<template>
    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">All Users List
                    </h2>
                    <PrimaryButton @click="addingNewUser = true">Add New User</PrimaryButton>
                </div>

                <div class="relative overflow-x-auto">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg overflow-hidden">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-4">
                                    Full Name
                                </th>
                                <th scope="col" class="px-3 py-4">
                                    Email
                                </th>
                                <th scope="col" class="px-3 py-4">
                                    Role
                                </th>
                                <th scope="col" class="px-3 py-4">
                                    Grade Level
                                </th>
                                <th scope="col" class="px-3 py-4">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ user.name }}
                                </th>
                                <td class="px-3 py-4">
                                    {{ user.email }}
                                </td>
                                <td class="px-3 py-4 first-letter:uppercase">
                                    {{ user.role }}
                                </td>
                                <td v-if="user.role != 'admin'" class="px-3 py-4 first-letter:uppercase">
                                    Grade {{ user.grade_level }}
                                </td>
                                <td v-else class="px-3 py-4 first-letter:uppercase">
                                    None
                                </td>
                                <td class="px-3 py-4">
                                    <button
                                        @click="editingUser = true, currentUserId = user.id"
                                        class="mr-2 text-orange-400 border-orange-400 border p-2 rounded-lg">Edit</button>
                                    <button v-if="user.id !== $page.props.auth.user.id"
                                        @click="confirmingUserDeletion = true, selectedUserId = user.id"
                                        class="text-red-600  border-red-600 border p-2 rounded-lg">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
    <Modal :show="addingNewUser">
        <form name="create-user" class="p-6" @submit.prevent="addNewUser">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Add New User
            </h2>
            <div class="my-4">
                <InputLabel>Full Name</InputLabel>
                <TextInput id="user-name" type="text" class="mt-1 block w-full" v-model="form.name!" required
                    autofocus />
                <InputError :message="$page.props.errors.name" />
            </div>
            <div class="my-4">
                <InputLabel>Email</InputLabel>
                <TextInput id="user-description" type="text" class="mt-1 block w-full" v-model="form.email!"
                    required autofocus />
                <InputError :message="$page.props.errors.email" />
            </div>
            <div class="my-4">
                <InputLabel>Password</InputLabel>
                <TextInput id="user-description" type="text" class="mt-1 block w-full" v-model="form.password"
                    required autofocus />
                <InputError :message="$page.props.errors.password" />
            </div>
            <div class="my-4">
                <InputLabel>Confirm Password</InputLabel>
                <TextInput id="user-description" type="text" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autofocus />
                <InputError :message="$page.props.errors.password_confirmation" />
            </div>
            <!-- <div class="my-4 ">
                <InputLabel>Role</InputLabel>
                <div class="grid grid-cols-2 gap-2 py-2">
                    <SecondaryButton :active="form.role === 'admin'" @click="form.role = 'admin'">Admin
                    </SecondaryButton>
                    <SecondaryButton :active="form.role === 'teacher'" @click="form.role = 'teacher'">Teacher
                    </SecondaryButton>
                    <InputError class="col-span-4"
                        :message="$page.props.errors.role ? 'Quarter for this material is required.' : ''" />
                </div>
            </div> -->
            <div class="my-4" v-if="form.role === 'teacher'">
                <InputLabel>Grade Level</InputLabel>
                <select class="w-full g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="grade_level" v-model="form.grade_level" id="">
                    <option :value="1">Grade 1</option>
                    <option :value="2">Grade 2</option>
                    <option :value="3">Grade 3</option>
                </select>
                <!-- <div class="grid grid-cols-3 gap-2 py-2">
                    <SecondaryButton :active="form.grade_level == 1" @click="form.grade_level = 1">Grade 1
                    </SecondaryButton>
                    <SecondaryButton :active="form.grade_level == 2" @click="form.grade_level = 2">Grade 2
                    </SecondaryButton>
                    <SecondaryButton :active="form.grade_level == 3" @click="form.grade_level = 3">Grade 3
                    </SecondaryButton>
                    <InputError class="col-span-4"
                        :message="$page.props.errors.grade_level ? 'Quarter for this material is required.' : ''" />
                </div> -->
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register User
                </PrimaryButton>
            </div>
        </form>
    </Modal>
    <Modal :show="editingUser">
        <form name="edit-user" class="p-6" @submit.prevent="updateUser">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit User
            </h2>
            <div class="my-4 ">
                <InputLabel>Role</InputLabel>
                <div class="grid grid-cols-2 gap-2 py-2">
                    <SecondaryButton :active="form.role === 'admin'" @click="form.role = 'admin'">Admin
                    </SecondaryButton>
                    <SecondaryButton :active="form.role === 'teacher'" @click="form.role = 'teacher'">Teacher
                    </SecondaryButton>
                    <InputError class="col-span-4"
                        :message="$page.props.errors.role ? 'Quarter for this material is required.' : ''" />
                </div>
            </div>
            <div class="my-4" v-if="form.role === 'teacher'">
                <InputLabel>Grade Level</InputLabel>
                <div class="grid grid-cols-3 gap-2 py-2">
                    <SecondaryButton :active="form.grade_level == 1" @click="form.grade_level = 1">Grade 1
                    </SecondaryButton>
                    <SecondaryButton :active="form.grade_level == 2" @click="form.grade_level = 2">Grade 2
                    </SecondaryButton>
                    <SecondaryButton :active="form.grade_level == 3" @click="form.grade_level = 3">Grade 3
                    </SecondaryButton>
                    <InputError class="col-span-4"
                        :message="$page.props.errors.grade_level ? 'Quarter for this material is required.' : ''" />
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register User
                </PrimaryButton>
            </div>
        </form>
    </Modal>
    <Modal :show="confirmingUserDeletion" @close="closeUserDeletionModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this user?
            </h2>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeUserDeletionModal"> Cancel </SecondaryButton>

                <DangerButton class="ms-3" :class="{ 'opacity-25': deleteProcessing }" :disabled="deleteProcessing"
                    @click="deleteUser(selectedUserId)">
                    Delete User
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>