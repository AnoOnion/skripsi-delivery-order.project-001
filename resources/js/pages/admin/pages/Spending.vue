<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Pengeluaran</div>
            </nav>

            <div class="flex justify-between items-center space-x-4 whitespace-nowrap">
                <div>
                    <h6 class="text-sm font-semibold">Pengeluaran Keuangan.</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar pengeluaran semua keuangan.</p>
                </div>

                <div>
                    <button @click="state.addSpending.modal = true" class="flex items-center space-x-1.5 px-3 py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
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
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">NAMA</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">CATATAN</td>
                        <td class="px-3 md:px-5 py-3 text-center font-medium text-slate-500 tracking-wider">STATUS</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">JUMLAH</td>
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
                                <div>Lorem, ipsum dolor.</div>
                                <div class="text-xs text-slate-500">Ditambahkan Oleh Admin</div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4">Lorem ipsum dolor sit amet consectetur.</td>
                            <td class="px-3 md:px-5 py-3 md:py-4">
                                <div class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full before:bg-white text-white bg-white/50">Ada</div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">Rp. 00.000</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td class="px-3 md:px-5 py-3 md:py-4"></td>
                        </tr>
                    </template>

                    <template v-else>
                        <tr v-for="(spending, index) in state.pagination.listSpending" :key="index" class="text-sm">
                            <th class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap text-slate-500">{{ index + 1 + state.pagination.begin }}.</th>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">
                                <div class="capitalize">{{ spending.nama }}</div>
                                <div class="text-xs text-slate-500">Ditambahkan {{ spending.nama_depan ? 'Oleh ' + spending.nama_depan : 'Otomatis' }}</div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer">{{ spending.catatan ?? 'Tidak Ada' }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4">
                                <div v-if="spending.status == 'belum'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full before:bg-white text-white bg-white/50">Belum</div>

                                <div v-if="spending.status == 'terbayar'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-emerald-600 after:dark:bg-emerald-400 before:bg-emerald-600 before:dark:bg-emerald-400 text-emerald-600 dark:text-emerald-400 bg-emerald-500/50">Terbayar</div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">Rp. {{ spending.jumlah.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.") }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">{{ day(spending.created_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">{{ day(spending.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td class="sticky right-0 px-3 md:px-5 py-4 bg-slate-100 dark:bg-slate-900">
                                <div class="flex items-center space-x-3">
                                    <button @click="editSpending(spending.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <button v-if="store.getters['auth/level'] == 'admin'" @click="removeSpending(spending.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="state.spending.length == 0">
                            <td colspan="8" class="py-4 text-center text-sm">
                                Pengeluaran Belum Ada.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan 1 sampai {{ state.pagination.listSpending.length }} dari {{ state.spending.length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= state.spending.length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <TransitionRoot appear :show="state.addSpending.modal" as="template">
            <Dialog as="div" :open="state.addSpending.modal" @close="state.addSpending.modal = false">
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
                        <Form @submit="addSpending" :validation-schema="schema" v-slot="{ errors }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Tambah Pengeluaran</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Lorem ipsum dolor sit amet.</p>
                                </div>

                                <button type="button" @click="state.addSpending.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="spending-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Pengeluaran</label>

                                    <div :class="errors['nama'] || state.addSpending.error.message.errors?.nama ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="nama" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="spending-name" placeholder="Lorem, ipsum dolor." />
                                    </div>

                                    <ErrorMessage name="nama" class="text-xs text-rose-500" />
                                    <span v-if="state.addSpending.error.message.errors?.nama" v-html="state.addSpending.error.message.errors.nama[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="noted" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Catatan</label>

                                    <div :class="errors['catatan'] || state.addSpending.error.message.errors?.catatan ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field as="textarea" name="catatan" class="w-full h-20 text-xs font-semibold bg-transparent focus:outline-none" id="noted" />
                                    </div>

                                    <ErrorMessage name="catatan" class="text-xs text-rose-500" />
                                    <span v-if="state.addSpending.error.message.errors?.catatan" v-html="state.addSpending.error.message.errors.catatan[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="total" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jumlah</label>

                                    <div :class="errors['jumlah'] || state.addSpending.error.message.errors?.jumlah ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="jumlah" type="number" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="total" placeholder="20" />
                                    </div>

                                    <ErrorMessage name="jumlah" class="text-xs text-rose-500" />
                                    <span v-if="state.addSpending.error.message.errors?.jumlah" v-html="state.addSpending.error.message.errors.jumlah[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="status" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Status</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="status" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="coupon">
                                            <div :class="errors['status'] || state.addSpending.error.message.errors?.status ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { label: 'belum' },
                                                        { label: 'terbayar' }
                                                    ]"
                                                    v-bind="field"
                                                    key-prop="label"
                                                    label-prop="label"
                                                />
                                            </div>
                                        </Field>
                                    </div>

                                    <ErrorMessage name="status" class="text-xs text-rose-500" />
                                    <span v-if="state.addSpending.error.message.errors?.status" v-html="state.addSpending.error.message.errors.status[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-rose-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Batal</h6>
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

        <TransitionRoot appear :show="state.updateSpending.modal" as="template">
            <Dialog as="div" :open="state.updateSpending.modal" @close="state.updateSpending.modal = false">
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
                        <Form @submit="updateSpending" :validation-schema="schema" v-slot="{ errors }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Edit Pengeluaran</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Lorem ipsum dolor sit amet.</p>
                                </div>

                                <button type="button" @click="state.updateSpending.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="spending-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Pengeluaran</label>

                                    <div :class="errors['nama'] || state.updateSpending.error.message.errors?.nama ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="nama" :value="state.updateSpending.data.nama" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="spending-name" placeholder="Lorem, ipsum dolor." />
                                    </div>

                                    <ErrorMessage name="nama" class="text-xs text-rose-500" />
                                    <span v-if="state.updateSpending.error.message.errors?.nama" v-html="state.updateSpending.error.message.errors.nama[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="noted" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Catatan</label>

                                    <div :class="errors['catatan'] || state.updateSpending.error.message.errors?.catatan ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field as="textarea" name="catatan" :value="state.updateSpending.data.catatan" class="w-full h-20 text-xs font-semibold bg-transparent focus:outline-none" id="noted" />
                                    </div>

                                    <ErrorMessage name="catatan" class="text-xs text-rose-500" />
                                    <span v-if="state.updateSpending.error.message.errors?.catatan" v-html="state.updateSpending.error.message.errors.catatan[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="total" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jumlah</label>

                                    <div :class="errors['jumlah'] || state.updateSpending.error.message.errors?.jumlah ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="jumlah" type="number" :value="state.updateSpending.data.jumlah" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="total" placeholder="20" />
                                    </div>

                                    <ErrorMessage name="jumlah" class="text-xs text-rose-500" />
                                    <span v-if="state.updateSpending.error.message.errors?.jumlah" v-html="state.updateSpending.error.message.errors.jumlah[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="status" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Status</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="status" :value="state.updateSpending.data.status" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="coupon">
                                            <div :class="errors['status'] || state.updateSpending.error.message.errors?.status ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { label: 'belum' },
                                                        { label: 'terbayar' }
                                                    ]"
                                                    v-bind="field"
                                                    :value="field.value"
                                                    key-prop="label"
                                                    label-prop="label"
                                                />
                                            </div>
                                        </Field>
                                    </div>

                                    <ErrorMessage name="status" class="text-xs text-rose-500" />
                                    <span v-if="state.updateSpending.error.message.errors?.status" v-html="state.updateSpending.error.message.errors.status[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-rose-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Batal</h6>
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

        <TransitionRoot appear :show="state.deleteSpending.modal" as="template">
            <Dialog as="div" :open="state.deleteSpending.modal" @close="state.deleteSpending.modal = false">
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
                                    <h6 class="text-sm font-semibold">Hapus Pengeluaran</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Lorem ipsum dolor sit amet.</p>
                                </div>

                                <button @click="state.deleteSpending.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <p class="text-sm">Apakah anda ingin menghapus data pengeluaran ini ?</p>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-slate-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Batal</h6>
                                    </button>

                                    <button @click="deleteSpending" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-rose-500 focus:outline-none">
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

    import { object, string, number, date } from 'yup'

    import SelectInput from '~/components/form/SelectInput'
    import { Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            SelectInput,
            Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const day       = inject('day')

            const store     = useStore()
            const state     = reactive({
                spending: [],
                loading: true,

                pagination: {
                    begin: 0,
                    end: 10,
                    listSpending: []
                },

                addSpending: {
                    modal: false,
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                },

                updateSpending: {
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

                deleteSpending: {
                    id: null,
                    modal: false
                }
            })

            const schema = object({
                nama: string().required().min(4).max(30),
                catatan: string().nullable(),
                status: string().nullable(),
                jumlah: number().required()
            })

            const pageControl = (direction = null) => {
                if (direction === 'left') {
                    state.pagination.begin -= 10
                    state.pagination.end -= 10
                } else if (direction === 'right') {
                    state.pagination.begin += 10
                    state.pagination.end += 10
                }

                state.pagination.listSpending = state.spending.slice(
                    state.pagination.begin, state.pagination.end
                )
            }

            const editSpending = (id) => {
                axios.get('/api/admin/spending/' + id).then(({ data }) => {
                    state.updateSpending.modal = true
                    state.updateSpending.data  = data.results
                })
            }

            const removeSpending = (id) => {
                state.deleteSpending = {
                    id, modal: true
                }
            }

            const addSpending = (values) => {
                axios.post('/api/admin/spending', values).then(() => {
                    state.loading           = true
                    state.addSpending.modal = false

                    axios.get('/api/admin/spending').then(({ data }) => {
                        state.loading  = false
                        state.spending = data.results

                        pageControl()
                    })
                }).catch(({ response }) => {
                    state.addSpending.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const updateSpending = (values) => {
                axios.patch('/api/admin/spending/' + state.updateSpending.data.id, values).then(() => {
                    state.loading              = true
                    state.updateSpending.modal = false

                    axios.get('/api/admin/spending').then(({ data }) => {
                        state.loading  = false
                        state.spending = data.results

                        pageControl()
                    })
                }).catch(({ response }) => {
                    state.updateSpending.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const deleteSpending = () => {
                axios.delete('/api/admin/spending/' + state.deleteSpending.id).then(() => {
                    state.deleteSpending.modal = false

                    state.spending.splice(
                        state.spending.findIndex(v => v.id == state.deleteSpending.id), 1
                    )

                    pageControl()
                })
            }

            onMounted(() => {
                axios.get('/api/admin/spending').then(({ data }) => {
                    state.loading  = false
                    state.spending = data.results

                    pageControl()
                })
            })

            return {
                day,
                store, state,
                schema,
                pageControl, editSpending, removeSpending,
                addSpending, updateSpending, deleteSpending
            }
        }
    }
</script>
