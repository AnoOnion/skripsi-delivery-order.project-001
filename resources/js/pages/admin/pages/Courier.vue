<template>
    <div class="flex flex-col md:flex-row relative h-auto md:h-full">
        <div class="w-full md:w-[62.505%] h-[calc(100vh-185px)] md:h-[calc(100vh-64px)]">
            <div id="map" class="!absolute w-full h-[calc(100vh-185px)] md:h-[calc(100vh-64px)]"></div>

            <div class="flex flex-col items-center space-y-2.5 sticky md:absolute top-5 md:top-4 left-4 px-4 md:px-0 mb-5 w-full md:w-auto">
                <div class="flex flex-col space-y-1 w-full md:w-96 p-4 rounded-md shadow-md bg-white dark:bg-slate-800">
                    <label for="location" class="text-2xs text-slate-700 dark:text-slate-300">Lokasi Anda : </label>
                    <p class="truncate text-xs">{{ state.map.place }}</p>
                </div>

                <div v-if="store.getters['order/orderStatus']" class="absolute top-12 p-1.5 rounded-full bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                </div>

                <div v-if="store.getters['order/orderStatus']" class="flex flex-col space-y-1 w-full md:w-96 p-4 rounded-md shadow-md bg-white dark:bg-slate-800">
                    <label class="text-2xs text-slate-700 dark:text-slate-300">Lokasi Pembeli : </label>
                    <p class="truncate text-xs">{{ store.getters['order/order'].user.alamat_lengkap }}</p>
                </div>
            </div>
        </div>

        <div :class="store.getters['order/orderStatus'] ? 'md:space-y-2.5' : 'md:space-y-4'" class="block space-y-3 w-full md:w-[37.495%] h-auto md:h-[calc(100vh-152px)] p-0 md:p-4 z-10 bg-slate-100 dark:bg-slate-700 md:bg-transparent">
            <div class="block space-y-2 w-full p-4 rounded-none md:rounded-lg shadow-md bg-white dark:bg-slate-800">
                <div class="flex items-center space-x-3">
                    <img :src="store.getters['courier/taker'].vehicle?.gambar ?? baseurl +'/storage/images/vehicle/not-found.png'" class="h-10 aspect-square rounded-lg bg-slate-700/50" />

                    <div class="flex justify-between items-center w-full">
                        <div>
                            <h6 class="text-sm font-semibold">{{ (store.getters['courier/taker'].vehicle?.nama_merk ?? 'Belum Diketahui') }}</h6>
                            <p class="text-2xs text-slate-700 dark:text-slate-300">{{ store.getters['courier/taker'].user.nama_depan ? (store.getters['courier/taker'].user.nama_depan + ' ' + (store.getters['courier/taker'].user.nama_belakang ?? '') + ' &middot; ' + store.getters['courier/taker'].user.email) : 'Menunggu kurir mengambil kendaraan.' }}</p>
                        </div>

                        <div class="flex items-center space-x-1 p-1 rounded-md bg-slate-100 dark:bg-slate-900/50">
                            <div class="px-1.5">
                                <h6 class="text-xs font-semibold">{{ store.getters['courier/taker'].vehicle?.nama_merk ? 'Online' : 'Offline' }}</h6>
                            </div>

                            <button @click="state.courier.status.modal = true" class="p-1 rounded-md text-white bg-blue-500 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-x-4">
                    <div>
                        <label for="id-number" class="truncate text-2xs text-slate-700 dark:text-slate-300">ID Nomer</label>
                        <h6 id="id-number" class="truncate text-xs">{{ (store.getters['courier/taker'].vehicle?.kode_laporan ?? 'Belum Diketahui') }}</h6>
                    </div>

                    <div>
                        <label for="number-plate" class="truncate text-2xs text-slate-700 dark:text-slate-300">Plat Nomer</label>
                        <h6 id="number-plate" class="truncate text-xs">{{ (store.getters['courier/taker'].vehicle?.plat_nomer ?? 'Belum Diketahui') }}</h6>
                    </div>

                    <div>
                        <label for="gasoline-volume" class="truncate text-2xs text-slate-700 dark:text-slate-300">Volume Bensin</label>
                        <h6 id="gasoline-volume" class="truncate text-xs">{{ (store.getters['courier/taker'].vehicle?.volume_bensin ? (store.getters['courier/taker'].vehicle?.volume_bensin + ' Liter') : 'Belum Diketahui') }}</h6>
                    </div>

                    <div>
                        <label for="effective-date" class="truncate text-2xs text-slate-700 dark:text-slate-300">Tanggal Berlaku</label>
                        <h6 id="effective-date" class="truncate text-xs">{{ (store.getters['courier/taker'].vehicle?.tanggal_berlaku ? day(store.getters['courier/taker'].vehicle?.tanggal_berlaku).format('DD MMM YYYY') : 'Belum Diketahui') }}</h6>
                    </div>
                </div>
            </div>

            <div v-if="! store.getters['order/orderStatus']" class="block space-y-3 w-full p-4 rounded-none md:rounded-lg shadow-md bg-white dark:bg-slate-800">
                <div>
                    <h6 class="text-sm font-semibold">Pembeli Yang Memesan</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar pembeli yang harus diselesaikan.</p>
                </div>

                <div class="block space-y-2.5">
                    <div v-for="({ id, user, location }, index) in store.getters['buyer/user']" :key="index" class="flex justify-between items-center w-full p-3 rounded-md bg-slate-200 dark:bg-slate-900/50">
                        <div class="flex items-center space-x-3 w-8/12">
                            <div>
                                <img :src="user.avatar" referrerpolicy="no-referrer" class="w-14 aspect-square rounded-md">
                            </div>

                            <div class="block space-y-0.5 overflow-hidden">
                                <h6 class="truncate text-xs font-semibold">{{ user.nama_depan + ' ' + (user.nama_belakang ?? '') }}</h6>
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">{{ location.alamat_lengkap }}</p>
                            </div>
                        </div>

                        <div>
                            <button v-if="typeof store.getters['courier/taker'].vehicle?.kode_laporan != 'undefined'" @click="getProductCart(id, [ location.longitude, location.latitude ])" class="px-2.5 py-1 text-xs rounded-xl text-white bg-blue-500 focus:outline-none">Ambil</button>
                        </div>
                    </div>

                    <div v-if="store.getters['buyer/user'].length == 0" class="p-6 text-xs text-center">
                        Untuk saat ini belum ada pembeli, silahkan tunggu beberapa saat.
                    </div>
                </div>
            </div>

            <div v-if="store.getters['order/orderStatus']" class="hidden md:flex justify-center items-center w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
            </div>

            <div v-if="store.getters['order/orderStatus']" class="block space-y-3 md:space-y-4">
                <div class="block space-y-3 w-full p-4 rounded-none md:rounded-lg shadow-md bg-white dark:bg-slate-800">
                    <div class="flex items-center space-x-3">
                        <img :src="store.getters['order/order'].user.avatar" referrerpolicy="no-referrer" class="h-10 aspect-square rounded-lg bg-slate-700/50" />

                        <div class="flex justify-between items-center space-x-3 w-full">
                            <div>
                                <p class="text-2xs text-slate-700 dark:text-slate-300">{{ store.getters['order/order'].user.kode_pembayaran }} &middot; {{ store.getters['order/order'].user.no_telpon ?? 'No hp kosong' }}</p>
                                <h6 class="text-sm font-semibold">{{ store.getters['order/order'].user.nama_depan + ' ' + (store.getters['order/order'].user.nama_belakang ?? '') }}</h6>
                                <p class="text-2xs text-slate-700 dark:text-slate-300">Rp. {{ rupiah(store.getters['order/order'].user.saldo) }} Saldo &middot; {{ store.getters['order/order'].user.kupon }} Kupon</p>
                            </div>

                            <div v-if="store.getters['order/deliveryStatus'] == 'process'" class="flex items-center space-x-2.5">
                                <button @click="cancleOrder" class="px-2 py-1.5 text-xs font-semibold rounded-md text-white bg-rose-500 focus:outline-none">
                                    Batal
                                </button>

                                <button @click="deliveredOrder" class="px-2 py-1.5 text-xs font-semibold rounded-md text-white bg-blue-500 focus:outline-none">
                                    Sampai
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col rounded-none md:rounded-lg overflow-hidden shadow-md bg-white dark:bg-slate-800">
                    <div class="flex justify-between items-center pt-4 px-4">
                        <div>
                            <h6 class="text-sm font-semibold">Daftar Item Produk</h6>
                            <p class="text-2xs text-slate-700 dark:text-slate-300">Produk yang harus diantarkan ke pembeli.</p>
                        </div>

                        <button class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-col justify-between h-full">
                        <div class="flex flex-col items-center space-y-3 h-96 md:h-[calc(100vh-500px)] px-4 my-4 overflow-y-auto">
                            <div v-for="(product, index) in store.getters['order/order'].items" :key="index" class="flex items-center w-full rounded-md bg-slate-200 dark:bg-slate-900/50">
                                <div class="flex items-center space-x-3 w-8/12 px-4 py-3">
                                    <img :src="product.path" :alt="product.nama_item" class="w-14 aspect-square rounded-md object-cover">

                                    <div class="block space-y-0.5 overflow-hidden">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">{{ product.kode_item }}</p>
                                        <h6 class="truncate text-xs font-semibold">{{ product.nama_item }}</h6>
                                        <h6 class="text-xs font-semibold">Rp. {{ rupiah(product.harga) }}</h6>
                                    </div>
                                </div>

                                <div class="flex justify-end items-center space-x-4 w-4/12 pr-4">
                                    <div class="flex justify-between items-center w-[4.75rem] border-2 rounded-md bg-slate-100 dark:bg-slate-900 border-transparent">
                                        <input type="number" :value="product.jumlah" class="w-full px-1 py-1.5 text-xs text-center font-semibold text-slate-800 dark:text-slate-200 bg-transparent focus:outline-none" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center p-4 bg-slate-100 dark:bg-slate-900/50">
                            <div class="flex flex-col space-y-0.5">
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">Total Pembayaran</p>
                                <h6 class="truncate text-xs font-semibold">Rp. {{ rupiah(store.getters['order/order'].items.map(v => v.harga * v.jumlah).reduce((v, a) => v + a, 0)) }} <span class="text-slate-700 dark:text-slate-300">+ Fee Rp. {{ rupiah(store.getters['order/courier'].cost) }}</span></h6>
                            </div>

                            <div v-if="store.getters['order/deliveryStatus'] == 'delivered'" class="flex items-center space-x-3">
                                <button @click="state.transaction.fail.modal = true" class="flex items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-rose-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>

                                    <h6 class="truncate text-xs">Gagal</h6>
                                </button>

                                <button @click="fullPayment" class="flex items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>

                                    <h6 class="truncate text-xs">Lunas</h6>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <TransitionRoot appear :show="state.courier.modal" as="template">
            <Dialog as="div" @close="state.courier.modal = false">
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
                                    <h6 class="text-sm font-semibold">Konfirmasi Sebagai Kurir</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Silahkan pilih kendaraan yang tersedia saat ini.</p>
                                </div>

                                <button @click="state.courier.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="vehicle" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Pilih Kendaraan</label>

                                <div class="relative overscroll-contain">
                                    <Listbox v-model="state.courier.vehicle" v-slot="{ open }">
                                        <ListboxButton class="flex justify-between items-center w-full px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none" :class="false ? 'border-rose-400' : 'border-transparent'" id="vehicle">
                                            <h6 class="text-xs font-semibold capitalize">{{ state.courier.vehicle?.nama_merk ?? 'Pilih Sekarang' }}</h6>

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                            </svg>
                                        </ListboxButton>

                                        <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <div v-show="open" class="absolute top-10 w-full p-1 rounded-md z-10 bg-slate-200 dark:bg-slate-900">
                                                <ListboxOptions class="focus:outline-none" static>
                                                    <ListboxOption v-for="(vehicle, index) in state.vehicle" :key="index" :value="vehicle" :disabled="vehicle.status != 'ada'" v-slot="{ active, selected }" class="focus:outline-none">
                                                        <li class="flex justify-between items-center py-2 cursor-pointer select-none" :class="active ? 'text-slate-700 dark:text-slate-300' : 'text-slate-800 dark:text-slate-200'" >
                                                            <div class="flex items-center">
                                                                <div class="flex justify-center w-8">
                                                                    <svg v-if="selected" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                </div>

                                                                <div>
                                                                    <p class="text-2xs text-slate-700 dark:text-slate-300">{{ vehicle.plat_nomer }}</p>
                                                                    <h6 class="truncate text-xs font-semibold">{{ vehicle.nama_merk }}</h6>
                                                                </div>
                                                            </div>

                                                            <h6 v-if="vehicle.status == 'ada'" class="relative px-3 capitalize text-xs font-bold before:absolute before:top-1.5 before:-left-[-0.0625rem] before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-1.5 after:-left-[-0.0625rem] after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping text-black dark:text-white before:bg-black before:dark:bg-white">Ada</h6>

                                                            <h6 v-if="vehicle.status == 'pakai'" class="relative px-3 capitalize text-xs font-bold before:absolute before:top-1.5 before:-left-[-0.0625rem] before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-1.5 after:-left-[-0.0625rem] after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping text-sky-500 after:bg-sky-500 before:bg-sky-500">Dipakai</h6>

                                                            <h6 v-if="vehicle.status == 'masalah'" class="relative px-3 capitalize text-xs font-bold before:absolute before:top-1.5 before:-left-[-0.0625rem] before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-1.5 after:-left-[-0.0625rem] after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping text-rose-500 after:bg-rose-500 before:bg-rose-500">Bermasalah</h6>

                                                            <h6 v-if="vehicle.status == 'perbaikan'" class="relative px-3 capitalize text-xs font-bold before:absolute before:top-1.5 before:-left-[-0.0625rem] before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-1.5 after:-left-[-0.0625rem] after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping text-amber-500 after:bg-amber-500 before:bg-amber-500">Perbaikan</h6>
                                                        </li>
                                                    </ListboxOption>
                                                </ListboxOptions>
                                            </div>
                                        </transition>
                                    </Listbox>
                                </div>
                            </div>

                            <div class="block space-y-2 text-xs text-slate-700 dark:text-slate-300">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                    <p>Pastikan barang sudah sesuai dengan stok tersedia.</p>
                                </div>

                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                    <p>Pastikan kendaraan yang digunakan sudah dicek perlengkapannya.</p>
                                </div>

                                <div class="flex">
                                    <div class="h-4 w-4 mx-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <p>Pastikan sudah membawa surat izin mengemudi dan alat keselamatan pengendara.</p>
                                </div>
                            </div>

                            <button @click="takeCourier" class="flex justify-center items-center space-x-1.5 w-full px-3 py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                
                                <h6 class="text-xs font-semibold">Ambil Orderan Sekarang</h6>
                            </button>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="state.courier.status.modal" as="template">
            <Dialog as="div" @close="state.courier.status.modal = false">
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
                        <div class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-slate-100 dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Ubah Status Anda Sekarang</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Daftar detail transaksi yang sedang dilakukan.</p>
                                </div>

                                <button @click="state.courier.status.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <Form @submit="updateCourierStatus" :validation-schema="schemaUpdateCourier" v-slot="{ errors }" class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="courier-status" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Status Kurir</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="status_kendaraan" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="courier-status">
                                            <div :class="errors['status_kendaraan'] || state.courier.status.error.message.errors?.status_kendaraan ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { key: 'ada', label: 'selesai (offline)' },
                                                        { key: 'masalah', label: 'masalah' },
                                                        { key: 'perbaikan', label: 'perbaikan' }
                                                    ]"
                                                    v-bind="field"
                                                    key-prop="key"
                                                    label-prop="label"
                                                />
                                            </div>
                                        </Field>
                                    </div>

                                    <ErrorMessage name="status_kendaraan" class="text-xs text-rose-500" />
                                    <span v-if="state.courier.status.error.message.errors?.status_kendaraan" v-html="state.courier.status.error.message.errors.status_kendaraan[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="noted" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Catatan</label>

                                    <div :class="errors['catatan'] || state.courier.status.error.message.errors?.catatan ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field as="textarea" name="catatan" class="w-full h-20 text-xs font-semibold bg-transparent focus:outline-none" id="noted" />
                                    </div>

                                    <ErrorMessage name="catatan" class="text-xs text-rose-500" />
                                    <span v-if="state.courier.status.error.message.errors?.catatan" v-html="state.courier.status.error.message.errors.catatan[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12">
                                    <button class="flex justify-center items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>

                                        <h6 class="truncate text-xs">Update Status</h6>
                                    </button>
                                </div>
                            </Form>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="state.order.modal" as="template">
            <Dialog as="div" @close="state.order.modal = false">
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
                        <div class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-slate-100 dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Konfirmasi Pesanan Pelanggan</h6>
                                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar produk yang harus diantar.</p>
                                </div>

                                <button @click="state.order.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div v-if="state.order.item.data.length > 0" class="block space-y-3">
                                <div v-for="item in state.order.item.data" :key="item" class="flex items-center w-full rounded-md bg-slate-200 dark:bg-slate-900/50">
                                    <div class="flex items-center space-x-3 w-8/12 px-4 py-3">
                                        <img :src="state.order.item.data.find(v => v.id == item.id)?.path" :alt="item.nama_item" class="w-14 aspect-square rounded-md object-cover">

                                        <div class="block space-y-0.5 overflow-hidden">
                                            <p class="text-2xs text-slate-700 dark:text-slate-300">{{ item.kode_item }}</p>
                                            <h6 class="truncate text-xs font-semibold">{{ item.nama_item }}</h6>
                                            <h6 class="text-xs font-semibold">Rp. {{ rupiah(item.harga) }}</h6>
                                        </div>
                                    </div>

                                    <div class="flex justify-end items-center space-x-4 w-4/12 pr-4">
                                        <div class="w-[4.75rem] px-1 py-1.5 rounded-md text-xs text-center font-semibold bg-slate-100 dark:bg-slate-900">
                                            {{ item.jumlah }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button v-if="typeof store.getters['courier/taker'].vehicle?.kode_laporan != 'undefined'" @click="takeOrder(state.order.user.id, state.order.user.location)" :disabled="state.order.loading" class="flex justify-center items-center space-x-1.5 w-full px-3 py-2 rounded-lg text-white bg-blue-500 disabled:bg-blue-500/50 focus:outline-none">
                                <svg v-if="state.order.loading" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>

                                <svg v-if="! state.order.loading" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                                <h6 class="text-xs font-semibold">{{ state.order.loading ? 'Sedang Mengambil Data' : 'Ambil Pesanan' }}</h6>
                            </button>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="state.transaction.fail.modal" as="template">
            <Dialog as="div" @close="state.transaction.fail.modal = false">
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
                        <div class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-slate-100 dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Konfirmasi Pembayaran Pesanan</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Daftar detail transaksi yang sedang dilakukan.</p>
                                </div>

                                <button @click="state.transaction.fail.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <p class="text-sm">Apakah anda ingin membatalkan transaksi ini ?</p>

                            <button @click="paymentConfirmed(null, 'gagal')" class="flex justify-center items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-rose-500 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>

                                <h6 class="truncate text-xs">Pembayaran Gagal</h6>
                            </button>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <TransitionRoot appear :show="state.transaction.success.modal" as="template">
            <Dialog as="div" @close="state.transaction.success.modal = false">
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
                        <div class="inline-block space-y-3 w-full max-w-md py-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-slate-100 dark:bg-slate-800">
                            <div class="flex justify-between items-center px-4">
                                <div>
                                    <h6 class="text-sm font-semibold">Konfirmasi Pembayaran Pesanan</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Daftar detail transaksi yang sedang dilakukan.</p>
                                </div>

                                <button @click="state.transaction.success.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="block space-y-4">
                                <div class="block space-y-3">
                                    <Swiper
                                        :modules="modulesSwiper"
                                        :spaceBetween="12"
                                        :slidesPerView="3"
                                        :autoplay="{
                                            delay: 5000,
                                            disableOnInteraction: false
                                        }"
                                        :pagination="{ clickable: true }"
                                        class="w-full !pl-6 !pr-6"
                                    >
                                        <SwiperSlide v-for="(product, index) in store.getters['order/order'].items" :key="index">
                                            <div class="block space-y-3 p-4 rounded-md group bg-white dark:bg-slate-900/50">
                                                <div class="flex flex-col items-center space-y-2 overflow-hidden bg-opacity-50 dark:bg-opacity-50">
                                                    <img :src="product.path" class="w-14 aspect-square object-cover transition-all transform duration-300 ease-in-out" :alt="product.nama_item" loading="lazy">
                                                </div>

                                                <div class="block space-y-1.5">
                                                    <h6 class="text-2xs font-semibold text-slate-700 dark:text-slate-300">{{ product.nama_item }}</h6>

                                                    <div class="flex flex-col justify-center items-center space-y-1">
                                                        <div class="w-[4.75rem] px-1 py-1.5 rounded-md text-xs text-center font-semibold bg-slate-100 dark:bg-slate-900">
                                                            {{ product.jumlah }} <span class="text-2xs text-slate-700 dark:text-slate-300">Barang</span>
                                                        </div>

                                                        <h6 class="text-xs font-semibold">Rp. {{ rupiah(product.harga) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </SwiperSlide>
                                    </Swiper>
                                </div>

                                <div class="block px-4">
                                    <Form @submit="value => paymentConfirmed(value, 'lunas')" :validation-schema="state.transaction.success.data.metode_bayar == 'tunai' ?cashPaymentScheme : balancePaymentScheme" v-slot="{ errors }" class="grid grid-cols-12 gap-x-3 gap-y-4">
                                        <div class="col-span-6 flex flex-col space-y-2">
                                            <label for="payment-method" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Metode Pembayaran</label>

                                            <div class="relative overscroll-contain">
                                                <Field name="metode_bayar" value="tunai" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="payment-method">
                                                    <div :class="errors['metode_bayar'] || state.transaction.success.error.message.errors?.metode_bayar ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                        <SelectInput
                                                            :options="[
                                                                { key: 'tunai', label: 'tunai' },
                                                                { key: 'saldo', label: 'saldo (Rp. ' + rupiah(store.getters['order/order'].user?.saldo ?? 0) + ')', disabled: store.getters['order/order'].user?.saldo < (parseInt(store.getters['order/order'].items.map(v => v.harga * v.jumlah).reduce((v, a) => v + a, 0)) + parseInt(store.getters['order/courier'].cost)) }
                                                            ]"
                                                            @update:modelValue="val => state.transaction.success.data.metode_bayar = val"
                                                            v-bind="field"
                                                            :value="field.value"
                                                            key-prop="key"
                                                            label-prop="label"
                                                        />
                                                    </div>
                                                </Field>
                                            </div>

                                            <ErrorMessage name="metode_bayar" class="text-xs text-rose-500" />
                                            <span v-if="state.transaction.success.error.message.errors?.metode_bayar" v-html="state.transaction.success.error.message.errors.metode_bayar[0]" role="alert" class="text-xs text-rose-500"></span>
                                        </div>

                                        <div class="col-span-6 flex flex-col space-y-2">
                                            <label for="use-coupon" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Pakai Kupon</label>

                                            <div class="relative overscroll-contain">
                                                <Field name="pakai_kupon" :value="store.getters['order/order'].user?.kupon >= 10 ? 'ya' : 'tidak'" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="use-coupon">
                                                    <div :class="errors['pakai_kupon'] || state.transaction.success.error.message.errors?.pakai_kupon ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                        <SelectInput
                                                            :options="[
                                                                { key: 'ya', label: ('pakai (' + (parseInt((store.getters['order/order'].user?.kupon ?? 0) / 10) * 10) + ' kupon)') },
                                                                { key: 'tidak', label: 'tidak' }
                                                            ]"
                                                            @update:modelValue="val => state.transaction.success.data.pakai_kupon = val"
                                                            :value="field.value"
                                                            :disabled="store.getters['order/order'].user?.kupon < 10"
                                                            v-bind="field"
                                                            key-prop="key"
                                                            label-prop="label"
                                                        />
                                                    </div>
                                                </Field>
                                            </div>

                                            <ErrorMessage name="pakai_kupon" class="text-xs text-rose-500" />
                                            <span v-if="state.transaction.success.error.message.errors?.pakai_kupon" v-html="state.transaction.success.error.message.errors.pakai_kupon[0]" role="alert" class="text-xs text-rose-500"></span>
                                        </div>

                                        <div class="col-span-5 flex flex-col space-y-2">
                                            <label for="amount" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Total</label>

                                            <div class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                                <input :value="state.transaction.success.data.jumlah" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="amount" readonly />
                                            </div>
                                        </div>

                                        <div class="col-span-2 flex justify-center items-center pt-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>

                                        <div class="col-span-5 flex flex-col space-y-2">
                                            <label for="fee-amount" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Fee</label>

                                            <div class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                                <input :value="store.getters['order/courier'].cost" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="fee-amount" readonly />
                                            </div>
                                        </div>

                                        <!-- <div class="col-span-12 flex justify-center items-center pt-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </div> -->

                                        <div class="col-span-12 flex flex-col space-y-2">
                                            <label for="total-payment" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Total Pembayaran</label>

                                            <div class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                                <input :value="state.transaction.success.data.jumlah_total" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="total-payment" readonly />
                                            </div>
                                        </div>

                                        <div v-if="state.transaction.success.data.metode_bayar == 'tunai'" class="col-span-6 flex flex-col space-y-2">
                                            <label for="cash-amount" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Tunai</label>

                                            <div :class="errors['jumlah_tunai'] || state.transaction.success.error.message.errors?.jumlah_tunai ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                                <Field name="jumlah_tunai" v-slot="{ field, handleChange }">
                                                    <input :value="field.value" @change="event => {
                                                        handleChange(event)
                                                        inputCashAmount(event)
                                                    }" type="number" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="cash-amount">
                                                </Field>
                                            </div>

                                            <ErrorMessage name="jumlah_tunai" class="text-xs text-rose-500" />
                                            <span v-if="state.transaction.success.error.message.errors?.jumlah_tunai" v-html="state.transaction.success.error.message.errors.jumlah_tunai[0]" role="alert" class="text-xs text-rose-500"></span>
                                        </div>

                                        <div v-if="state.transaction.success.data.metode_bayar == 'tunai'" class="col-span-6 flex flex-col space-y-2">
                                            <label for="change-amount" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Kembalian</label>

                                            <div class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                                <input :value="state.transaction.success.data.jumlah_kembalian" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="change-amount" readonly />
                                            </div>
                                        </div>

                                        <div class="col-span-12">
                                            <button class="flex justify-center items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>

                                                <h6 class="truncate text-xs">Pembayaran Lunas</h6>
                                            </button>
                                        </div>
                                    </Form>
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
    import 'swiper/css'
    import 'mapbox-gl/dist/mapbox-gl.css'

    import { useStore } from 'vuex'
    import { useRouter } from 'vue-router'
    import { inject, onMounted, reactive, watch } from '@vue/runtime-core'

    import axios from 'axios'
    import Pusher from 'pusher-js'

    import { Device } from '@capacitor/device'
    import { Haptics } from '@capacitor/haptics'
    import { StatusBar } from '@capacitor/status-bar'
    import { Geolocation } from '@capacitor/geolocation'
    import { LocalNotifications } from '@capacitor/local-notifications'

    import * as turf from '@turf/turf'
    import mapboxgl from 'mapbox-gl'
    import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder'
    import MapboxDirections from '@mapbox/mapbox-gl-directions/dist/mapbox-gl-directions'

    import { Autoplay } from 'swiper'
    import { Swiper, SwiperSlide } from 'swiper/vue'

    import { object, string, number } from 'yup'

    import SelectInput from '~/components/form/SelectInput'
    import { Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            SelectInput,
            Swiper, SwiperSlide,
            Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        beforeRouteLeave(to, from, next) {
            let answer = true

            if (typeof this.$store.getters['courier/taker'].vehicle?.kode_laporan != 'undefined') {
                answer = window.confirm(
                    'you might lose the data, please save the data before you leave.'
                )
            }

            answer ? next() : next({ name: 'admin.dashboard.courier' })
        },

        setup() {
            const day       = inject('day')
            const mobile    = inject('mobile')
            const pusher    = inject('pusher')
            const rupiah    = inject('rupiah')
            const baseurl   = inject('baseurl')

            const router    = useRouter()

            const store     = useStore()
            const state     = reactive({
                vehicle: null,

                map: {
                    place: 'Lokasi Belum Diketahui Untuk Sekarang.'
                },

                courier: {
                    modal: false,
                    vehicle: {
                        kode_laporan: null
                    },
                    status: {
                        modal: false,
                        error: {
                            status: false,
                            message: {
                                errors: null,
                                message: null
                            }
                        }
                    }
                },

                order: {
                    modal: false,
                    loading: false,

                    user: {
                        id: null,
                        location: []
                    },

                    item: {
                        modal: false,
                        data: []
                    }
                },

                transaction: {
                    fail: {
                        modal: false
                    },
                    success: {
                        modal: false,
                        data: {
                            metode_bayar: 'tunai',
                            pakai_kupon: 'tidak',
                            jumlah: 0,
                            jumlah_fee: 0,
                            jumlah_total: 0,
                            jumlah_tunai: 0,
                            jumlah_kembalian: 0
                        },
                        error: {
                            status: false,
                            message: {
                                errors: null,
                                message: null
                            }
                        }
                    }
                }
            })
            

            let map, geocoder, direction
            let courier = [], buyers = []

            let bounds
            let boundsPadding = {
                top: 100,
                bottom: 100,
                left: mobile ? 100 : 200,
                right: mobile ? 100 : 300
            }

            const schemaUpdateCourier = object({
                status_kendaraan: string().required(),
                catatan: string().nullable()
            })

            const cashPaymentScheme = object({
                metode_bayar: string().required().default('tunai'),
                pakai_kupon: string().default('tidak'),
                jumlah_tunai: number().required()
            })

            const balancePaymentScheme = object({
                metode_bayar: string().required().default('tunai'),
                pakai_kupon: string().default('tidak'),
                jumlah_tunai: number().nullable()
            })

            watch(() => state.transaction.success.data.pakai_kupon, () => {
                state.transaction.success.data.jumlah = (
                    store.getters['order/order'].items.map(v => {
                        if (v.kupon == 'ya' && state.transaction.success.data.pakai_kupon == 'ya') {
                            return v.harga * (v.jumlah - parseInt(store.getters['order/order'].user.kupon / 10))
                        }

                        return v.harga * v.jumlah
                    }).reduce((v, a) => v + a, 0)
                )

                state.transaction.success.data.jumlah_total = (
                    parseInt(state.transaction.success.data.jumlah) +
                    parseInt(store.getters['order/courier'].cost)
                )

                state.transaction.success.data.jumlah_kembalian = (
                    parseInt(state.transaction.success.data.jumlah_tunai) -
                    parseInt(state.transaction.success.data.jumlah_total)
                )
            })

            const getProductCart = (idUser, position) => {
                if (! store.getters['order/orderStatus']) {
                    axios.get('/api/admin/order/id/' + idUser).then(({ data }) => {
                        state.order.item.data = data.results

                        state.order.modal = true,
                        state.order.user  = {
                            id: idUser,
                            location: position
                        }
                    })
                }
            }

            const markerBuyer = (user, position) => {
                let marker = new mapboxgl.Marker({ color: '#3b82f6' })
                                         .setLngLat(position)
                                         .addTo(map)

                marker._element.id = user.id

                if (buyers.length == 0) {
                    setTimeout(() => map.flyTo({
                        zoom: 16,
                        center: position
                    }), 1000)

                    if (! mobile) map.easeTo({
                        padding: { right: 300 },
                        duration: 1000
                    })
                }

                marker.getElement().addEventListener('click', (e) => {
                    getProductCart(e.path[4].id, position)

                    map.flyTo({
                        center: position
                    })

                    if (! mobile) map.easeTo({
                        padding: { right: 300 },
                        duration: 1000
                    })
                })

                return marker
            }

            const markerCourier = (position) => {
                let marker = new mapboxgl.Marker({ color: '#f43f5e' })
                                         .setLngLat(position)
                                         .addTo(map)

                if (courier.length == 0) {
                    setTimeout(() => map.flyTo({
                        zoom: 16,
                        center: position
                    }), 1000)

                    if (! mobile) map.easeTo({
                        padding: { right: 300 },
                        duration: 1000
                    })
                }

                marker.getElement().addEventListener('click', () => {
                    map.flyTo({
                        center: position
                    })

                    if (! mobile) map.easeTo({
                        padding: { right: 300 },
                        duration: 1000
                    })
                })

                return marker
            }

            const takeCourier = () => {
                if (typeof (
                    store.getters['courier/taker'].vehicle?.plat_nomer ||
                    state.courier.vehicle?.plat_nomer) == 'undefined'
                ) return;

                axios.post('/api/admin/courier', {
                    id_kendaraan: store.getters['courier/taker'].vehicle?.id ?? state.courier.vehicle.id
                }).then(({ data }) => {
                    let dataOrder  = data.results.order

                    state.courier.modal = false
                    state.courier.vehicle.kode_laporan = data.results.vehicle.kode_laporan

                    if (dataOrder != null) {
                        let getIndexBuyer = buyers.findIndex(v => v.id == dataOrder.user.id_user)
                        let buyerPosition = [ dataOrder.user.longitude, dataOrder.user.latitude ]

                        buyers[getIndexBuyer]?.marker.remove()

                        let buyerMarker = markerBuyer({
                            ...dataOrder.user, id: dataOrder.user.id_user
                        }, buyerPosition)

                        let dataBuyer = {
                            id: dataOrder.user.id_user,
                            user: dataOrder.user,
                            location: {
                                longitude: dataOrder.user.longitude,
                                latitude: dataOrder.user.latitude,
                                alamat_lengkap: dataOrder.user.alamat_lengkap
                            },
                            marker: buyerMarker
                        }

                        getIndexBuyer > -1 ? (buyers[getIndexBuyer] = dataBuyer) : buyers.push(dataBuyer)

                        store.dispatch('buyer/saveDataBuyer', {
                            user: buyers
                        })

                        store.dispatch('order/eventOrder', {
                            orderStatus: true,
                            deliveryStatus: dataOrder.user.status_kurir
                        })

                        store.dispatch('order/saveOrder', {
                            user: dataOrder.user,
                            items: dataOrder.items
                        })

                        store.dispatch('order/saveCourierActive', {
                            id: null,
                            cost: dataOrder.user.jumlah_fee
                        })
                    }

                    Geolocation.watchPosition({
                        timeout: 15000,
                        maximumAge: 15000,
                        enableHighAccuracy: true
                    }, (position) => {
                        if (position == null) return;

                        let getIndexCourier = courier.findIndex(v => v.id == store.getters['courier/taker'].user.id)
                        let courierPosition = [ position.coords.longitude, position.coords.latitude ]

                        courier[getIndexCourier]?.marker.remove()

                        let courierMarker = markerCourier(courierPosition)

                        if (buyers.length == 0) {
                            setTimeout(() => map.flyTo({
                                zoom: 16,
                                center: courierPosition
                            }), 1000)
                        }

                        courierMarker.getElement().addEventListener('click', () => {
                            map.flyTo({
                                zoom: 16,
                                center: courierPosition
                            })
                        })

                        let dataCourier = {
                            id: store.getters['courier/taker'].user.id,
                            user: store.getters['courier/taker'].user,
                            marker: courierMarker
                        }

                        getIndexCourier > -1 ? (courier[getIndexCourier] = dataCourier) : courier.push(dataCourier)

                        if (store.getters['order/orderStatus']) {
                            let buyerPosition = [
                                store.getters['order/order'].user.longitude,
                                store.getters['order/order'].user.latitude
                            ]

                            bounds = new mapboxgl.LngLatBounds()

                            direction.setOrigin(courierPosition)
                            direction.setDestination(buyerPosition)

                            bounds.extend(buyerPosition)
                            bounds.extend(courierPosition)

                            map.fitBounds(bounds, {
                                padding: boundsPadding
                            })
                        }

                        geocoder.query(position.coords.latitude + "," + position.coords.longitude)
                        geocoder.on('result', (e) => state.map.place = e.result.place_name)

                        if (store.getters['courier/taker'].vehicle != null || state.courier.vehicle != null) {
                            axios.post('/api/admin/tracking/update', {
                                vehicle: {
                                    ...(store.getters['courier/taker'].vehicle ?? state.courier.vehicle),
                                    kode_laporan: store.getters['courier/taker'].vehicle?.kode_laporan ?? state.courier.vehicle.kode_laporan
                                },
                                location: {
                                    latitude: position.coords.latitude,
                                    longitude: position.coords.longitude
                                }
                            }).then(({ data }) => {
                                store.dispatch('courier/saveDataTaker', {
                                    user: data.user,
                                    vehicle: data.vehicle,
                                    location: data.location,
                                    distance: null
                                })
                            })
                        }
                    })
                })
            }

            const updateCourierStatus = (values) => {
                axios
                    .patch('/api/admin/courier/' + store.getters['courier/taker'].vehicle?.id, values)
                    .then(({ data }) => {
                        state.courier.status.modal = false
                        state.courier.vehicle      = null

                        store.dispatch('courier/saveDataTaker', {
                            user: {
                                id: store.getters['courier/taker'].user?.id,
                                nama_depan: null,
                                nama_belakang: '',
                                avatar: 'https://www.gravatar.com/avatar/1667f76cd188f63e4c39792bb4357838?d=mm&s=40'
                            },
                            vehicle: null,
                            location: null,
                            distance: null
                        })

                        axios.post('/api/admin/tracking/update', {
                            vehicle: null,
                            location: null
                        })

                        axios.get('/api/admin/vehicle').then(({ data }) => {
                            state.vehicle = data.results
                            state.courier.modal = true
                        })
                    }).catch(({ response }) => {
                        state.courier.status.error = {
                            status: true,
                            message: response.data
                        }
                    })
            }

            const takeOrder = (idUser, location) => {
                state.order.loading = true

                let courierPosition = [
                    store.getters['courier/taker'].location.longitude,
                    store.getters['courier/taker'].location.latitude
                ]

                let costFormula = Math.ceil(
                    parseInt(
                        parseFloat(turf.distance(courierPosition, location, { units: 'kilometers' })) * 250
                    )
                )

                let courierCost = costFormula <= 1000 ? 1000 : costFormula

                axios.post('/api/admin/order/status', {
                    id: idUser ?? store.getters['order/order'].user.id,
                    courier: store.getters['courier/taker'].user.id,
                    status_order: 'aktif',
                    status_kurir: 'process',
                    jumlah_fee: courierCost
                }).then(async ({ data }) => {
                    state.order.modal   = false
                    state.order.loading = false

                    bounds = new mapboxgl.LngLatBounds()

                    direction.setOrigin(courierPosition)
                    direction.setDestination(location)

                    bounds.extend(location)
                    bounds.extend(courierPosition)

                    map.fitBounds(bounds, {
                        padding: boundsPadding
                    })

                    if (store.getters['order/order'].items.length == 0) {
                        try {
                            let itemsOrder = await axios.get('/api/admin/order/id/' + idUser)

                            state.order.item.data = itemsOrder.data.results
                        } catch (error) {}
                    }

                    store.dispatch('order/eventOrder', {
                        orderStatus: true,
                        deliveryStatus: 'process'
                    })

                    store.dispatch('order/saveOrder', {
                        user: data.results,
                        items: state.order.item.data
                    })

                    store.dispatch('order/saveCourierActive', {
                        id: null,
                        cost: data.results.jumlah_fee
                    })
                })
            }

            const cancleOrder = () => {
                axios.post('/api/admin/order/status', {
                    id: store.getters['order/order'].user.id,
                    status_order: 'batal',
                    status_kurir: 'canceled',
                    jumlah_fee: store.getters['order/courier'].cost
                }).then(() => {
                    let getIndexBuyer = buyers.findIndex(v => v.id == store.getters['order/order'].user.id)

                    direction.removeRoutes()

                    buyers[getIndexBuyer].marker?.remove()
                    buyers.splice(getIndexBuyer, 1)

                    store.dispatch('order/eventOrder', {
                        orderStatus: false,
                        deliveryStatus: 'canceled'
                    })

                    store.dispatch('order/saveOrder', {
                        user: null,
                        items: []
                    })

                    store.dispatch('buyer/saveDataBuyer', {
                        user: buyers
                    })
                })
            }

            const deliveredOrder = () => {
                axios.post('/api/admin/order/status', {
                    id: store.getters['order/order'].user.id,
                    status_order: 'aktif',
                    status_kurir: 'delivered',
                    jumlah_fee: store.getters['order/courier'].cost
                }).then(() => {
                    store.dispatch('order/eventOrder', {
                        orderStatus: true,
                        deliveryStatus: 'delivered'
                    })
                })
            }

            const inputCashAmount = event => {
                state.transaction.success.data.jumlah_tunai     = event.target.value
                state.transaction.success.data.jumlah_kembalian = parseInt(event.target.value) - parseInt(state.transaction.success.data.jumlah_total)
            }

            const fullPayment = () => {
                state.transaction.success.modal = true

                state.transaction.success.data.pakai_kupon = (
                    store.getters['order/order'].user.kupon >= 10 ? 'ya' : 'tidak'
                )

                state.transaction.success.data.jumlah = (
                    store.getters['order/order'].items.map(v => {
                        if (v.kupon == 'ya' && state.transaction.success.data.pakai_kupon == 'ya') {
                            return v.harga * (v.jumlah - parseInt(store.getters['order/order'].user.kupon / 10))
                        }

                        return v.harga * v.jumlah
                    }).reduce((v, a) => v + a, 0)
                )

                state.transaction.success.data.jumlah_total = (
                    parseInt(state.transaction.success.data.jumlah) +
                    parseInt(store.getters['order/courier'].cost)
                )

                state.transaction.success.data.jumlah_kembalian = (
                    parseInt(state.transaction.success.data.jumlah_tunai) -
                    parseInt(state.transaction.success.data.jumlah_total)
                )
            }

            const paymentConfirmed = (values, status) => {
                let payload = status == 'lunas' ? values : {}

                axios.post('/api/admin/transaction/agreement', {
                    id: store.getters['order/order'].user.id,
                    status_order: status == 'lunas' ? 'berhasil' : 'batal',
                    status_bayar: status,
                    ...payload
                }).then(() => {
                    let getIndexBuyer = buyers.findIndex(v => v.id == store.getters['order/order'].user.id)

                    if (status == 'lunas') {
                        state.transaction.success.modal = false
                    } else {
                        state.transaction.fail.modal = false
                    }

                    direction.removeRoutes()

                    buyers[getIndexBuyer].marker?.remove()
                    buyers.splice(getIndexBuyer, 1)

                    store.dispatch('order/eventOrder', {
                        orderStatus: false,
                        deliveryStatus: ''
                    })

                    store.dispatch('order/saveOrder', {
                        user: null,
                        items: []
                    })

                    store.dispatch('buyer/saveDataBuyer', {
                        user: buyers
                    })
                })
            }

            onMounted(async () => {
                let device  = (await Device.getInfo()).platform

                let channel = new Pusher('29fd29eb69f3c3e55dd1', {
                    ...pusher, auth: {
                        headers: {
                            Authorization: 'Bearer ' + store.getters['auth/token']
                        }
                    }
                })

                mapboxgl.accessToken = 'pk.eyJ1IjoidGkxOGh1c25pMDAxNiIsImEiOiJja3lqamJ3OGowOXpvMm9vMHJkaHdwZ3BrIn0.114PDt0ybnue0WY9HTW8Xw'

                map = new mapboxgl.Map({
                    container: 'map',
                    zoom: 14,
                    center: [109.6236733, -7.0299928],
                    maxBounds: [
                        [109.474847, -7.245632],
                        [109.794124, -6.837189]
                    ],
                    style: 'mapbox://styles/ti18husni0016/ckyjmin7o3r1x14pai0swit5o',
                    cooperativeGestures: mobile
                })

                geocoder = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    mapboxgl: mapboxgl,
                    limit: 1,
                    language: 'id',
                    countries: 'id',
                    marker: false,
                    reverseGeocode: true,
                    types: 'region,district,postcode,place,locality,neighborhood,address,poi'
                })

                direction = new MapboxDirections({
                    accessToken: mapboxgl.accessToken,
                    unit: 'metric',
                    profile: 'mapbox/driving-traffic',
                    alternatives: true,
                    flyTo: false,
                    interactive: false,
                    controls: {
                        inputs: false,
                        instructions: false
                    }
                })

                geocoder.onAdd(map)
                map.addControl(direction)

                if ((await StatusBar.getInfo()).color == '#1E293B') {
                    map.setStyle('mapbox://styles/ti18husni0016/ckyjmin7o3r1x14pai0swit5o')
                } else {
                    map.setStyle('mapbox://styles/mapbox/light-v10')
                }

                if (device == 'android') {
                    await LocalNotifications.requestPermissions()

                    await LocalNotifications.registerActionTypes({
                        types: [
                            {
                                id: 'actionNotification',
                                actions: [
                                    {
                                        id: 'dismiss',
                                        title: 'Hapus',
                                        destructive: true
                                    },
                                    {
                                        id: 'open',
                                        title: 'Buka'
                                    }
                                ]
                            }
                        ]
                    })
                } else {
                    alert('Fitur hanya dapat dibuka lewat aplikasi android !')
                    router.push({ name: 'admin.dashboard.index' })
                }

                if (store.getters['courier/taker'].vehicle?.kode_laporan == undefined) {
                    axios.get('/api/admin/courier').then(({ data }) => {
                        if (data.results.vehicle.status == 'pakai') {
                            store.dispatch('courier/saveDataTaker', {
                                user: data.results.user,
                                vehicle: data.results.vehicle,
                                location: null,
                                distance: null
                            })

                            takeCourier()
                        } else {
                            axios.get('/api/admin/vehicle').then(({ data }) => {
                                state.vehicle = data.results
                                state.courier.modal = true
                            })
                        }
                    }).catch(() => {
                        axios.get('/api/admin/vehicle').then(({ data }) => {
                            state.vehicle = data.results
                            state.courier.modal = true
                        })
                    })
                } else {
                    markerCourier([
                        store.getters['courier/taker'].location.longitude,
                        store.getters['courier/taker'].location.latitude
                    ])

                    takeCourier()
                }

                store.getters['buyer/user'].forEach((value) => {
                    markerBuyer(value.user, [
                        value.location.longitude,
                        value.location.latitude
                    ])
                })

                channel.subscribe('courier').bind('App\\Events\\CourierLocation', ({ user, vehicle, location }) => {
                    if (store.getters['courier/taker'].user.id != user.id) {
                        let getIndexCourier = buyers.findIndex(v => v.id == user.id)
                        let courierPosition = [ location.longitude, location.latitude ]

                        courier[getIndexCourier]?.marker.remove()

                        let courierMarker = markerCourier(courierPosition)

                        let dataCourier = {
                            id: store.getters['courier/taker'].user.id,
                            user: store.getters['courier/taker'].user,
                            marker: courierMarker
                        }

                        getIndexCourier > -1 ? (courier[getIndexCourier] = dataCourier) : courier.push(dataCourier)
                    }
                })

                channel.subscribe('buyer').bind('App\\Events\\BuyerLocation', ({ user, status, courierId, location }) => {
                    let getIndexBuyer = buyers.findIndex(v => v.id == user.id)

                    if (
                        status && (
                            courierId == null || store.getters['courier/taker'].user.id == courierId
                        )
                    ) {
                        buyers[getIndexBuyer]?.marker.remove()

                        let buyerMarker = markerBuyer(user, [
                            location.longitude,
                            location.latitude
                        ])

                        let dataBuyer = {
                            id: user.id, user, location, marker: buyerMarker
                        }

                        if (getIndexBuyer > -1) {
                            buyers[getIndexBuyer] = dataBuyer
                        } else {
                            buyers.push(dataBuyer)

                            if (device == 'android') {
                                Haptics.vibrate({ duration: 150 })

                                LocalNotifications.schedule({
                                    notifications: [
                                        {
                                            id: 1,
                                            title: 'Pesanan Baru',
                                            body: 'Ada pesanan baru, segera antarkan pesanan sekarang',
                                            actionTypeId: 'actionNotification'
                                        }
                                    ]
                                })
                            }
                        }
                    } else {
                        buyers[getIndexBuyer].marker?.remove()
                        buyers.splice(getIndexBuyer, 1)
                    }

                    store.dispatch('buyer/saveDataBuyer', {
                        user: buyers
                    })
                })
            })

            return {
                day, rupiah, baseurl,
                store, state,
                modulesSwiper: [ Autoplay ],
                schemaUpdateCourier, cashPaymentScheme, balancePaymentScheme,
                getProductCart, takeCourier, updateCourierStatus, takeOrder, cancleOrder, deliveredOrder,
                inputCashAmount, fullPayment, paymentConfirmed
            }
        }
    }
</script>
