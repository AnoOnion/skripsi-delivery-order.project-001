<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Kendaraan</div>
            </nav>

            <div class="flex justify-between items-center space-x-4 whitespace-nowrap">
                <div>
                    <h6 class="text-sm font-semibold">Kendaraan Yang Tersedia.</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar beberapa kendaraan yang digunakan kurir.</p>
                </div>

                <div>
                    <button v-if="store.getters['auth/level'] == 'admin'" @click="state.addVehicle.modal = true" class="flex items-center space-x-1.5 px-3 py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
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
                        <td class="px-3 md:px-5 py-3 text-center font-medium text-slate-500 tracking-wider">GAMBAR</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">NAMA MERK</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">VOLUME BENSIN</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">TANGGAL BERLAKU</td>
                        <td class="px-3 md:px-5 py-3 text-center font-medium text-slate-500 tracking-wider">STATUS</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">DIBUAT</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">DIEDIT</td>
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
                                <div class="text-xs text-slate-500">G 1234 ABC</div>
                                <div>Lorem ipsum dolor sit.</div>
                                <div class="text-xs capitalize text-slate-500">Ditambahkan Oleh Admin</div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4">00 L</td>
                            <td class="px-3 md:px-5 py-3 md:py-4">Belum Ada</td>
                            <td class="px-3 md:px-5 py-3 md:py-4">
                                <div class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full before:bg-white text-white bg-white/50">Ada</div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td v-if="store.getters['auth/level'] == 'admin'" class="px-3 md:px-5 py-3"></td>
                        </tr>
                    </template>

                    <template v-else>
                        <tr v-for="(vehicle, index) in state.pagination.listVehicle" :key="vehicle.id" class="text-sm">
                            <th @click="detailVehicle(vehicle.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap text-slate-500">{{ index + 1 + state.pagination.begin }}.</th>
                            <td @click="detailVehicle(vehicle.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer">
                                <img :src="vehicle.gambar" class="w-20 aspect-square rounded-md object-cover" />
                            </td>
                            <td @click="detailVehicle(vehicle.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">
                                <div class="text-xs text-slate-500">{{ vehicle.plat_nomer }}</div>
                                <div>{{ vehicle.nama_merk }}</div>
                                <div class="text-xs capitalize text-slate-500">Ditambahkan Oleh {{ vehicle.nama_depan }}</div>
                            </td>
                            <td @click="detailVehicle(vehicle.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ vehicle.volume_bensin ? (vehicle.volume_bensin + ' L') : 'Belum Ada' }}</td>
                            <td @click="detailVehicle(vehicle.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ vehicle.tanggal_berlaku ? day(vehicle.tanggal_berlaku).format('DD MMM YYYY') : 'Belum Ada' }}</td>
                            <td @click="detailVehicle(vehicle.id)" class="px-3 md:px-5 py-3 md:py-4">
                                <div v-if="vehicle.status == 'ada'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full before:bg-slate-300 text-black dark:text-white bg-white/50">Ada</div>

                                <div v-if="vehicle.status == 'pakai'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-sky-600 after:dark:bg-sky-400 before:bg-sky-600 before:dark:bg-sky-400 text-sky-600 dark:text-sky-400 bg-sky-500/50">Dipakai</div>

                                <div v-if="vehicle.status == 'masalah'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-rose-600 after:dark:bg-rose-400 before:bg-rose-600 before:dark:bg-rose-400 text-rose-600 dark:text-rose-400 bg-rose-500/50">Masalah</div>

                                <div v-if="vehicle.status == 'perbaikan'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-amber-600 after:dark:bg-amber-400 before:bg-amber-600 before:dark:bg-amber-400 text-amber-600 dark:text-amber-400 bg-amber-500/50">Perbaikan</div>

                                <div v-if="vehicle.status == 'selesai'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-emerald-600 after:dark:bg-emerald-400 before:bg-emerald-600 before:dark:bg-emerald-400 text-emerald-600 dark:text-emerald-400 bg-emerald-500/50">Selesai</div>
                            </td>
                            <td @click="detailVehicle(vehicle.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ day(vehicle.created_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td @click="detailVehicle(vehicle.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ day(vehicle.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td v-if="store.getters['auth/level'] == 'admin'" class="sticky right-0 px-3 md:px-5 py-3 md:py-4 bg-slate-100 dark:bg-slate-900">
                                <div class="flex items-center space-x-3">
                                    <button @click="editVehicle(vehicle.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <button @click="removeVehicle(vehicle.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="state.vehicle.length == 0">
                            <td colspan="9" class="py-4 text-center text-sm">
                                Kendaraan Belum Ada.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan {{ state.pagination.listVehicle.length > 0 ? '1' : '0' }} sampai {{ state.pagination.listVehicle.length }} dari {{ state.vehicle.length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= state.vehicle.length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <TransitionRoot appear :show="state.detailVehicle.modal" as="template">
            <Dialog as="div" :open="state.detailVehicle.modal" @close="state.detailVehicle.modal = false">
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
                                    <h6 class="text-sm font-semibold">Detail Kendaraan</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Daftar informasi lengkap tentang kendaraan ini.</p>
                                </div>

                                <button @click="state.detailVehicle.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-4">
                                    <img :src="state.detailVehicle.data.detail.gambar" class="w-full h-32 rounded-md object-cover" />
                                </div>

                                <div class="col-span-12 md:col-span-8 grid grid-cols-12 gap-4">
                                    <div class="col-span-12">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Nama Merk</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailVehicle.data.detail.nama_merk }}</h6>
                                    </div>

                                    <div class="col-span-4">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Plat Nomer</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailVehicle.data.detail.plat_nomer }}</h6>
                                    </div>
                                    <div class="col-span-4">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Volume Bensin</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailVehicle.data.detail.volume_bensin ?? 'Belum Ada' }}</h6>
                                    </div>
                                    <div class="col-span-4">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Tanggal Berlaku</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailVehicle.data.detail.tanggal_berlaku ? day(state.detailVehicle.data.detail.tanggal_berlaku).format('DD MMM YYYY') : 'Belum Ada' }}</h6>
                                    </div>

                                    <div class="col-span-6">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Dibuat</p>
                                        <h6 class="capitalize text-xs font-semibold">{{ day(state.detailVehicle.data.detail.created_at).format('DD MMM YYYY - HH:mm') }}</h6>
                                    </div>
                                    <div class="col-span-6">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Diedit</p>
                                        <h6 class="capitalize text-xs font-semibold">{{ day(state.detailVehicle.data.detail.updated_at).format('DD MMM YYYY - HH:mm') }}</h6>
                                    </div>
                                </div>

                                <div class="col-span-12 max-h-60 overflow-auto">
                                    <table class="min-w-full divide-y divide-slate-50 dark:divide-slate-700">
                                        <thead class="bg-white dark:bg-slate-700/50">
                                            <tr>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">NO</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">ID UNIQUE</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">STATUS</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">CATATAN</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">ADMIN</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">DIEDIT</td>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                                            <template v-if="state.detailVehicle.data.report.length > 0">
                                                <tr v-for="(report, index) in state.detailVehicle.data.report" :key="index" class="text-xs cursor-pointer">
                                                    <th class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap text-slate-500">{{ index + 1 }}.</th>
                                                    <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ report.kode_laporan }}</td>
                                                    <td class="px-3 md:px-5 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">
                                                        <div v-if="report.status == 'ada'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full before:bg-white text-white bg-white/50">Ada</div>

                                                        <div v-if="report.status == 'pakai'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-sky-600 after:dark:bg-sky-400 before:bg-sky-600 before:dark:bg-sky-400 text-sky-600 dark:text-sky-400 bg-sky-500/50">Dipakai</div>

                                                        <div v-if="report.status == 'masalah'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-rose-600 after:dark:bg-rose-400 before:bg-rose-600 before:dark:bg-rose-400 text-rose-600 dark:text-rose-400 bg-rose-500/50">Masalah</div>

                                                        <div v-if="report.status == 'perbaikan'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-amber-600 after:dark:bg-amber-400 before:bg-amber-600 before:dark:bg-amber-400 text-amber-600 dark:text-amber-400 bg-amber-500/50">Perbaikan</div>

                                                        <div v-if="report.status == 'selesai'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-emerald-600 after:dark:bg-emerald-400 before:bg-emerald-600 before:dark:bg-emerald-400 text-emerald-600 dark:text-emerald-400 bg-emerald-500/50">Selesai</div>
                                                    </td>
                                                    <td class="px-3 md:px-5 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">{{ report.catatan ?? 'Belum Ada' }}</td>
                                                    <td class="px-3 md:px-5 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">{{ report.nama_depan }}</td>
                                                    <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ day(report.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                                                </tr>
                                            </template>

                                            <tr v-if="state.detailVehicle.data.report.length == 0">
                                                <td colspan="10" class="py-4 text-center text-sm">
                                                    Laporan Transaksi Belum Ada.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="state.addVehicle.modal" as="template">
            <Dialog as="div" :open="state.addVehicle.modal" @close="state.addVehicle.modal = false">
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
                        <Form @submit="addVehicle" :validation-schema="schema" v-slot="{ errors, resetForm }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Tambah Kendaraan Kurir</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Masukan kendaraan baru untuk kurir.</p>
                                </div>

                                <button type="button" @click="state.addVehicle.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="number-plate" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Plat Nomer</label>

                                    <div :class="errors['plat_nomer'] || state.addVehicle.error.message.errors?.plat_nomer ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="plat_nomer" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="number-plate" placeholder="G 1234 AGB" />
                                    </div>

                                    <ErrorMessage name="plat_nomer" class="text-xs text-rose-500" />
                                    <span v-if="state.addVehicle.error.message.errors?.plat_nomer" v-html="state.addVehicle.error.message.errors.plat_nomer[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-8 flex flex-col space-y-2">
                                    <label for="brand-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Merk</label>

                                    <div :class="errors['nama_merk'] || state.addVehicle.error.message.errors?.nama_merk ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="nama_merk" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="brand-name" placeholder="Motor ..." />
                                    </div>

                                    <ErrorMessage name="nama_merk" class="text-xs text-rose-500" />
                                    <span v-if="state.addVehicle.error.message.errors?.nama_merk" v-html="state.addVehicle.error.message.errors.nama_merk[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Gambar</label>

                                    <div :class="errors['gambar'] || state.addVehicle.error.message.errors?.gambar ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <label class="block">
                                            <span class="sr-only">Choose File</span>
                                            <Field name="gambar" type="file" accept="image/jpeg, image/png, image/jpg" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:text-white dark:file:text-blue-500 file:bg-blue-500 dark:file:bg-slate-300" />
                                        </label>
                                    </div>

                                    <ErrorMessage name="gambar" class="text-xs text-rose-500" />
                                    <span v-if="state.addVehicle.error.message.errors?.gambar" v-html="state.addVehicle.error.message.errors.gambar[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="gasoline-volume" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Volume Bensin</label>

                                    <div :class="errors['volume_bensin'] || state.addVehicle.error.message.errors?.volume_bensin ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="volume_bensin" type="number" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="gasoline-volume" placeholder="20" />
                                    </div>

                                    <ErrorMessage name="volume_bensin" class="text-xs text-rose-500" />
                                    <span v-if="state.addVehicle.error.message.errors?.volume_bensin" v-html="state.addVehicle.error.message.errors.volume_bensin[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="effective-date" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tanggal Berlaku</label>

                                    <div :class="errors['tanggal_berlaku'] || state.addVehicle.error.message.errors?.tanggal_berlaku ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="tanggal_berlaku" type="date" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="effective-date" />
                                    </div>

                                    <ErrorMessage name="tanggal_berlaku" class="text-xs text-rose-500" />
                                    <span v-if="state.addVehicle.error.message.errors?.tanggal_berlaku" v-html="state.addVehicle.error.message.errors.tanggal_berlaku[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="resetForm({
                                        values: {
                                            plat_nomer: '',
                                            nama_merk: '',
                                            status: '',
                                            volume_bensin: '',
                                            tanggal_berlaku: ''
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

        <TransitionRoot appear :show="state.updateVehicle.modal" as="template">
            <Dialog as="div" :open="state.updateVehicle.modal" @close="state.updateVehicle.modal = false">
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
                        <Form @submit="updateVehicle" :validation-schema="schema" v-slot="{ errors, resetForm }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Edit Kendaraan Kurir</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Perbarui informasi kendaraan sekarang.</p>
                                </div>

                                <button type="button" @click="state.updateVehicle.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="number-plate" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Plat Nomer</label>

                                    <div :class="errors['plat_nomer'] || state.updateVehicle.error.message.errors?.plat_nomer ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="plat_nomer" :value="state.updateVehicle.data.detail.plat_nomer" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="number-plate" placeholder="G 1234 AGB" />
                                    </div>

                                    <ErrorMessage name="plat_nomer" class="text-xs text-rose-500" />
                                    <span v-if="state.updateVehicle.error.message.errors?.plat_nomer" v-html="state.updateVehicle.error.message.errors.plat_nomer[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-8 flex flex-col space-y-2">
                                    <label for="brand-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Merk</label>

                                    <div :class="errors['nama_merk'] || state.updateVehicle.error.message.errors?.nama_merk ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="nama_merk" :value="state.updateVehicle.data.detail.nama_merk" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="brand-name" placeholder="Motor ..." />
                                    </div>

                                    <ErrorMessage name="nama_merk" class="text-xs text-rose-500" />
                                    <span v-if="state.updateVehicle.error.message.errors?.nama_merk" v-html="state.updateVehicle.error.message.errors.nama_merk[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Gambar</label>

                                    <div :class="errors['gambar'] || state.updateVehicle.error.message.errors?.gambar ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <label class="block">
                                            <span class="sr-only">Choose File</span>
                                            <Field name="gambar" type="file" accept="image/jpeg, image/png, image/jpg" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:text-white dark:file:text-blue-500 file:bg-blue-500 dark:file:bg-slate-300" />
                                        </label>
                                    </div>

                                    <ErrorMessage name="gambar" class="text-xs text-rose-500" />
                                    <span v-if="state.updateVehicle.error.message.errors?.gambar" v-html="state.updateVehicle.error.message.errors.gambar[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="status" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Status</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="status" :value="state.updateVehicle.data.detail.status" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="status">
                                            <div :class="errors['status'] || state.updateVehicle.error.message.errors?.status ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { label: 'ada' },
                                                        { label: 'pakai' },
                                                        { label: 'masalah' },
                                                        { label: 'perbaikan' }
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
                                    <span v-if="state.updateVehicle.error.message.errors?.status" v-html="state.updateVehicle.error.message.errors.status[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="gasoline-volume" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Volume Bensin</label>

                                    <div :class="errors['volume_bensin'] || state.updateVehicle.error.message.errors?.volume_bensin ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="volume_bensin" type="number" :value="state.updateVehicle.data.detail.volume_bensin" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="gasoline-volume" placeholder="20" />
                                    </div>

                                    <ErrorMessage name="volume_bensin" class="text-xs text-rose-500" />
                                    <span v-if="state.updateVehicle.error.message.errors?.volume_bensin" v-html="state.updateVehicle.error.message.errors.volume_bensin[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="effective-date" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Tanggal Berlaku</label>

                                    <div :class="errors['tanggal_berlaku'] || state.updateVehicle.error.message.errors?.tanggal_berlaku ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="tanggal_berlaku" :value="state.updateVehicle.data.detail.tanggal_berlaku" type="date" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="effective-date" />
                                    </div>

                                    <ErrorMessage name="tanggal_berlaku" class="text-xs text-rose-500" />
                                    <span v-if="state.updateVehicle.error.message.errors?.tanggal_berlaku" v-html="state.updateVehicle.error.message.errors.tanggal_berlaku[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="resetForm({
                                        values: {
                                            plat_nomer: state.updateVehicle.data.detail.plat_nomer,
                                            nama_merk: state.updateVehicle.data.detail.nama_merk,
                                            status: state.updateVehicle.data.detail.status,
                                            volume_bensin: state.updateVehicle.data.detail.volume_bensin,
                                            tanggal_berlaku: state.updateVehicle.data.detail.tanggal_berlaku
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

        <TransitionRoot appear :show="state.deleteVehicle.modal" as="template">
            <Dialog as="div" :open="state.deleteVehicle.modal" @close="state.deleteVehicle.modal = false">
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
                                    <h6 class="text-sm font-semibold">Hapus Kendaraan Kurir</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Hapus permanen data produk yang dipilih.</p>
                                </div>

                                <button @click="state.deleteVehicle.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <p class="text-sm">Apakah anda ingin menghapus data kendaraan ini ?</p>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="state.deleteVehicle.modal = false" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-slate-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Batal</h6>
                                    </button>

                                    <button @click="deleteVehicle" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-rose-500 focus:outline-none">
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

    import { object, string, number, date, mixed } from 'yup'

    import SelectInput from '~/components/form/SelectInput'
    import { Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            SelectInput,
            Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const day   = inject('day')

            const store = useStore()
            const state = reactive({
                vehicle: [],
                loading: true,

                pagination: {
                    begin: 0,
                    end: 10,
                    listVehicle: []
                },

                detailVehicle: {
                    data: null,
                    modal: false
                },

                addVehicle: {
                    modal: false,
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                },

                updateVehicle: {
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

                deleteVehicle: {
                    id: null,
                    modal: false
                }
            })

            const schema = object({
                plat_nomer: string().required().min(7),
                nama_merk: string().required().min(4),
                gambar: mixed()
                            .test('fileSize', 'Ukuran file terlalu besar', val => {
                                return val?.filter(v => v.size <= 2097152).length == val?.length
                            })
                            .test('fileType', 'Format file tidak didukung', val => {
                                return val?.filter(v => [
                                    'image/jpeg', 'image/png', 'image/jpg'
                                ].includes(v.type)).length == val?.length
                            }),
                status: string().nullable(),
                volume_bensin: number().nullable(),
                tanggal_berlaku: date().nullable()
            })

            const pageControl = (direction = null) => {
                if (direction === 'left') {
                    state.pagination.begin -= 10
                    state.pagination.end -= 10
                } else if (direction === 'right') {
                    state.pagination.begin += 10
                    state.pagination.end += 10
                }

                state.pagination.listVehicle = state.vehicle.slice(
                    state.pagination.begin, state.pagination.end
                )
            }

            const detailVehicle = (id) => {
                axios.get('/api/admin/vehicle/' + id).then(({ data }) => {
                    state.detailVehicle = {
                        data: data.results,
                        modal: true
                    }
                })
            }

            const editVehicle = (id) => {
                axios.get('/api/admin/vehicle/' + id).then(({ data }) => {
                    state.updateVehicle.modal = true
                    state.updateVehicle.data  = data.results
                })
            }

            const removeVehicle = (id) => {
                state.deleteVehicle = {
                    id, modal: true
                }
            }

            const addVehicle = (values) => {
                let formData = new FormData()

                Object.entries(values).forEach(([key, value]) => {
                    formData.append(key, key == 'gambar' ? ((value ?? [])[0] ?? '') : value)
                })

                axios.post('/api/admin/vehicle', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(() => {
                    state.loading          = true
                    state.addVehicle.modal = false

                    axios.get('/api/admin/vehicle').then(({ data }) => {
                        state.loading = false
                        state.vehicle = data.results

                        pageControl()
                    })
                }).catch(({ response }) => {
                    state.addVehicle.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const updateVehicle = (values) => {
                let formData = new FormData()

                formData.append('_method', 'PATCH')

                Object.entries(values).forEach(([key, value]) => {
                    formData.append(key, key == 'gambar' ? ((value ?? [])[0] ?? '') : value)
                })

                axios.post('/api/admin/vehicle/' + state.updateVehicle.data.detail.id, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(() => {
                    state.loading             = true
                    state.updateVehicle.modal = false

                    axios.get('/api/admin/vehicle').then(({ data }) => {
                        state.loading = false
                        state.vehicle = data.results

                        pageControl()
                    })
                }).catch(({ response }) => {
                    state.updateVehicle.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const deleteVehicle = () => {
                axios.delete('/api/admin/vehicle/' + state.deleteVehicle.id).then(() => {
                    state.deleteVehicle.modal = false

                    state.vehicle.splice(
                        state.vehicle.findIndex(v => v.id == state.deleteVehicle.id), 1
                    )

                    pageControl()
                })
            }

            onMounted(() => {
                if (store.getters['search/search'].length > 0) {
                    state.loading = false
                    state.vehicle = store.getters['search/search']

                    pageControl()

                    store.dispatch('search/saveDataSearch', [])
                } else {
                    axios.get('/api/admin/vehicle').then(({ data }) => {
                        state.loading = false
                        state.vehicle = data.results

                        pageControl()
                    })
                }
            })

            return {
                day,
                store, state,
                schema,
                pageControl, detailVehicle, editVehicle, removeVehicle,
                addVehicle, updateVehicle, deleteVehicle
            }
        }
    }
</script>
