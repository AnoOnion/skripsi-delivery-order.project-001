<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Produk</div>
            </nav>

            <div class="flex justify-between items-center space-x-4 whitespace-nowrap">
                <div>
                    <h6 class="text-sm font-semibold">Produk Yang Disediakan.</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar produk yang tersedia untuk pelanggan.</p>
                </div>

                <div>
                    <button v-if="store.getters['auth/level'] == 'admin'" @click="state.addProduct.modal = true" class="flex items-center space-x-1.5 px-3 py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
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
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">NAMA PRODUK</td>
                        <td class="w-52 md:w-auto px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider whitespace-nowrap">DESKRIPSI PRODUK</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">BERAT</td>
                        <td class="px-3 md:px-5 py-3 text-center font-medium text-slate-500 tracking-wider">VOLUME</td>
                        <td class="px-3 md:px-5 py-3 text-center font-medium text-slate-500 tracking-wider">STOK</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">HARGA</td>
                        <td v-if="store.getters['auth/level'] == 'admin'" class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">STATUS</td>
                        <td class="px-3 md:px-5 py-3 font-medium text-slate-500 tracking-wider">DIEDIT</td>
                        <td v-if="store.getters['auth/level'] == 'admin'" class="sticky md:static right-0 px-3 md:px-5 py-3 bg-white dark:bg-slate-800/50"></td>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    <template v-if="state.loading">
                        <tr v-for="loading in 3" :key="loading" class="text-sm font-flow">
                            <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap text-slate-500">x.</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">
                                <div class="w-20 aspect-square rounded-md bg-slate-800/50"></div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">
                                <div class="text-xs text-slate-500">PD-123456</div>
                                <div>Lorem ipsum dolor sit.</div>
                                <div class="text-sm text-slate-500">Dibuat Oleh Admin</div>
                            </td>
                            <td class="w-52 md:w-auto px-3 md:px-5 py-3 md:py-4 text-sm">Tidak Ada</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">00 kg</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">00 L</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">00</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">Rp. 00.000</td>
                            <td v-if="store.getters['auth/level'] == 'admin'" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap"></td>
                            <td class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">00 00 0000 00:00</td>
                            <td v-if="store.getters['auth/level'] == 'admin'" class="px-3 md:px-5 py-3"></td>
                        </tr>
                    </template>

                    <template v-else>
                        <tr v-for="(product, index) in state.pagination.listProducts" :key="product.id" class="text-sm">
                            <th @click="detailProduct(product.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap text-slate-500">{{ index + 1 + state.pagination.begin }}.</th>
                            <td @click="detailProduct(product.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">
                                <img :src="product.path" class="w-20 aspect-square rounded-md object-cover" />
                            </td>
                            <td @click="detailProduct(product.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer">
                                <div class="text-xs text-slate-500">{{ product.kode_item }}</div>
                                <div>{{ product.nama_item }}</div>
                                <div class="text-xs whitespace-nowrap text-slate-500">Dibuat Oleh {{ product.nama_depan }}</div>
                            </td>
                            <td @click="detailProduct(product.id)" class="w-52 md:w-auto px-3 md:px-5 py-3 md:py-4 text-xs md:text-sm cursor-pointer">{{ product.deskripsi ?? 'Tidak Ada' }}</td>
                            <td @click="detailProduct(product.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ product.berat }} kg</td>
                            <td @click="detailProduct(product.id)" class="px-3 md:px-5 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">{{ product.volume }} L</td>
                            <td @click="editStockProduct(product.id)" class="px-3 md:px-5 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">{{ product.stok != null ? product.stok : 'Belum Ada' }}</td>
                            <td @click="detailProduct(product.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ product.harga != null ? ('Rp. ' + rupiah(product.harga)) : 'Belum Ada' }}</td>
                            <td v-if="store.getters['auth/level'] == 'admin'" class="px-3 md:px-5 py-3 md:py-4">
                                <Switch @update:modelValue="updateStatusProduct(product.id, product.status != '1')" :class="product.status == '1' ? 'bg-emerald-500' : 'bg-slate-200'" class="relative flex items-center h-4 m-auto transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-7 focus:outline-none">
                                    <span class="sr-only">Use setting</span>
                                    <span aria-hidden="true" :class="product.status == '1' ? 'translate-x-3.5 bg-white' : 'translate-x-0 bg-white dark:bg-slate-700'" class="pointer-events-none inline-block w-2.5 h-2.5 rounded-full transform transition ease-in-out duration-200" />
                                </Switch>
                            </td>
                            <td @click="detailProduct(product.id)" class="px-3 md:px-5 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ day(product.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td v-if="store.getters['auth/level'] == 'admin'" class="sticky right-0 px-3 md:px-5 py-3 bg-slate-100 dark:bg-slate-900">
                                <div class="flex items-center space-x-3">
                                    <button @click="editStockProduct(product.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>

                                    <button @click="editProduct(product.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <button @click="removeProduct(product.id)" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="state.products.length == 0">
                            <td :colspan="store.getters['auth/level'] == 'admin' ? '11' : '10'" class="py-4 text-center text-sm">
                                Produk Belum Ada.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan {{ state.pagination.listProducts.length > 0 ? '1' : '0' }} sampai {{ state.pagination.listProducts.length }} dari {{ state.products.length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= state.products.length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <TransitionRoot appear :show="state.detailProduct.modal" as="template">
            <Dialog as="div" :open="state.detailProduct.modal" @close="state.detailProduct.modal = false">
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
                        <div class="inline-block space-y-3 w-full max-w-lg p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Detail Produk</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Daftar informasi lengkap tentang produk ini.</p>
                                </div>

                                <button @click="state.detailProduct.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-4">
                                    <Swiper
                                        :modules="modulesSwiper"
                                        slidesPerView="2"
                                        :spaceBetween="12"
                                        :autoplay="{
                                            delay: 5000,
                                            disableOnInteraction: false
                                        }"
                                        :breakpoints="{
                                            768: {
                                                slidesPerView: 1
                                            }
                                        }"
                                        :pagination="{ clickable: true }"
                                        class="w-full !pl-6 md:!pl-0 !pr-6 md:!pr-0"
                                    >
                                        <SwiperSlide v-for="(image, index) in state.detailProduct.data.images" :key="index">
                                            <img :src="image.path" class="w-full h-32 rounded-md object-cover" />
                                        </SwiperSlide>
                                    </Swiper>
                                </div>

                                <div class="col-span-12 md:col-span-8 grid grid-cols-12 gap-4">
                                    <div class="col-span-4">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">ID Produk</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailProduct.data.detail.kode_item }}</h6>
                                    </div>
                                    <div class="col-span-8">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Nama Produk</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailProduct.data.detail.nama_item }}</h6>
                                    </div>

                                    <div class="col-span-12">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Deskripsi</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailProduct.data.detail.deskripsi }}</h6>
                                    </div>

                                    <div class="col-span-3">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Berat</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailProduct.data.detail.berat ?? 'Belum Diketahui' }} Kg</h6>
                                    </div>
                                    <div class="col-span-3">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Volume</p>
                                        <h6 class="text-xs font-semibold">{{ state.detailProduct.data.detail.volume ?? 'Belum Diketahui' }} L</h6>
                                    </div>
                                    <div class="col-span-3">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Kupon</p>
                                        <h6 class="capitalize text-xs font-semibold">{{ state.detailProduct.data.detail.kupon }}</h6>
                                    </div>
                                    <div class="col-span-3">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Status</p>
                                        <h6 class="capitalize text-xs font-semibold">{{ state.detailProduct.data.detail.status == '1' ? 'aktif' : 'non-aktif' }}</h6>
                                    </div>

                                    <div class="col-span-6">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Dibuat</p>
                                        <h6 class="capitalize text-xs font-semibold">{{ day(state.detailProduct.data.detail.created_at).format('DD MMM YYYY - HH:mm') }}</h6>
                                    </div>
                                    <div class="col-span-6">
                                        <p class="text-2xs text-slate-700 dark:text-slate-300">Diedit</p>
                                        <h6 class="capitalize text-xs font-semibold">{{ day(state.detailProduct.data.detail.updated_at).format('DD MMM YYYY - HH:mm') }}</h6>
                                    </div>
                                </div>

                                <div class="col-span-12 max-h-60 overflow-auto">
                                    <table class="min-w-full divide-y divide-slate-50 dark:divide-slate-700">
                                        <thead class="bg-white dark:bg-slate-700/50">
                                            <tr>
                                                <th rowspan="2" class="px-3 py-2 text-2xs font-medium text-slate-500 tracking-wider">NO</th>
                                                <td colspan="3" class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">STOK</td>
                                                <td colspan="2" class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">HARGA</td>
                                                <td rowspan="2" class="px-3 py-2 text-2xs font-medium text-slate-500 tracking-wider">DIEDIT</td>
                                            </tr>
                                            <tr>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">AWAL</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">SEMENTARA</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">AKHIR</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">BELI</td>
                                                <td class="px-3 py-2 text-center text-2xs font-medium text-slate-500 tracking-wider">JUAL</td>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                                            <template v-if="state.detailProduct.data.stock.length > 0">
                                                <tr v-for="(stock, index) in state.detailProduct.data.stock" :key="index" class="text-xs cursor-pointer">
                                                    <th class="px-3 py-3 md:py-4 cursor-pointer whitespace-nowrap text-slate-500">{{ index + 1 }}.</th>
                                                    <td class="px-3 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">{{ stock.stok_awal }}</td>
                                                    <td class="px-3 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">{{ stock.stok_sementara }}</td>
                                                    <td class="px-3 py-3 md:py-4 text-center cursor-pointer whitespace-nowrap">{{ stock.stok_akhir }}</td>
                                                    <td class="px-3 py-3 md:py-4 cursor-pointer whitespace-nowrap">Rp. {{ rupiah(stock.harga_beli) }}</td>
                                                    <td class="px-3 py-3 md:py-4 cursor-pointer whitespace-nowrap">Rp. {{ rupiah(stock.harga_jual) }}</td>
                                                    <td class="px-3 py-3 md:py-4 cursor-pointer whitespace-nowrap">{{ day(stock.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                                                </tr>
                                            </template>

                                            <tr v-if="state.detailProduct.data.stock.length == 0">
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

        <TransitionRoot appear :show="state.addProduct.modal" as="template">
            <Dialog as="div" :open="state.addProduct.modal" @close="state.addProduct.modal = false">
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
                        <Form @submit="addProduct" :validation-schema="schemaProduct" v-slot="{ errors, resetForm }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Tambah Produk Item</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Masukan produk baru untuk pelanggan.</p>
                                </div>

                                <button type="button" @click="state.addProduct.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="product-id" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ID Produk</label>

                                    <div :class="errors['kode_item'] || state.addProduct.error.message.errors?.kode_item ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="kode_item" :value="'PD-' + day(new Date()).unix().toString().substr(5, 5)" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="product-id" readonly />
                                    </div>

                                    <ErrorMessage name="kode_item" class="text-xs text-rose-500" />
                                    <span v-if="state.addProduct.error.message.errors?.kode_item" v-html="state.addProduct.error.message.errors.kode_item[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-8 flex flex-col space-y-2">
                                    <label for="product-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Produk</label>

                                    <div :class="errors['nama_item'] || state.addProduct.error.message.errors?.nama_item ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.addProduct.error.message.errors['nama_item']" name="nama_item" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="product-name" placeholder="Lorem, ipsum dolor." />
                                    </div>

                                    <ErrorMessage name="nama_item" class="text-xs text-rose-500" />
                                    <span v-if="state.addProduct.error.message.errors?.nama_item" v-html="state.addProduct.error.message.errors.nama_item[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="description" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Deskripsi</label>

                                    <div :class="errors['deskripsi'] || state.addProduct.error.message.errors?.deskripsi ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.addProduct.error.message.errors['deskripsi']" as="textarea" name="deskripsi" class="w-full h-20 text-xs font-semibold bg-transparent focus:outline-none" id="description" />
                                    </div>

                                    <ErrorMessage name="deskripsi" class="text-xs text-rose-500" />
                                    <span v-if="state.addProduct.error.message.errors?.deskripsi" v-html="state.addProduct.error.message.errors.deskripsi[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Gambar</label>

                                    <div :class="errors['gambar'] || state.addProduct.error.message.errors?.gambar ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <label class="block">
                                            <span class="sr-only">Choose File</span>
                                            <Field name="gambar" type="file" accept="image/jpeg, image/png, image/jpg" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:text-white dark:file:text-blue-500 file:bg-blue-500 dark:file:bg-slate-300" multiple />
                                        </label>
                                    </div>

                                    <ErrorMessage name="gambar" class="text-xs text-rose-500" />
                                    <span v-if="state.addProduct.error.message.errors?.gambar" v-html="state.addProduct.error.message.errors.gambar[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-3 flex flex-col space-y-2">
                                    <label for="heavy" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Berat</label>

                                    <div :class="errors['berat'] || state.addProduct.error.message.errors?.berat ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.addProduct.error.message.errors['berat']" name="berat" type="number" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="heavy" placeholder="20" />
                                    </div>

                                    <ErrorMessage name="berat" class="text-xs text-rose-500" />
                                    <span v-if="state.addProduct.error.message.errors?.berat" v-html="state.addProduct.error.message.errors.berat[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-3 flex flex-col space-y-2">
                                    <label for="volume" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Volume</label>

                                    <div :class="errors['volume'] || state.addProduct.error.message.errors?.volume ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.addProduct.error.message.errors['volume']" name="volume" type="number" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="volume" placeholder="20" />
                                    </div>

                                    <ErrorMessage name="volume" class="text-xs text-rose-500" />
                                    <span v-if="state.addProduct.error.message.errors?.volume" v-html="state.addProduct.error.message.errors.volume[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="coupon" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Kupon</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="kupon" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="coupon">
                                            <div :class="errors['kupon'] || state.addProduct.error.message.errors?.kupon ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { label: 'ya' },
                                                        { label: 'tidak' }
                                                    ]"
                                                    v-bind="field"
                                                    key-prop="label"
                                                    label-prop="label"
                                                />
                                            </div>
                                        </Field>
                                    </div>

                                    <ErrorMessage name="kupon" class="text-xs text-rose-500" />
                                    <span v-if="state.addProduct.error.message.errors?.kupon" v-html="state.addProduct.error.message.errors.kupon[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="resetForm({
                                        values: {
                                            nama_item: '',
                                            deskripsi: '',
                                            berat: '',
                                            volume: '',
                                            kupon: ''
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

        <TransitionRoot appear :show="state.updateProduct.modal" as="template">
            <Dialog as="div" :open="state.updateProduct.modal" @close="state.updateProduct.modal = false">
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
                        <Form @submit="updateProduct" :validation-schema="schemaProduct" v-slot="{ errors, resetForm }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Edit Produk Item</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Perbarui data produk item sekarang.</p>
                                </div>

                                <button @click="state.updateProduct.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-4 flex flex-col space-y-2">
                                    <label for="product-id" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ID Produk</label>

                                    <div :class="errors['kode_item'] || state.updateProduct.error.message.errors?.kode_item ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="kode_item" :value="state.updateProduct.data.detail.kode_item"  class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="product-id" readonly />
                                    </div>

                                    <ErrorMessage name="kode_item" class="text-xs text-rose-500" />
                                    <span v-if="state.updateProduct.error.message.errors?.kode_item" v-html="state.updateProduct.error.message.errors.kode_item[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-8 flex flex-col space-y-2">
                                    <label for="product-name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Produk</label>

                                    <div :class="errors['nama_item'] || state.updateProduct.error.message.errors?.nama_item ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.updateProduct.error.message.errors['nama_item']" name="nama_item" :value="state.updateProduct.data.detail.nama_item" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="product-name" placeholder="Lorem, ipsum dolor." />
                                    </div>

                                    <ErrorMessage name="nama_item" class="text-xs text-rose-500" />
                                    <span v-if="state.updateProduct.error.message.errors?.nama_item" v-html="state.updateProduct.error.message.errors.nama_item[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label for="description" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Deskripsi</label>

                                    <div :class="errors['deskripsi'] || state.updateProduct.error.message.errors?.deskripsi ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.updateProduct.error.message.errors['deskripsi']" as="textarea" name="deskripsi" :value="state.updateProduct.data.detail.deskripsi" class="w-full h-20 text-xs font-semibold bg-transparent focus:outline-none" id="description" />
                                    </div>

                                    <ErrorMessage name="deskripsi" class="text-xs text-rose-500" />
                                    <span v-if="state.updateProduct.error.message.errors?.deskripsi" v-html="state.updateProduct.error.message.errors.deskripsi[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex flex-col space-y-2">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Gambar</label>

                                    <div :class="errors['gambar'] || state.updateProduct.error.message.errors?.gambar ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <label class="block">
                                            <span class="sr-only">Choose File</span>
                                            <Field name="gambar" type="file" accept="image/jpeg, image/png, image/jpg" class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:text-white dark:file:text-blue-500 file:bg-blue-500 dark:file:bg-slate-300" multiple />
                                        </label>
                                    </div>

                                    <ErrorMessage name="gambar" class="text-xs text-rose-500" />
                                    <span v-if="state.updateProduct.error.message.errors?.gambar" v-html="state.updateProduct.error.message.errors.gambar[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-3 flex flex-col space-y-2">
                                    <label for="heavy" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Berat</label>

                                    <div :class="errors['berat'] || state.updateProduct.error.message.errors?.berat ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.updateProduct.error.message.errors['berat']" name="berat" :value="state.updateProduct.data.detail.berat" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="heavy" placeholder="20" />
                                    </div>

                                    <ErrorMessage name="berat" class="text-xs text-rose-500" />
                                    <span v-if="state.updateProduct.error.message.errors?.berat" v-html="state.updateProduct.error.message.errors.berat[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-3 flex flex-col space-y-2">
                                    <label for="volume" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Volume</label>

                                    <div :class="errors['volume'] || state.updateProduct.error.message.errors?.volume ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.updateProduct.error.message.errors['volume']"  name="volume" :value="state.updateProduct.data.detail.volume" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="volume" placeholder="20" />
                                    </div>

                                    <ErrorMessage name="volume" class="text-xs text-rose-500" />
                                    <span v-if="state.updateProduct.error.message.errors?.volume" v-html="state.updateProduct.error.message.errors.volume[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="coupon" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Kupon</label>

                                    <div class="relative overscroll-contain">
                                        <Field name="kupon" :value="state.updateProduct.data.detail.kupon" v-slot="{ field }" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-300" id="coupon">
                                            <div :class="errors['kupon'] || state.updateProduct.error.message.errors?.kupon ? 'border-rose-400' : 'border-transparent'" class="w-full py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 focus:outline-none">
                                                <SelectInput
                                                    :options="[
                                                        { label: 'ya' },
                                                        { label: 'tidak' }
                                                    ]"
                                                    v-bind="field"
                                                    :value="field.value"
                                                    key-prop="label"
                                                    label-prop="label"
                                                />
                                            </div>
                                        </Field>
                                    </div>

                                    <ErrorMessage name="kupon" class="text-xs text-rose-500" />
                                    <span v-if="state.updateProduct.error.message.errors?.kupon" v-html="state.updateProduct.error.message.errors.kupon[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="resetForm({
                                        values: {
                                            nama_item: state.updateProduct.data.detail.nama_item,
                                            deskripsi: state.updateProduct.data.detail.deskripsi,
                                            berat: state.updateProduct.data.detail.berat,
                                            volume: state.updateProduct.data.detail.volume,
                                            kupon: state.updateProduct.data.detail.kupon
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

        <TransitionRoot appear :show="state.deleteProduct.modal" as="template">
            <Dialog as="div" :open="state.deleteProduct.modal" @close="state.deleteProduct.modal = false">
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
                                    <h6 class="text-sm font-semibold">Hapus Produk Item</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Hapus permanen data produk yang dipilih.</p>
                                </div>

                                <button @click="state.deleteProduct.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <p class="text-sm">Apakah anda ingin menghapus data produk ini ?</p>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click.prevent="state.deleteProduct.modal = false" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-slate-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>

                                        <h6 class="truncate text-xs text-white">Batal</h6>
                                    </button>

                                    <button @click="deleteProduct" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-rose-500 focus:outline-none">
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

        <TransitionRoot appear :show="state.updateStockProduct.modal" as="template">
            <Dialog as="div" :open="state.updateStockProduct.modal" @close="state.updateStockProduct.modal = false">
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
                        <Form @submit="updateStockProduct" :validation-schema="schemaStock" v-slot="{ errors }" class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Kelola Stok Produk</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Perbarui stok produk hari ini.</p>
                                </div>

                                <button @click="state.updateStockProduct.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-x-3 gap-y-4">
                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="stock" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Stok Tambahan</label>

                                    <div :class="errors['stok'] || state.updateStockProduct.error.message.errors?.stok ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field name="stok" type="number" v-slot="{ field, handleChange }">
                                            <input :value="field.value" @change="event => {
                                                handleChange(event, false)
                                                inputStock(event)
                                            }" type="number" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="stock">
                                        </Field>
                                    </div>

                                    <ErrorMessage name="stok" class="text-xs text-rose-500" />
                                    <span v-if="state.updateStockProduct.error.message.errors?.stok" v-html="state.updateStockProduct.error.message.errors.stok[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="stock-accumulation" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Total Stok Tersedia</label>

                                    <div class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <input type="text" :value="state.updateStockProduct.data?.akumulasi_stok" class="w-full text-xs font-semibold bg-transparent read-only:text-slate-700 dark:read-only:text-slate-300 focus:outline-none" id="stock-accumulation" readonly />
                                    </div>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="purchase-price" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Harga Beli</label>

                                    <div :class="errors['harga_beli'] || state.updateStockProduct.error.message.errors?.harga_beli ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.updateStockProduct.error.message.errors['harga_beli']" name="harga_beli" :value="state.updateStockProduct.data?.harga_beli" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="purchase-price" placeholder="20.xxx" />
                                    </div>

                                    <ErrorMessage name="harga_beli" class="text-xs text-rose-500" />
                                    <span v-if="state.updateStockProduct.error.message.errors?.harga_beli" v-html="state.updateStockProduct.error.message.errors.harga_beli[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-6 flex flex-col space-y-2">
                                    <label for="selling-price" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Harga Jual</label>

                                    <div :class="errors['harga_jual'] || state.updateStockProduct.error.message.errors?.harga_jual ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                        <Field @keydown="delete state.updateStockProduct.error.message.errors['harga_jual']" name="harga_jual" :value="state.updateStockProduct.data?.harga_jual" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="selling-price" placeholder="20.xxx" />
                                    </div>

                                    <ErrorMessage name="harga_jual" class="text-xs text-rose-500" />
                                    <span v-if="state.updateStockProduct.error.message.errors?.harga_jual" v-html="state.updateStockProduct.error.message.errors.harga_jual[0]" role="alert" class="text-xs text-rose-500"></span>
                                </div>

                                <div class="col-span-12 flex justify-end items-center space-x-3">
                                    <button @click="state.updateStockProduct.modal = false" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg bg-rose-500 focus:outline-none">
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
    </div>
</template>

<script>
    import 'swiper/css'

    import { useStore } from 'vuex'
    import { inject, onMounted, reactive } from '@vue/runtime-core'

    import axios from 'axios'
    import Pusher from 'pusher-js'

    import { object, string, number, mixed } from 'yup'

    import { Autoplay } from 'swiper'
    import { Swiper, SwiperSlide } from 'swiper/vue'

    import SelectInput from '~/components/form/SelectInput'
    import { Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Switch, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            SelectInput,
            Swiper, SwiperSlide,
            Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Switch, Dialog, DialogOverlay
        },

        setup() {
            const day    = inject('day')
            const rupiah = inject('rupiah')
            const pusher = inject('pusher')

            const store  = useStore()
            const state  = reactive({
                products: [],
                loading: true,

                pagination: {
                    begin: 0,
                    end: 10,
                    listProducts: []
                },

                detailProduct: {
                    data: null,
                    modal: false
                },

                addProduct: {
                    data: {
                        files: []
                    },
                    modal: false,
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                },

                updateProduct: {
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

                deleteProduct: {
                    id: null,
                    modal: false
                },

                updateStockProduct: {
                    data: {
                        akumulasi_stok: 0
                    },
                    modal: false,
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                },
            })

            const schemaProduct = object({
                kode_item: string().required(),
                nama_item: string().required().min(5),
                deskripsi: string().nullable(),
                gambar: mixed()
                            .test('fileSize', 'Ukuran file terlalu besar', val => {
                                return val?.filter(v => v.size <= 2097152).length == val?.length
                            })
                            .test('fileType', 'Format file tidak didukung', val => {
                                return val?.filter(v => [
                                    'image/jpeg', 'image/png', 'image/jpg'
                                ].includes(v.type)).length == val?.length
                            }),
                berat: number().nullable(),
                volume: number().nullable(),
                kupon: string().required()
            })

            const schemaStock = object({
                stok: number().nullable(),
                harga_beli: number().nullable(),
                harga_jual: number().required()
            })

            const pageControl = (direction = null) => {
                if (direction === 'left') {
                    state.pagination.begin -= 10
                    state.pagination.end -= 10
                } else if (direction === 'right') {
                    state.pagination.begin += 10
                    state.pagination.end += 10
                }

                state.pagination.listProducts = state.products.slice(
                    state.pagination.begin, state.pagination.end
                )
            }

            const detailProduct = (id) => {
                axios.get('/api/admin/product/' + id).then(({ data }) => {
                    state.detailProduct = {
                        data: data.results,
                        modal: true
                    }
                })
            }

            const editProduct = (id) => {
                axios.get('/api/admin/product/' + id).then(({ data }) => {
                    state.updateProduct.modal = true
                    state.updateProduct.data  = data.results
                })
            }

            const removeProduct = (id) => {
                state.deleteProduct = {
                    id, modal: true
                }
            }

            const editStockProduct = (id) => {
                if (store.getters['auth/level'] == 'admin') {
                    axios.get('/api/admin/product/stock/' + id).then(({ data }) => {
                        state.updateStockProduct.modal = true
                        state.updateStockProduct.data  = {
                            ...data.results, id
                        }
                    })
                } else {
                    detailProduct(id)
                }
            }

            const inputStock = (event) => {
                // delete state.updateStockProduct.error.message.errors['stok']

                state.updateStockProduct.data.akumulasi_stok = (
                    parseInt(state.updateStockProduct.data.stok_akhir) + parseInt(event.target.value)
                )
            }

            const addProduct = (values) => {
                let formData = new FormData()

                Object.entries(values).forEach(([key, value]) => {
                    if (key == 'gambar') {
                        values.gambar?.forEach((v, i) => formData.append('gambar[' + i + ']', v))
                    } else {
                        formData.append(key, value)
                    }
                })

                axios.post('/api/admin/product', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(({ data }) => {
                    state.addProduct.modal = false
                }).catch(({ response }) => {
                    state.addProduct.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const updateProduct = (values) => {
                let formData = new FormData()

                formData.append('_method', 'PATCH')

                Object.entries(values).forEach(([key, value]) => {
                    if (key == 'gambar') {
                        values.gambar?.forEach((v, i) => formData.append('gambar[' + i + ']', v))
                    } else {
                        formData.append(key, value)
                    }
                })

                axios.post('/api/admin/product/' + state.updateProduct.data.detail.id, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(() => {
                    state.updateProduct.modal = false
                }).catch(({ response }) => {
                    state.updateProduct.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const deleteProduct = () => {
                axios.delete('/api/admin/product/' + state.deleteProduct.id).then(() => {
                    state.deleteProduct.modal = false

                    state.products.splice(
                        state.products.findIndex(v => v.id == state.deleteProduct.id), 1
                    )

                    pageControl()
                })
            }

            const updateStatusProduct = (id, value) => {
                axios.patch('/api/admin/product/status/' + id, {
                    status: value
                }).then(() => {})
            }

            const updateStockProduct = (values) => {
                axios.patch('/api/admin/product/stock/' + state.updateStockProduct.data.id, values).then(() => {
                    state.updateStockProduct.modal = false
                }).catch(({ response }) => {
                    state.updateStockProduct.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            onMounted(() => {
                let channel = new Pusher('29fd29eb69f3c3e55dd1', {
                    ...pusher
                })

                if (store.getters['search/search'].length > 0) {
                    state.loading  = false
                    state.products = store.getters['search/search']

                    pageControl()

                    store.dispatch('search/saveDataSearch', [])
                } else {
                    axios.get('/api/admin/product').then(({ data }) => {
                        state.loading  = false
                        state.products = data.results

                        pageControl()
                    })
                }

                channel.subscribe('product.admin').bind('App\\Events\\UpdateProductForAdmin', ({ products }) => {
                    state.products = products

                    pageControl()
                })
            })

            return {
                day, rupiah,
                store, state,
                modulesSwiper: [ Autoplay ],
                schemaProduct, schemaStock,
                pageControl, detailProduct, editProduct, removeProduct, editStockProduct, inputStock,
                addProduct, updateProduct, deleteProduct, updateStatusProduct, updateStockProduct
            }
        }
    }
</script>
