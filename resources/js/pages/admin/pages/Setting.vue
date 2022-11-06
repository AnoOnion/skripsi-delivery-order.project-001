<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Pengaturan</div>
            </nav>

            <div class="whitespace-nowrap">
                <h6 class="text-sm font-semibold">Pengaturan Akun Anda.</h6>
                <p class="text-xs text-slate-700 dark:text-slate-300">Lengkapi semua data diri dan pastikan akun aman.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
            <div class="block space-y-3 md:space-y-4">
                <div class="grid grid-cols-12 gap-x-3 gap-y-4 relative w-full p-4 rounded-lg shadow-md bg-slate-50 dark:bg-slate-800">
                    <div class="col-span-12 flex justify-center items-center space-x-3">
                        <div class="relative">
                            <img :src="store.getters['auth/user'].avatar" alt="Foto Profil" class="w-12 aspect-square rounded-full">

                            <button @click="state.avatar.modal = true" class="absolute bottom-0 right-0 p-1 rounded-md bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>

                        <div>
                            <h6 class="text-sm font-semibold">{{ store.getters['auth/user'].nama_depan + ' ' + store.getters['auth/user'].nama_belakang }}</h6>
                            <p class="text-xs text-slate-700 dark:text-slate-300">Bergabung sejak {{ store.getters['auth/user'].created_at }}</p>
                        </div>
                    </div>
                </div>

                <Form @submit="updateProfile" :validation-schema="schemaProfile" v-slot="{ errors }" class="grid grid-cols-12 gap-x-3 gap-y-4 relative w-full p-4 rounded-lg shadow-md bg-slate-50 dark:bg-slate-800">
                    <div class="col-span-12 flex justify-between items-center">
                        <div>
                            <h6 class="text-sm font-semibold">Pengaturan Profil</h6>
                            <p class="text-2xs text-slate-700 dark:text-slate-300">Sesuaikan dengan data dirimu sekarang.</p>
                        </div>

                        <button class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
                    </div>

                    <div v-if="state.profile.success.status || state.profile.error.status" :class="state.profile.success.status ? 'text-emerald-500' : 'text-rose-500'" class="col-span-12 flex items-center space-x-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="state.profile.success.status ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'" />
                        </svg>

                        <h6 class="capitalize text-sm font-bold">{{ state.profile.success.status ? state.profile.success.message : state.profile.error.message.message }}</h6>
                    </div>

                    <div class="col-span-6 flex flex-col space-y-2">
                        <label for="first-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Depan</label>

                        <div :class="errors['nama_depan'] || state.profile.error.message.errors?.nama_depan ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                            <Field @keydown="delete state.profile.error.message.errors['nama_depan']" name="nama_depan" :value="store.getters['auth/user'].nama_depan" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="first-name" placeholder="Muh Husni" />
                        </div>

                        <ErrorMessage name="nama_depan" class="text-xs text-rose-500" />
                        <span v-if="state.profile.error.message.errors?.nama_depan" v-html="state.profile.error.message.errors.nama_depan[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="col-span-6 flex flex-col space-y-2">
                        <label for="last-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Belakang</label>
                        
                        <div :class="errors['nama_belakang'] || state.profile.error.message.errors?.nama_belakang ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                            <Field @keydown="delete state.profile.error.message.errors['nama_belakang']" name="nama_belakang" :value="store.getters['auth/user'].nama_belakang" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="last-name" placeholder="Mubarok" />
                        </div>

                        <ErrorMessage name="nama_belakang" class="text-xs text-rose-500" />
                        <span v-if="state.profile.error.message.errors?.nama_belakang" v-html="state.profile.error.message.errors.nama_belakang[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="col-span-12 flex flex-col space-y-2">
                        <label for="email" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Email</label>

                        <div class="flex justify-between items-center px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                            <Field name="email" type="email" :value="store.getters['auth/user'].email" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="email" readonly />
                        </div>
                    </div>

                    <div class="col-span-5 flex flex-col space-y-2">
                        <label for="gender" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jenis Kelamin</label>

                        <div class="relative overscroll-contain">
                            <Field name="jenis_kelamin" :value="store.getters['auth/user'].jenis_kelamin" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="gender">
                                <div :class="errors['jenis_kelamin'] || state.profile.error.message.errors?.jenis_kelamin ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                    <SelectInput
                                        :options="[
                                            { key: 'l', label: 'Laki-laki' },
                                            { key: 'p', label: 'Perempuan' }
                                        ]"
                                        v-bind="field"
                                        :value="field.value"
                                        key-prop="key"
                                        label-prop="label"
                                    />
                                </div>
                            </Field>
                        </div>

                        <ErrorMessage name="jenis_kelamin" class="text-xs text-rose-500" />
                        <span v-if="state.profile.error.message.errors?.jenis_kelamin" v-html="state.profile.error.message.errors.jenis_kelamin[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="col-span-7 flex flex-col space-y-2">
                        <label for="birth" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>

                        <div :class="errors['tanggal_lahir'] || state.profile.error.message.errors?.tanggal_lahir ? 'border-rose-500' : 'border-transparent'" class="flex justify-between items-center px-3 py-2 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                            <Field @keydown="delete state.profile.error.message.errors['tanggal_lahir']" name="tanggal_lahir" type="date" :value="store.getters['auth/user'].tanggal_lahir" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="birth" />
                        </div>

                        <ErrorMessage name="tanggal_lahir" class="text-xs text-rose-500" />
                        <span v-if="state.profile.error.message.errors?.tanggal_lahir" v-html="state.profile.error.message.errors.tanggal_lahir[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="col-span-12 flex flex-col space-y-2">
                        <label for="no-telp" class="text-xs font-semibold text-slate-700 dark:text-slate-300">No Telpon/WA</label>

                        <div :class="errors['no_telpon'] || state.profile.error.message.errors?.no_telpon ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                            <Field @keydown="delete state.profile.error.message.errors['no_telpon']" name="no_telpon" :value="store.getters['auth/user'].no_telpon" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="no-telp" placeholder="08950736xxxx" />
                        </div>

                        <ErrorMessage name="no_telpon" class="text-xs text-rose-500" />
                        <span v-if="state.profile.error.message.errors?.no_telpon" v-html="state.profile.error.message.errors.no_telpon[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="col-span-12 flex items-center justify-end space-x-2">
                        <button type="reset" class="px-3 py-2 text-xs rounded-md text-white bg-rose-500">Reset</button>
                        <button class="px-3 py-2 text-xs rounded-md text-white bg-blue-500">Simpan</button>
                    </div>
                </Form>
            </div>

            <div class="block space-y-3 md:space-y-4">
                <Form @submit="changePassword" :validation-schema="schemaSecurity" v-slot="{ errors }" class="grid grid-cols-12 gap-x-3 gap-y-4 relative w-full p-4 rounded-lg shadow-md bg-slate-50 dark:bg-slate-800">
                    <div class="col-span-12 flex justify-between items-center">
                        <div>
                            <h6 class="text-sm font-semibold">Keamanan Akun</h6>
                            <p class="text-2xs text-slate-700 dark:text-slate-300">Pastikan keamanan akun anda terjamin.</p>
                        </div>

                        <button class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
                    </div>

                    <div v-if="state.security.success.status || state.security.error.status" :class="state.security.success.status ? 'text-emerald-500' : 'text-rose-500'" class="col-span-12 flex items-center space-x-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="state.security.success.status ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'" />
                        </svg>

                        <h6 class="capitalize text-sm font-bold">{{ state.security.success.status ? state.security.success.message : state.security.error.message.message }}</h6>
                    </div>

                    <div class="col-span-12 flex flex-col space-y-2">
                        <label for="old-password" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Password Lama</label>

                        <div :class="errors['old_password'] || state.security.error.message.errors?.old_password ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                            <Field @keydown="delete state.security.error.message.errors['old_password']" name="old_password" type="password" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="old-password" placeholder="Masukan password lama" />
                        </div>

                        <ErrorMessage name="old_password" class="text-xs text-rose-500" />
                        <span v-if="state.security.error.message.errors?.old_password" v-html="state.security.error.message.errors.old_password[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="col-span-6 flex flex-col space-y-2">
                        <label for="new-password" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Password Baru</label>

                        <div :class="errors['new_password'] || state.security.error.message.errors?.new_password ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                            <Field @keydown="delete state.security.error.message.errors['new_password']" name="new_password" type="password" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="new-password" placeholder="Masukan password baru" />
                        </div>

                        <ErrorMessage name="new_password" class="text-xs text-rose-500" />
                        <span v-if="state.security.error.message.errors?.new_password" v-html="state.security.error.message.errors.new_password[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="col-span-6 flex flex-col space-y-2">
                        <label for="new-password-confirm" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Ulangi Password Baru</label>

                        <div :class="errors['new_password_confirmation'] || state.security.error.message.errors?.new_password_confirmation ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                            <Field @keydown="delete state.security.error.message.errors['new_password_confirmation']" name="new_password_confirmation" type="password" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="new-password-confirm" placeholder="Ulangi password baru" />
                        </div>

                        <ErrorMessage name="new_password_confirmation" class="text-xs text-rose-500" />
                        <span v-if="state.security.error.message.errors?.new_password_confirmation" v-html="state.security.error.message.errors.new_password_confirmation[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="col-span-12 flex justify-end">
                        <button class="px-3 py-2 text-xs rounded-md text-white bg-blue-500">Ganti</button>
                    </div>
                </Form>
            </div>
        </div>

        <TransitionRoot appear :show="state.avatar.modal" as="template">
            <Dialog as="div" @close="state.avatar.modal = false">
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="min-h-screen px-4 text-center">
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                        >
                            <DialogOverlay class="fixed inset-0" />
                        </TransitionChild>

                        <span class="inline-block h-screen align-middle" aria-hidden="true">
                            &#8203;
                        </span>

                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <div class="inline-block w-full max-w-md p-4 rounded-lg transform align-middle overflow-hidden shadow-md bg-slate-800">
                                <file-pond
                                    name="photo"
                                    label-idle="Drag &amp; Drop your files or <span class='filepond--label-action'> Browse </span>"
                                    accepted-file-types="image/jpeg, image/png, image/jpg"

                                    :allow-multiple="false"
                                    @processfile="state.avatar.modal = false"
                                    :server="{
                                        url: baseurl + 'api/admin/avatar',
                                        process: {
                                            headers: {
                                                Authorization: 'Bearer ' + store.getters['auth/token']
                                            },
                                            onload: () => store.dispatch('auth/fetchUser'),
                                        }
                                    }"
                                />
                            </div>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script>
    import 'filepond/dist/filepond.min.css'
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'

    import { useStore } from 'vuex'
    import { inject, reactive } from '@vue/runtime-core'

    import axios from 'axios'

    import vueFilePond from 'vue-filepond'
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'

    import { object, string, date, ref } from 'yup'

    import SelectInput from '~/components/form/SelectInput'
    import { Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    const FilePond = vueFilePond(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateType
    )

    export default {
        components: {
            FilePond,
            SelectInput,
            Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const day      = inject('day')
            const baseurl  = inject('baseurl')

            const store    = useStore()
            const state    = reactive({
                avatar: {
                    modal: false
                },

                profile: {
                    success: {
                        status: false,
                        message: null
                    },
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                },

                security: {
                    success: {
                        status: false,
                        message: null
                    },
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                }
            })

            const schemaProfile = object({
                nama_depan: string().required().min(3),
                nama_belakang: string().nullable().min(3),
                email: string().required().email(),
                jenis_kelamin: string().nullable(),
                tanggal_lahir: date().nullable(),
                no_telpon: string().nullable()
            })

            const schemaSecurity = object({
                old_password: string().required().min(8),
                new_password: string().required().min(8),
                new_password_confirmation: string().required().oneOf([ref('new_password'), null], 'Sandi harus sesuai')
            })

            const updateProfile = async (values) => {
                state.profile.success.status = false
                state.profile.error.status = false

                axios.patch('/api/admin/profile', values).then(({ data }) => {
                    store.dispatch('auth/saveDataUser', {
                        user: {
                            ...store.getters['auth/user'],
                            nama_depan: values.nama_depan,
                            nama_belakang: values.nama_belakang,
                            jenis_kelamin: values.jenis_kelamin,
                            no_telpon: values.no_telpon
                        }
                    })

                    state.profile.success = {
                        status: true,
                        message: data.message
                    }
                }).catch(({ response }) => {
                    state.profile.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const changePassword = async (values) => {
                state.security.success.status = false
                state.security.error.status = false

                axios.patch('/api/admin/password', values).then(({ data }) => {
                    state.security.success = {
                        status: true,
                        message: data.message
                    }
                }).catch(({ response }) => {
                    state.security.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            return {
                day, baseurl,
                store, state,
                schemaProfile, schemaSecurity,
                updateProfile, changePassword
            }
        }
    }
</script>
