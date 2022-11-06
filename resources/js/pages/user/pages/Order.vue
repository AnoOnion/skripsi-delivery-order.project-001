<template>
    <div :class="[$route.meta.wide ? 'md:w-1/6' : 'md:w-2/6', store.getters['order/orderStatus'] ? 'bg-slate-100 md:bg-transparent dark:bg-slate-700' : null]" class="block space-y-3 md:space-y-4 w-full h-full md:h-[calc(100vh-74px)] p-0 md:p-4 z-10">
        <div v-if="store.getters['order/orderStatus']" class="block space-y-2 w-full p-4 rounded-none md:rounded-lg shadow-md bg-white dark:bg-slate-800">
            <div class="flex items-center space-x-3">
                <img :src="store.getters['courier/taker'].user.avatar" referrerpolicy="no-referrer" class="h-10 aspect-square rounded-lg bg-slate-700/50" />

                <div class="flex justify-between items-center w-full">
                    <div>
                        <h6 class="text-sm font-semibold">{{ (store.getters['courier/taker'].user.nama_depan ?? 'Belum Diketahui') + ' ' + (store.getters['courier/taker'].user.nama_belakang ?? '') }}</h6>
                        <p class="text-2xs text-slate-700 dark:text-slate-300">{{ store.getters['courier/taker'].user.email ?? 'Menunggu kurir mengambil orderan.' }}</p>
                    </div>

                    <div class="flex items-center space-x-3 mt-0.5">
                        <div class="flex flex-col space-y-1">
                            <label for="number-order" class="text-2xs text-slate-700 dark:text-slate-300">Nomer Tx</label>
                            <h6 id="number-order" class="text-xs font-semibold">{{ store.getters['buyer/payment'].kode_pembayaran ?? 'Loading...' }}</h6>
                        </div>

                        <div class="flex flex-col space-y-1">
                            <label for="status" class="text-2xs text-slate-700 dark:text-slate-300">Status</label>
                            <h6 id="status" :class="[
                                store.getters['order/deliveryStatus'] == 'offline' ? 'text-slate-700 dark:text-slate-300 after:bg-slate-700 after:dark:bg-slate-300 before:bg-slate-700 before:dark:bg-slate-300 after:hidden' : null,
                                store.getters['order/deliveryStatus'] == 'ready' ? 'text-black dark:text-white before:bg-black before:dark:bg-white' : null,
                                store.getters['order/deliveryStatus'] == 'pending' ? 'text-amber-500 after:bg-amber-500 before:bg-amber-500' : null,
                                store.getters['order/deliveryStatus'] == 'process' ? 'text-sky-500 after:bg-sky-500 before:bg-sky-500' : null,
                                (store.getters['order/deliveryStatus'] == 'canceled') || (store.getters['order/deliveryStatus'] == 'fail') ? 'text-rose-500 after:bg-rose-500 before:bg-rose-500' : null,
                                (store.getters['order/deliveryStatus'] == 'delivered') || (store.getters['order/deliveryStatus'] == 'paid off') ? 'text-emerald-500 after:bg-emerald-500 before:bg-emerald-500' : null,
                            ]" class="relative pl-3 capitalize text-xs font-bold before:absolute before:top-1.5 before:-left-[-0.0625rem] before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-1.5 after:-left-[-0.0625rem] after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping">{{ store.getters['order/deliveryStatus'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-5">
                    <div>
                        <label for="id-number" class="text-2xs text-slate-700 dark:text-slate-300">ID Nomer</label>
                        <h6 id="id-number" class="truncate text-xs">{{ (store.getters['courier/taker'].vehicle?.kode_laporan ?? 'Belum Diketahui') }}</h6>
                    </div>

                    <div>
                        <label for="number-plate" class="text-2xs text-slate-700 dark:text-slate-300">Plat Nomer</label>
                        <h6 id="number-plate" class="truncate text-xs">{{ (store.getters['courier/taker'].vehicle?.plat_nomer ?? 'Belum Diketahui') }}</h6>
                    </div>

                    <div>
                        <label for="vehicle" class="text-2xs text-slate-700 dark:text-slate-300">Kendaraan</label>
                        <h6 id="vehicle" class="truncate text-xs">{{ (store.getters['courier/taker'].vehicle?.nama_merk ?? 'Belum Diketahui') }}</h6>
                    </div>
                </div>

                <div class="w-[1px] h-8 mt-2 bg-slate-700"></div>

                <div>
                    <label for="distance" class="text-2xs text-slate-700 dark:text-slate-300">Jarak Anda</label>
                    <h6 id="distance" class="truncate text-xs">&plusmn; {{ store.getters['courier/taker'].distance.toFixed([2]) }} km</h6>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-3 md:gap-4 w-full">
            <div class="col-span-4 relative">
                <div class="block space-y-2 absolute top-0 left-0 w-full h-20 p-4 rounded-none rounded-tr-lg md:rounded-lg md:rounded-b-none bg-white dark:bg-slate-800 before:absolute before:bottom-1 md:before:bottom-0 before:-right-2 before:w-2 before:h-2 before:radial-gradient-r dark:before:radial-gradient-r">
                    <div class="flex flex-col space-y-1">
                        <label for="distance" class="text-2xs text-slate-700 dark:text-slate-300">Order</label>
                        <h6 id="distance" class="text-xs">Pesan Sekarang !</h6>
                    </div>

                    <div class="flex items-center space-x-1.5 text-slate-700 dark:text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        <span class="text-2xs">{{ store.getters['cart/items'].length > 0 ? store.getters['cart/items'].length + ' Barang' : 'Belum' }} Dipilih.</span>
                    </div>
                </div>
            </div>

            <div class="col-span-8 flex justify-between items-center space-x-3 w-full p-4 rounded-none rounded-l-lg md:rounded-lg shadow-md bg-white dark:bg-slate-800">
                <PortfolioDetails />
            </div>

            <div class="col-span-12 flex flex-col justify-between h-96 md:h-[calc(100vh-328px)] pb-16 rounded-none md:rounded-lg md:rounded-tl-none overflow-hidden shadow-md bg-white dark:bg-slate-800">
                <Form v-if="day().isBetween(day().hour(8), day().hour(15), 'hour', '[]')" :class="store.getters['cart/items'].length == 0 ? 'justify-center' : null" class="flex flex-col items-center space-y-3 h-full px-4 my-4 overflow-y-auto">
                    <p v-if="store.getters['cart/items'].length == 0" class="px-5 text-xs text-center text-slate-700 dark:text-slate-300">Silahkan pilih produk yang akan ditambahkan ke dalam keranjang dengan menekan tombol dibawah ini.</p>

                    <div v-for="(item, index) in store.getters['cart/items']" :key="item.id" class="flex items-center w-full rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50">
                        <div class="flex items-center space-x-3 w-8/12 px-4 py-3">
                            <img v-if="store.getters['product/products'].find(v => v.id == item.id)?.path" :src="store.getters['product/products'].find(v => v.id == item.id)?.path" class="w-14 aspect-square rounded-md object-cover" />

                            <div v-if="! store.getters['product/products'].find(v => v.id == item.id)?.path" class="w-14 aspect-square rounded-md bg-slate-300 dark:bg-slate-700/50" />

                            <div class="block space-y-0.5 overflow-hidden">
                                <h6 class="truncate text-xs font-semibold">{{ item.name }}</h6>
                                <h6 class="text-xs font-semibold">Rp. {{ rupiah(item.price) }}</h6>
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">{{ store.getters['product/products'].find(v => v.id == item.id)?.stok }} tersedia &middot; {{ day(item.createdAt).from() }}</p>
                            </div>
                        </div>

                        <div class="flex justify-center items-center space-x-4 w-4/12 pr-4">
                            <div v-if="store.getters['product/products'].find(v => v.id == item.id)?.stok == 0 && (! store.getters['order/orderStatus'])" class="px-2.5 py-1.5 border-2 rounded-md text-xs text-center font-semibold text-slate-800 dark:text-slate-200 bg-slate-50 dark:bg-slate-900 border-transparent">
                                habis
                            </div>

                            <Field v-if="store.getters['product/products'].find(v => v.id == item.id)?.stok > 0 || store.getters['order/orderStatus']" v-model="item.qty" :name="'qty-' + item.id" :rules="value => value >= 1 && value <= stockProduct(item.id)" v-slot="{ field, errors }">
                                <div :class="store.getters['order/orderStatus'] ? 'w-16' : 'w-[4.75rem]'" class="flex justify-between items-center border-2 rounded-md bg-slate-50 dark:bg-slate-900 border-transparent">
                                    <button v-if="! store.getters['order/orderStatus']" @click="updateQty(index, (parseInt(item.qty) - 1))" :disabled="item.qty <= 1" type="button" class="px-1 py-1.5 rounded-md bg-slate-300/50 dark:bg-slate-800/50 hover:bg-slate-400/50 dark:hover:bg-slate-700/50 focus:outline-none disabled:opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
                                        </svg>
                                    </button>

                                    <input v-bind="field" @change="updateQty(index, errors.length == 0 ? item.qty : (field.value < 1 ? 1 : stockProduct(item.id)))" @blur="updateQty(index, errors.length == 0 ? item.qty : (field.value < 1 ? 1 : stockProduct(item.id)))" :readonly="store.getters['order/orderStatus']" min="1" :max="stockProduct(item.id)" type="number" placeholder="qty" class="w-full px-1 py-1.5 text-xs text-center font-semibold text-slate-800 dark:text-slate-200 bg-transparent focus:outline-none" />

                                    <button v-if="! store.getters['order/orderStatus']" @click="updateQty(index, (parseInt(item.qty) + 1))" :disabled="item.qty >= stockProduct(item.id)" type="button" class="px-1 py-1.5 rounded-md bg-slate-300/50 dark:bg-slate-800/50 hover:bg-slate-400/50 dark:hover:bg-slate-700/50 focus:outline-none disabled:opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                </div>
                            </Field>

                            <button v-if="! store.getters['order/orderStatus']" @click="removeCart(index)" type="button" class="focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button v-if="! store.getters['order/orderStatus']" @click="state.cart.modal = true" type="button" class="flex items-center space-x-1.5 px-3 py-2.5 md:py-2 rounded-lg group bg-blue-500 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white group-disabled:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>

                        <h6 class="text-xs font-semibold text-white group-disabled:text-slate-300">Tambahkan Item</h6>
                    </button>
                </Form>

                <div v-if="!day().isBetween(day().hour(8), day().hour(15), 'hour', '[]')" class="flex items-center h-full px-4 my-4">
                    <p class="px-5 text-xs text-center font-semibold text-slate-700 dark:text-slate-300">Maaf, untuk jam sekarang layanan pesan antar sudah ditutup, silahkan kembali lagi besok pada jam <b class="font-bold text-blue-500">08.00 - 15.00</b>.</p>
                </div>

                <div v-if="day().isBetween(day().hour(8), day().hour(15), 'hour', '[]')" class="fixed bottom-16 w-full border-t border-slate-300 dark:border-slate-800 bg-slate-800">
                    <div class="flex justify-between items-center w-full p-4 bg-slate-100 dark:bg-slate-900/50">
                        <div class="flex flex-col space-y-0.5">
                            <p class="truncate text-2xs text-slate-700 dark:text-slate-300">Total Pembayaran</p>
                            <h6 class="truncate text-xs font-semibold">Rp. {{ rupiah(store.getters['cart/totalPrice']) }} <span class="text-slate-700 dark:text-slate-300">+ Fee Rp. {{ rupiah(store.getters['order/courier'].cost != 1000 ? store.getters['order/courier'].cost : (store.getters['courier/courier'].length > 0 ? Math.max(...store.getters['courier/courier'].map(v => v.cost)) : 1000)) }}</span></h6>
                        </div>

                        <div class="flex items-center space-x-3">
                            <button v-if="! store.getters['order/orderStatus'] && store.getters['cart/items'].length > 0" @click="resetCart" class="flex items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-rose-500 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <button v-if="! store.getters['order/orderStatus']" @click="order" :disabled="store.getters['buyer/payment'].id == null || store.getters['cart/items'].length == 0 || store.getters['cart/totalPrice'] == 0" class="flex items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-blue-500 focus:outline-none disabled:text-slate-300 disabled:bg-blue-500/75">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>

                                <h6 class="truncate text-xs font-semibold">Bayar Rp. {{ rupiah(parseInt(store.getters['cart/totalPrice']) + (store.getters['courier/courier'].length > 0 ? Math.max(...store.getters['courier/courier'].map(v => v.cost)) : 1000)) }}</h6>
                            </button>

                            <button v-if="store.getters['order/orderStatus'] && (store.getters['order/deliveryStatus'] == 'pending')" @click="cancelOrder" class="flex items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-rose-500 focus:outline-none">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>

                                <h6 class="truncate text-xs">Menunggu / Batal</h6>
                            </button>

                            <button v-if="store.getters['order/orderStatus'] && (store.getters['order/deliveryStatus'] == 'process')" class="flex items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-white bg-slate-600/50 focus:outline-none" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>

                                <h6 class="truncate text-xs">Kurir Menuju Tempat.</h6>
                            </button>

                            <button v-if="store.getters['order/orderStatus'] && (store.getters['order/deliveryStatus'] == 'delivered')" class="flex items-center space-x-1.5 w-full px-3 py-2.5 md:py-2 rounded-lg text-emerald-600 dark:text-emerald-400 bg-emerald-600/50 focus:outline-none" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <h6 class="truncate text-xs">Kurir Sudah Sampai.</h6>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <TransitionRoot appear :show="state.cart.modal" as="template">
            <Dialog as="div" @close="state.cart.modal = false">
                <div class="flex justify-center fixed top-0 inset-x-0 min-h-screen pt-[4.75rem] px-4 z-50">
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
                        <div class="block relative max-w-md h-[calc(100vh-112px)] mt-1 rounded-lg transform align-middle overflow-hidden shadow-md text-black dark:text-white bg-slate-100 dark:bg-slate-800">
                            <div class="flex justify-between items-center p-4">
                                <div>
                                    <h6 class="text-sm font-semibold">Semua Produk Tersedia</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Lorem ipsum dolor sit amet consectetur.</p>
                                </div>

                                <button @click="state.cart.modal = false" class="cursor-pointer focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div>
                                <div class="grid grid-cols-3 gap-3 h-full px-4 overflow-y-auto">
                                    <template v-for="(product, index) in store.getters['product/products']" :key="index">
                                        <div v-if="product.status == '1'" @click="addCart(product.id, product.nama_item, product.harga, product.stok)" :class="product.stok > 0 ? 'cursor-pointer' : 'cursor-default'" class="block space-y-3 p-4 rounded-md group bg-white dark:bg-slate-900/50">
                                            <div class="flex flex-col items-center space-y-2 overflow-hidden bg-opacity-50 dark:bg-opacity-50">
                                                <img :src="product.path" :class="product.stok > 0 ? 'group-hover:scale-125' : ''" class="w-full aspect-square object-cover transition-all transform duration-300 ease-in-out" loading="lazy" />
                                            </div>

                                            <div class="block space-y-1.5">
                                                <h6 class="text-2xs font-semibold text-slate-700 dark:text-slate-300">{{ product.nama_item }}</h6>

                                                <div class="block space-y-0.5">
                                                    <div class="flex items-center space-x-1">
                                                        <h6 class="px-1 py-0.5 text-2xs font-semibold rounded-sm text-rose-400 bg-rose-400 bg-opacity-30 dark:bg-opacity-30">{{ product.stok }}</h6>
                                                        <div class="text-2xs font-semibold text-slate-400">Stok</div>
                                                    </div>

                                                    <h6 class="text-xs font-semibold">Rp. {{ rupiah(product.harga) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
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
    import { defineComponent, getCurrentInstance, inject, onMounted, reactive } from '@vue/runtime-core'

    import axios from 'axios'

    import PortfolioDetails from '~/components/PortfolioDetails.vue'

    import { TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle } from '@headlessui/vue'

    export default defineComponent({
        components: {
            PortfolioDetails,
            TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle
        },

        setup() {
            const day      = inject('day')
            const rupiah   = inject('rupiah')
            const baseurl  = inject('baseurl')

            let map        = getCurrentInstance()

            const store    = useStore()
            const state    = reactive({
                cart: {
                    modal: false
                }
            })

            setTimeout(() => {
                map = map.appContext.config.globalProperties.$map
            }, 1000)

            const addCart    = (id, name, price, stock) => {
                if (stock > 0) {
                    state.cart.modal = false

                    store.dispatch('cart/saveCart', {
                        stock, item: {
                            id, name, qty: 1, price, total: price, createdAt: new Date()
                        }
                    })
                }
            }

            const updateQty  = (index, qty) => store.dispatch('cart/updateCart', { index, qty })
            const removeCart = (index)      => store.dispatch('cart/removeCart', { index })
            const resetCart  = ()           => store.dispatch('cart/resetCart')

            const stockProduct = (id) => {
                return store.getters['product/products'].find(v => v.id == id)?.stok
            }

            const order      = () => {
                store.dispatch('order/eventOrder', {
                    orderStatus: true,
                    deliveryStatus: store.getters['order/deliveryStatus']
                })

                axios.post('/api/user/order', {
                    items: store.getters['cart/items'],
                    payment_id: store.getters['buyer/payment'].id
                }).then(() => {
                    store.dispatch('order/eventOrder', {
                        orderStatus: true,
                        deliveryStatus: 'pending'
                    })

                    axios.post('/api/user/tracking/update', {
                        status: true,
                        location: store.getters['order/location']
                    })
                })
            }

            const cancelOrder = () => {
                axios.post('/api/user/tracking/update', {
                    status: false,
                    location: null
                }).then(() => {
                    store.dispatch('order/eventOrder', {
                        orderStatus: false,
                        deliveryStatus: 'canceled'
                    })

                    axios.delete('/api/user/order/' + store.getters['buyer/payment'].id)
                })
            }

            onMounted(() => {
                if (store.getters['product/products'].length == 0) {
                    axios.get('/api/user/product').then(({ data }) => {
                        store.dispatch('product/saveDataProduct', {
                            products: data.results
                        })
                    })
                }
            })

            return {
                day, rupiah, baseurl,
                store, state,
                addCart, updateQty, removeCart, resetCart,
                stockProduct, order, cancelOrder
            }
        }
    })
</script>
