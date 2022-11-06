<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Informasi</div>
            </nav>

            <div class="flex justify-between items-center space-x-4 whitespace-nowrap">
                <div>
                    <h6 class="text-sm font-semibold">Informasi Tentang Berita.</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar informasi yang akan diberikan pelanggan.</p>
                </div>

                <div>
                    <button v-if="store.getters['auth/level'] == 'admin'" @click="state.addInfo.modal = true" class="flex items-center space-x-1.5 px-3 py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
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
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">GAMBAR</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">JUDUL</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">DESKRIPSI</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">DIBUAT</td>
                        <td v-if="store.getters['auth/level'] == 'admin'" class="sticky md:static right-0 px-3 md:px-5 py-3 bg-white dark:bg-slate-800/50"></td>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    <template v-if="state.loading">
                        <tr v-for="loading in 3" :key="loading" class="text-sm font-flow">
                            <td class="px-3 md:px-5 py-3 md:py-4 text-slate-500">x.</td>
                            <td class="px-3 md:px-5 py-3 md:py-4">
                                <div class="w-20 aspect-square rounded-md bg-slate-800/50"></div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">
                                <div>Lorem ipsum dolor sit.</div>
                                <div class="text-xs whitespace-nowrap text-slate-500">Diposting Oleh Admin</div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">Lorem ipsum dolor sit amet consectetur.</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td v-if="store.getters['auth/level'] == 'admin'" class="px-3 md:px-5 py-3"></td>
                        </tr>
                    </template>

                    <template v-else>
                        <tr v-for="(info, index) in state.pagination.listInformations" :key="index" class="text-sm">
                            <th @click="detailInformation(info.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap text-slate-500">{{ index + 1 + state.pagination.begin }}.</th>
                            <td @click="detailInformation(info.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">
                                <img :src="info.gambar" class="w-20 aspect-square rounded-md object-cover" />
                            </td>
                            <td @click="detailInformation(info.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer">
                                <div>{{ info.judul }}</div>
                                <div class="text-xs whitespace-nowrap text-slate-500">Diposting Oleh {{ info.nama_depan }}</div>
                            </td>
                            <td @click="detailInformation(info.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer">{{ info.deskripsi }}</td>
                            <td @click="detailInformation(info.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ day(info.created_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td v-if="store.getters['auth/level'] == 'admin'" class="sticky md:static right-0 px-3 md:px-5 py-3 bg-slate-100 dark:bg-slate-900">
                                <div class="flex items-center space-x-3">
                                    <button @click="editInformation(info.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    
                                    <button @click="removeInformation(info.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="state.informations.length == 0">
                            <td colspan="7" class="py-4 text-center text-sm">
                                Informasi Belum Ada.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan {{ state.pagination.listInformations.length > 0 ? '1' : '0' }} sampai {{ state.pagination.listInformations.length }} dari {{ state.informations.length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= state.informations.length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <TransitionRoot appear :show="state.detailInfo.modal" as="template">
            <Dialog as="div" :open="state.detailInfo.modal" @close="state.detailInfo.modal = false">
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
                                    <h6 class="text-sm font-semibold">Detail Informasi</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Informasi berita yang akan dibaca oleh pelanggan.</p>
                                </div>

                                <button @click="state.detailInfo.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="block space-y-4">
                                <div>
                                    <h6 class="text-sm font-semibold capitalize">{{ state.detailInfo.data.judul }}</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Diposting Oleh {{ state.detailInfo.data.nama_depan }} &middot; {{ day(state.detailInfo.data.created_at).format('DD MMM YYYY - HH:mm') }}</p>
                                </div>

                                <div>
                                    <img :src="state.detailInfo.data.gambar" class="float-none md:float-left w-full md:w-56 mr-0 md:mr-4 mb-3 md:mb-0 aspect-video rounded-md object-cover" />
                                    <p class="text-sm">{{ state.detailInfo.data.deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="state.addInfo.modal" as="template">
            <Dialog as="div" :open="state.addInfo.modal" @close="state.addInfo.modal = false">
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
                        <Form @submit="addInformation" :validation-schema="schema" v-slot="{ errors, resetForm }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Posting Informasi Sekarang</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Masukan berita yang akan dibaca oleh pelanggan.</p>
                                </div>

                                <button type="button" @click="state.addInfo.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="title" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Judul</label>

                                    <div :class="errors['judul'] || state.addInfo.error.message.errors?.judul ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="judul" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="title" placeholder="Lorem, ipsum dolor." />
                                    </div>

                                    <ErrorMessage name="judul" class="text-xs text-rose-500" />
                                    <span v-if="state.addInfo.error.message.errors?.judul" v-html="state.addInfo.error.message.errors.judul[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="description" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Deskripsi</label>

                                    <div :class="errors['deskripsi'] || state.addInfo.error.message.errors?.deskripsi ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field as="textarea" name="deskripsi" class="w-full h-20 text-xs font-semibold bg-transparent focus:outline-none" id="description" />
                                    </div>

                                    <ErrorMessage name="deskripsi" class="text-xs text-rose-500" />
                                    <span v-if="state.addInfo.error.message.errors?.deskripsi" v-html="state.addInfo.error.message.errors.deskripsi[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Gambar</label>

                                    <div :class="errors['gambar'] || state.addInfo.error.message.errors?.gambar ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <label class="block">
                                            <span class="sr-only">Choose File</span>
                                            <Field name="gambar" type="file" accept="image/jpeg, image/png, image/jpg" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:text-white dark:file:text-blue-500 file:bg-blue-500 dark:file:bg-slate-300" />
                                        </label>
                                    </div>

                                    <ErrorMessage name="gambar" class="text-xs text-rose-500" />
                                    <span v-if="state.addInfo.error.message.errors?.gambar" v-html="state.addInfo.error.message.errors.gambar[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="resetForm({
                                        values: {
                                            judul: '',
                                            deskripsi: ''
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

        <TransitionRoot appear :show="state.updateInfo.modal" as="template">
            <Dialog as="div" :open="state.updateInfo.modal" @close="state.updateInfo.modal = false">
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
                        <Form @submit="updateInformation" :validation-schema="schema" v-slot="{ errors, resetForm }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Edit Informasi</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Perbarui informasi berita sekarang.</p>
                                </div>

                                <button type="button" @click="state.updateInfo.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="title" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Judul</label>

                                    <div :class="errors['judul'] || state.updateInfo.error.message.errors?.judul ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="judul" :value="state.updateInfo.data.judul" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="title" placeholder="Lorem, ipsum dolor." />
                                    </div>

                                    <ErrorMessage name="judul" class="text-xs text-rose-500" />
                                    <span v-if="state.updateInfo.error.message.errors?.judul" v-html="state.updateInfo.error.message.errors.judul[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="description" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Deskripsi</label>

                                    <div :class="errors['deskripsi'] || state.updateInfo.error.message.errors?.deskripsi ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field as="textarea" name="deskripsi" :value="state.updateInfo.data.deskripsi" class="w-full h-20 text-xs font-semibold bg-transparent focus:outline-none" id="description" />
                                    </div>

                                    <ErrorMessage name="deskripsi" class="text-xs text-rose-500" />
                                    <span v-if="state.updateInfo.error.message.errors?.deskripsi" v-html="state.updateInfo.error.message.errors.deskripsi[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Gambar</label>

                                    <div :class="errors['gambar'] || state.updateInfo.error.message.errors?.gambar ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <label class="block">
                                            <span class="sr-only">Choose File</span>
                                            <Field name="gambar" type="file" accept="image/jpeg, image/png, image/jpg" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:text-white dark:file:text-blue-500 file:bg-blue-500 dark:file:bg-slate-300" />
                                        </label>
                                    </div>

                                    <ErrorMessage name="gambar" class="text-xs text-rose-500" />
                                    <span v-if="state.updateInfo.error.message.errors?.gambar" v-html="state.updateInfo.error.message.errors.gambar[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="resetForm({
                                        values: {
                                            judul: state.updateInfo.data.judul,
                                            deskripsi: state.updateInfo.data.deskripsi
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

        <TransitionRoot appear :show="state.deleteInfo.modal" as="template">
            <Dialog as="div" :open="state.deleteInfo.modal" @close="state.deleteInfo.modal = false">
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
                                    <h6 class="text-sm font-semibold">Hapus Informasi Berita</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Hapus permanen data informasi berita yang dipilih.</p>
                                </div>

                                <button @click="state.deleteInfo.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <p class="text-sm">Apakah anda ingin menghapus data informasi ini ?</p>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="state.deleteInfo.modal = false" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-slate-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Batal</h6>
                                    </button>

                                    <button @click="deleteInformation" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-rose-500 focus:outline-none">
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

    import { object, string, mixed } from 'yup'

    import { Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const day       = inject('day')

            const store     = useStore()
            const state     = reactive({
                informations: [],
                loading: true,

                pagination: {
                    begin: 0,
                    end: 10,
                    listInformations: []
                },

                detailInfo: {
                    modal: false,
                    value: null
                },

                addInfo: {
                    modal: false,
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                },

                updateInfo: {
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

                deleteInfo: {
                    id: null,
                    modal: false
                }
            })

            const schema = object({
                judul: string().required().min(5).max(60),
                deskripsi: string().nullable().max(1500),
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

            const pageControl = (direction = null) => {
                if (direction === 'left') {
                    state.pagination.begin -= 10
                    state.pagination.end -= 10
                } else if (direction === 'right') {
                    state.pagination.begin += 10
                    state.pagination.end += 10
                }

                state.pagination.listInformations = state.informations.slice(
                    state.pagination.begin, state.pagination.end
                )
            }

            const detailInformation = (id) => {
                axios.get('/api/admin/information/' + id).then(({ data }) => {
                    state.detailInfo = {
                        data: data.results,
                        modal: true
                    }
                })
            }

            const editInformation = (id) => {
                axios.get('/api/admin/information/' + id).then(({ data }) => {
                    state.updateInfo.modal = true
                    state.updateInfo.data  = data.results
                })
            }

            const removeInformation = (id) => {
                state.deleteInfo = {
                    id, modal: true
                }
            }

            const addInformation = (values) => {
                let formData = new FormData()

                Object.entries(values).forEach(([key, value]) => {
                    formData.append(key, key == 'gambar' ? ((value ?? [])[0] ?? '') : value)
                })

                axios.post('/api/admin/information', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(() => {
                    state.loading       = true
                    state.addInfo.modal = false

                    axios.get('/api/admin/information').then(({ data }) => {
                        state.loading      = false
                        state.informations = data.results

                        pageControl()
                    })
                }).catch(({ response }) => {
                    state.addInfo.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const updateInformation = (values) => {
                let formData = new FormData()

                formData.append('_method', 'PATCH')

                Object.entries(values).forEach(([key, value]) => {
                    formData.append(key, key == 'gambar' ? ((value ?? [])[0] ?? '') : value)
                })

                axios.post('/api/admin/information/' + state.updateInfo.data.id, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(() => {
                    state.loading          = true
                    state.updateInfo.modal = false

                    axios.get('/api/admin/information').then(({ data }) => {
                        state.loading      = false
                        state.informations = data.results

                        pageControl()
                    })
                }).catch(({ response }) => {
                    state.updateInfo.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const deleteInformation = () => {
                axios.delete('/api/admin/information/' + state.deleteInfo.id).then(() => {
                    state.deleteInfo.modal = false

                    state.informations.splice(
                        state.informations.findIndex(v => v.id == state.deleteInfo.id), 1
                    )

                    pageControl()
                })
            }

            onMounted(() => {
                axios.get('/api/admin/information').then(({ data }) => {
                    state.loading      = false
                    state.informations = data.results

                    pageControl()
                })
            })

            return {
                day,
                store, state,
                schema,
                pageControl, detailInformation, editInformation, removeInformation,
                addInformation, updateInformation, deleteInformation
            }
        }
    }
</script>
