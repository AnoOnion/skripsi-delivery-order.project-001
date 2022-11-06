<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Member</div>
            </nav>

            <div class="flex justify-between items-center space-x-4 whitespace-nowrap">
                <div>
                    <h6 class="text-sm font-semibold">Admin Yang Terverifikasi.</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar admin yang terdaftar sebagai anggota.</p>
                </div>

                <div>
                    <button @click="state.addMember.modal = true" class="flex items-center space-x-1.5 px-3 py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>

                        <h6 class="text-xs">Tambah</h6>
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-auto">
            <table class="min-w-full divide-y divide-slate-50 dark:divide-slate-800">
                <thead class="bg-white dark:bg-slate-800/50">
                    <tr class="text-xs">
                        <th class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">NO</th>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">NAMA ADMIN</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">LEVEL</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">JENIS KELAMIN</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">TANGGAL LAHIR</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">NO TELPON</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">DIBUAT</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">DIEDIT</td>
                        <td class="sticky md:static right-0 px-3 md:px-5 py-3 bg-white dark:bg-slate-800/50"></td>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    <template v-if="state.loading">
                        <tr v-for="loading in 3" :key="loading" class="text-sm font-flow">
                            <td class="px-3 md:px-5 py-3 md:py-4 text-slate-500">x.</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 aspect-square rounded-full bg-slate-800/50"></div>

                                    <div>
                                        <div>Lorem, ipsum dolor.</div>
                                        <div class="text-xs text-slate-500">admin@admin.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">Lorem.</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">Lorem, ipsum.</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">Belum Ada</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">000000000000</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td class="px-3 md:px-5 py-3"></td>
                        </tr>
                    </template>

                    <template v-else>
                        <tr v-for="(member, index) in state.pagination.listMembers" :key="index" class="text-sm">
                            <th class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap text-slate-500">{{ index + 1 + state.pagination.begin }}.</th>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10">
                                        <img :src="member.avatar" referrerpolicy="no-referrer" alt="Foto Profil" class="w-10 aspect-square rounded-full">
                                    </div>

                                    <div>
                                        <div>{{ member.nama_depan + ' ' + (member.nama_belakang ?? '') }}</div>
                                        <div class="text-xs text-slate-500">{{ member.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">{{ member.level ?? 'Belum Ada' }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">
                                <template v-if="member.jenis_kelamin">
                                    {{ member.jenis_kelamin == 'l' ? 'Laki - laki' : 'Perempuan' }}
                                </template>

                                <template v-else>
                                    Belum Ada
                                </template>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">{{ member.tanggal_lahir ? day(member.tanggal_lahir).format('DD MMM YYYY') : 'Belum Ada' }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">{{ member.no_telpon ?? 'Belum Ada' }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">{{ day(member.created_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">{{ day(member.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td class="sticky right-0 px-3 md:px-5 py-3 md:py-4 bg-slate-100 dark:bg-slate-900">
                                <div class="flex items-center space-x-3">
                                    <button @click="editMember(member.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <button v-if="store.getters['auth/user'].email != member.email" @click="removeMember(member.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan {{ state.pagination.listMembers.length > 0 ? '1' : '0' }} sampai {{ state.pagination.listMembers.length }} dari {{ state.members.length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= state.members.length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <TransitionRoot appear :show="state.addMember.modal" as="template">
            <Dialog as="div" :open="state.addMember.modal" @close="state.addMember.modal = false">
                <div class="flex justify-center items-center fixed inset-0 px-4 z-50">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                        <DialogOverlay class="fixed inset-0 backdrop-filter backdrop-blur-[1px]" />
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
                        <Form @submit="addMember" :validation-schema="schema" v-slot="{ errors, resetForm }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Tambah Akun Admin</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Masukan akun baru untuk admin maupun kurir.</p>
                                </div>

                                <button type="button" @click="state.addMember.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="first-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Depan</label>
                                    
                                    <div :class="errors['nama_depan'] || state.addMember.error.message.errors?.nama_depan ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="nama_depan" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="first-name" placeholder="Muh Husni" />
                                    </div>

                                    <ErrorMessage name="nama_depan" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.nama_depan" v-html="state.addMember.error.message.errors.nama_depan[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="last-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Belakang</label>
                                    
                                    <div :class="errors['nama_belakang'] || state.addMember.error.message.errors?.nama_belakang ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="nama_belakang" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="last-name" placeholder="Mubarok" />
                                    </div>

                                    <ErrorMessage name="nama_belakang" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.nama_belakang" v-html="state.addMember.error.message.errors.nama_belakang[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="level" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Level</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="level" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="level">
                                            <div :class="errors['level'] || state.addMember.error.message.errors?.level ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { label: 'admin' },
                                                        { label: 'kurir' }
                                                    ]"
                                                    v-bind="field"
                                                    key-prop="label"
                                                    label-prop="label"
                                                />
                                            </div>
                                        </Field>
                                    </div>

                                    <ErrorMessage name="level" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.level" v-html="state.addMember.error.message.errors.level[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-8 flex flex-col space-y-2">
                                    <label for="email" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Email</label>

                                    <div :class="errors['email'] || state.addMember.error.message.errors?.email ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="email" type="email" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="email" placeholder="customain@gmail.com" />
                                    </div>

                                    <ErrorMessage name="email" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.email" v-html="state.addMember.error.message.errors.email[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="password" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Password</label>
                                    
                                    <div :class="errors['password'] || state.addMember.error.message.errors?.password ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="password" type="password" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="password" placeholder="abcd123" />
                                    </div>

                                    <ErrorMessage name="password" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.password" v-html="state.addMember.error.message.errors.password[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="password-confirm" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Ulangi Password</label>
                                    
                                    <div :class="errors['password_confirmation'] || state.addMember.error.message.errors?.password_confirmation ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="password_confirmation" type="password" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="password-confirm" placeholder="abcd123" />
                                    </div>

                                    <ErrorMessage name="password_confirmation" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.password_confirmation" v-html="state.addMember.error.message.errors.password_confirmation[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-5 flex flex-col space-y-2">
                                    <label for="gender" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jenis Kelamin</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="jenis_kelamin" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="gender">
                                            <div :class="errors['jenis_kelamin'] || state.addMember.error.message.errors?.jenis_kelamin ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { key: 'l', label: 'Laki-laki' },
                                                        { key: 'p', label: 'Perempuan' }
                                                    ]"
                                                    v-bind="field"
                                                    key-prop="key"
                                                    label-prop="label"
                                                />
                                            </div>
                                        </Field>
                                    </div>

                                    <ErrorMessage name="jenis_kelamin" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.jenis_kelamin" v-html="state.addMember.error.message.errors.jenis_kelamin[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-7 flex flex-col space-y-2">
                                    <label for="birth" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>

                                    <div :class="errors['tanggal_lahir'] || state.addMember.error.message.errors?.tanggal_lahir ? 'border-rose-500' : 'border-transparent'" class="flex justify-between items-center px-3 py-2 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="tanggal_lahir" type="date" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="birth" />
                                    </div>

                                    <ErrorMessage name="tanggal_lahir" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.tanggal_lahir" v-html="state.addMember.error.message.errors.tanggal_lahir[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Gambar Profil</label>

                                    <div :class="errors['gambar'] || state.addMember.error.message.errors?.gambar ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <label class="block">
                                            <span class="sr-only">Choose File</span>
                                            <Field name="gambar" type="file" accept="image/jpeg, image/png, image/jpg" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:text-white dark:file:text-blue-500 file:bg-blue-500 dark:file:bg-slate-300" />
                                        </label>
                                    </div>

                                    <ErrorMessage name="gambar" class="text-xs text-rose-500" />
                                    <span v-if="state.addMember.error.message.errors?.gambar" v-html="state.addMember.error.message.errors.gambar[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="resetForm({
                                        values: {
                                            nama_depan: '',
                                            nama_belakang: '',
                                            level: '',
                                            email: '',
                                            jenis_kelamin: '',
                                            tanggal_lahir: '',
                                            password: '',
                                            password_confirmation: ''
                                        }
                                    })" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-slate-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Reset</h6>
                                    </button>

                                    <button class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-blue-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Tambah</h6>
                                    </button>
                                </div>
                            </div>
                        </Form>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="state.updateMember.modal" as="template">
            <Dialog as="div" :open="state.updateMember.modal" @close="state.updateMember.modal = false">
                <div class="flex justify-center items-center fixed inset-0 px-4 z-50">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                        <DialogOverlay class="fixed inset-0 backdrop-filter backdrop-blur-[1px]" />
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
                        <Form @submit="updateMember" :validation-schema="schemaUpdate" v-slot="{ errors, resetForm }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Edit Akun Admin</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Perbarui data akun admin sekarang.</p>
                                </div>

                                <button type="button" @click="state.updateMember.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="first-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Depan</label>
                                    
                                    <div :class="errors['nama_depan'] || state.updateMember.error.message.errors?.nama_depan ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="nama_depan" :value="state.updateMember.data.nama_depan" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="first-name" placeholder="Muh Husni" />
                                    </div>

                                    <ErrorMessage name="nama_depan" class="text-xs text-rose-500" />
                                    <span v-if="state.updateMember.error.message.errors?.nama_depan" v-html="state.updateMember.error.message.errors.nama_depan[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="last-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Belakang</label>
                                    
                                    <div :class="errors['nama_belakang'] || state.updateMember.error.message.errors?.nama_belakang ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="nama_belakang" :value="state.updateMember.data.nama_belakang" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="last-name" placeholder="Mubarok" />
                                    </div>

                                    <ErrorMessage name="nama_belakang" class="text-xs text-rose-500" />
                                    <span v-if="state.updateMember.error.message.errors?.nama_belakang" v-html="state.updateMember.error.message.errors.nama_belakang[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="level" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Level</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="level" :value="state.updateMember.data.level" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="level">
                                            <div :class="errors['level'] || state.updateMember.error.message.errors?.level ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { label: 'admin' },
                                                        { label: 'kurir' }
                                                    ]"
                                                    v-bind="field"
                                                    :value="field.value"
                                                    key-prop="label"
                                                    label-prop="label"
                                                />
                                            </div>
                                        </Field>
                                    </div>

                                    <ErrorMessage name="level" class="text-xs text-rose-500" />
                                    <span v-if="state.updateMember.error.message.errors?.level" v-html="state.updateMember.error.message.errors.level[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-8 flex flex-col space-y-2">
                                    <label for="email" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Email</label>

                                    <div :class="errors['email'] || state.updateMember.error.message.errors?.email ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="email" type="email" :value="state.updateMember.data.email" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="email" placeholder="customain@gmail.com" readonly />
                                    </div>

                                    <ErrorMessage name="email" class="text-xs text-rose-500" />
                                    <span v-if="state.updateMember.error.message.errors?.email" v-html="state.updateMember.error.message.errors.email[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="password" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Password</label>
                                    
                                    <div :class="errors['password'] || state.updateMember.error.message.errors?.password ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="password" type="password" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="password" placeholder="abcd123" />
                                    </div>

                                    <ErrorMessage name="password" class="text-xs text-rose-500" />
                                    <span v-if="state.updateMember.error.message.errors?.password" v-html="state.updateMember.error.message.errors.password[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="password-confirm" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Ulangi Password</label>
                                    
                                    <div :class="errors['password_confirmation'] || state.updateMember.error.message.errors?.password_confirmation ? 'border-rose-500' : 'border-transparent'" class="px-3 py-1.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="password_confirmation" type="password" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="password-confirm" placeholder="abcd123" />
                                    </div>

                                    <ErrorMessage name="password_confirmation" class="text-xs text-rose-500" />
                                    <span v-if="state.updateMember.error.message.errors?.password_confirmation" v-html="state.updateMember.error.message.errors.password_confirmation[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-5 flex flex-col space-y-2">
                                    <label for="gender" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jenis Kelamin</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="jenis_kelamin" :value="state.updateMember.data.jenis_kelamin" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="gender">
                                            <div :class="errors['jenis_kelamin'] || state.updateMember.error.message.errors?.jenis_kelamin ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
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
                                    <span v-if="state.updateMember.error.message.errors?.jenis_kelamin" v-html="state.updateMember.error.message.errors.jenis_kelamin[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-7 flex flex-col space-y-2">
                                    <label for="birth" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>

                                    <div :class="errors['tanggal_lahir'] || state.updateMember.error.message.errors?.tanggal_lahir ? 'border-rose-500' : 'border-transparent'" class="flex justify-between items-center px-3 py-2 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="tanggal_lahir" type="date" :value="state.updateMember.data.tanggal_lahir" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="birth" />
                                    </div>

                                    <ErrorMessage name="tanggal_lahir" class="text-xs text-rose-500" />
                                    <span v-if="state.updateMember.error.message.errors?.tanggal_lahir" v-html="state.updateMember.error.message.errors.tanggal_lahir[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="resetForm({
                                        values: {
                                            nama_depan: state.updateMember.data.nama_depan,
                                            nama_belakang: state.updateMember.data.nama_belakang,
                                            level: state.updateMember.data.level,
                                            email: state.updateMember.data.email,
                                            jenis_kelamin: state.updateMember.data.jenis_kelamin,
                                            tanggal_lahir: state.updateMember.data.tanggal_lahir,
                                            password: '',
                                            password_confirmation: ''
                                        }
                                    })" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-slate-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Reset</h6>
                                    </button>

                                    <button class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-blue-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Ubah</h6>
                                    </button>
                                </div>
                            </div>
                        </Form>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="state.deleteMember.modal" as="template">
            <Dialog as="div" :open="state.deleteMember.modal" @close="state.deleteMember.modal = false">
                <div class="flex justify-center items-center fixed inset-0 px-4 z-50">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                        <DialogOverlay class="fixed inset-0 backdrop-filter backdrop-blur-[1px]" />
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
                        <div class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Hapus Anggota</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Hapus permanen data anggota yang dipilih.</p>
                                </div>

                                <button @click="state.deleteMember.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <p class="text-sm">Apakah anda ingin menghapus data anggota ini ?</p>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="state.deleteMember.modal = false" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-slate-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Batal</h6>
                                    </button>

                                    <button @click="deleteMember" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-rose-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Hapus</h6>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script>
    import { useStore } from 'vuex'
    import { inject, onMounted, reactive } from '@vue/runtime-core'

    import axios from 'axios'

    import { object, string, date, ref, mixed } from 'yup'

    import SelectInput from '~/components/form/SelectInput'
    import { Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        middleware: 'role-level:admin',

        components: {
            SelectInput,
            Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const day       = inject('day')

            const store     = useStore()
            const state     = reactive({
                members: [],
                loading: true,
                
                pagination: {
                    begin: 0,
                    end: 10,
                    listMembers: []
                },

                addMember: {
                    modal: false,
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                },

                updateMember: {
                    data: null,
                    modal: false,
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                },

                deleteMember: {
                    id: null,
                    modal: false
                }
            })

            const schema = object({
                nama_depan: string().required().min(3),
                nama_belakang: string().nullable(),
                level: string().required(),
                email: string().required().email(),
                jenis_kelamin: string().nullable(),
                tanggal_lahir: date().nullable(),
                password: string().required(),
                password_confirmation: string().required().oneOf([ref('password'), null], 'Passwords must match'),
                gambar: mixed()
                            .test('fileSize', 'Ukuran file terlalu besar', val => {
                                return val?.filter(v => v.size <= 2097152).length == val?.length
                            })
                            .test('fileType', 'Format file tidak didukung', val => {
                                return val?.filter(v => [
                                    'image/jpeg', 'image/png', 'image/jpg'
                                ].includes(v.type)).length == val?.length
                            }),
            })

            const schemaUpdate = object({
                nama_depan: string().required().min(3),
                nama_belakang: string().nullable(),
                level: string().required(),
                email: string().required().email(),
                jenis_kelamin: string().nullable(),
                tanggal_lahir: date().nullable(),
                password: string().nullable(),
                password_confirmation: string().nullable().oneOf([ref('password'), null], 'Sandi harus sesuai')
            })

            const pageControl = (direction = null) => {
                if (direction === 'left') {
                    state.pagination.begin -= 10
                    state.pagination.end -= 10
                } else if (direction === 'right') {
                    state.pagination.begin += 10
                    state.pagination.end += 10
                }

                state.pagination.listMembers = state.members.slice(
                    state.pagination.begin, state.pagination.end
                )
            }

            const editMember = (id) => {
                axios.get('/api/admin/member/' + id).then(({ data }) => {
                    state.updateMember.modal = true
                    state.updateMember.data  = data.results
                })
            }

            const removeMember = (id) => {
                state.deleteMember = {
                    id, modal: true
                }
            }

            const addMember = (values) => {
                let formData = new FormData()

                Object.entries(values).forEach(([key, value]) => {
                    formData.append(key, key == 'gambar' ? ((value ?? [])[0] ?? '') : value)
                })

                axios.post('/api/admin/member', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(() => {
                    state.loading         = true
                    state.addMember.modal = false

                    axios.get('/api/admin/member').then(({ data }) => {
                        state.loading = false
                        state.members = data.results

                        pageControl()
                    })
                }).catch(({ response }) => {
                    state.addMember.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const updateMember = (values) => {
                axios.patch('/api/admin/member/' + state.updateMember.data.id, values).then(() => {
                    state.loading            = true
                    state.updateMember.modal = false

                    axios.get('/api/admin/member').then(({ data }) => {
                        state.loading = false
                        state.members = data.results

                        pageControl()
                    })
                }).catch(({ response }) => {
                    state.updateMember.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const deleteMember = () => {
                axios.delete('/api/admin/member/' + state.deleteMember.id).then(() => {
                    state.deleteMember.modal = false

                    state.members.splice(
                        state.members.findIndex(v => v.id == state.deleteMember.id), 1
                    )

                    pageControl()
                })
            }

            onMounted(() => {
                axios.get('/api/admin/member').then(({ data }) => {
                    state.loading = false
                    state.members = data.results

                    pageControl()
                })
            })

            return {
                day,
                store, state,
                schema, schemaUpdate,
                pageControl, editMember, removeMember,
                addMember, updateMember, deleteMember
            }
        }
    }
</script>
