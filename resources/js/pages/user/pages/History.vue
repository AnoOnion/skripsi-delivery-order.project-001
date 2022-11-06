<template>
    <div :class="$route.meta.wide ? 'md:w-1/6' : 'md:w-2/6'" class="block space-y-3 w-full h-[calc(100vh-130px)] md:h-[calc(100vh-112px)] p-0 md:p-4 ounded-none md:rounded-lg shadow-md z-10 bg-slate-100 dark:bg-slate-700">
        <div class="block space-y-4 h-1/2 p-4 overflow-auto bg-white dark:bg-slate-800">
            <div>
                <h6 class="text-sm font-semibold">Riwayat Pembelian</h6>
                <p class="text-2xs text-slate-700 dark:text-slate-300">Daftar transaksi yang sudah dilakukan.</p>
            </div>

            <div class="block space-y-3">
                <template v-if="state.history.loading">
                    <div v-for="loading in 3" :key="loading" class="flex justify-between items-center w-full py-1 rounded-md font-flow bg-slate-100 dark:bg-slate-900/50">
                        <div class="flex justify-center items-center">
                            <div class="px-5 text-xs text-center text-slate-700 dark:text-slate-300">
                                {{ loading + '.' }}
                            </div>

                            <div class="block space-y-0.5 w-9/12 py-3">
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">San.1/qwert &middot; 1 hari yang lalu</p>
                                <h6 class="truncate text-xs font-semibold">0 Produk &middot; <span class="text-2xs text-slate-700 dark:text-slate-300">Diantar oleh admin</span></h6>
                                
                                <div class="flex space-x-2">
                                    <div class="h-5 w-5 rounded-md bg-slate-300 dark:bg-slate-700/50"></div>
                                    <div class="h-5 w-5 rounded-md bg-slate-300 dark:bg-slate-700/50"></div>
                                    <div class="h-5 w-5 rounded-md bg-slate-300 dark:bg-slate-700/50"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end items-center space-x-4 w-3/12 pr-4">
                            <div class="flex justify-between items-center border-2 rounded-md bg-slate-200 dark:bg-slate-900 border-transparent">
                                <h6 class="w-full p-1.5 text-xs text-center font-semibold text-slate-800 dark:text-slate-200">Rp. 00.000</h6>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-else>
                    <div v-for="(history, index) in state.history.data" :key="index" @click="detailTransaction(history.id)" class="flex justify-between items-center w-full py-1 rounded-md bg-slate-100 dark:bg-slate-900/50">
                        <div class="flex justify-center items-center">
                            <div class="px-5 text-xs text-center text-slate-700 dark:text-slate-300">
                                {{ (index + 1) + '.' }}
                            </div>

                            <div class="block space-y-0.5 w-9/12 py-3">
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">{{ history.kode_pembayaran + ' &middot; ' + day(history.updated_at).from() }}</p>
                                <h6 class="truncate text-xs font-semibold">{{ history.jumlah_produk }} Produk &middot; <span class="text-2xs text-slate-700 dark:text-slate-300">{{ 'Diantar oleh ' + history.nama_depan }}</span></h6>

                                <div class="flex space-x-2">
                                    <img v-for="image in history.thumbnail" :key="image" :src="image" class="h-5 w-5 rounded-md object-cover">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end items-center space-x-4 w-3/12 pr-4">
                            <div class="flex justify-between items-center border-2 rounded-md bg-slate-200 dark:bg-slate-900 border-transparent">
                                <h6 class="w-full p-1.5 text-xs text-center font-semibold text-slate-800 dark:text-slate-200">{{ 'Rp. ' + history.jumlah }}</h6>
                            </div>
                        </div>
                    </div>

                    <div v-if="state.history.data.length == 0" class="p-6 text-xs text-center">
                        Belum ada riwayat transaksi untuk saat ini, silahkan lakukan <router-link :to="{ name: 'dashboard.order' }" class="text-sky-500">pembelian</router-link> terlebih dahulu.
                    </div>
                </template>
            </div>
        </div>

        <div class="block space-y-4 h-1/2 p-4 overflow-auto bg-white dark:bg-slate-800">
            <div>
                <h6 class="text-sm font-semibold">Riwayat Topup Saldo</h6>
                <p class="text-2xs text-slate-700 dark:text-slate-300">Daftar riwayat topup saldo aplikasi.</p>
            </div>

            <div class="block space-y-3">
                <template v-if="state.topup.loading">
                    <div v-for="loading in 3" :key="loading" class="flex justify-between items-center w-full py-1 rounded-md font-flow bg-slate-100 dark:bg-slate-900/50">
                        <div class="flex justify-center items-center">
                            <div class="px-5 text-xs text-center text-slate-700 dark:text-slate-300">
                                {{ loading + '.' }}
                            </div>

                            <div class="block space-y-0.5 w-9/12 py-3">
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">San.1/Pay/qwert</p>
                                <h6 class="truncate text-xs font-semibold">Bank &middot; <span class="text-2xs text-slate-700 dark:text-slate-300">Bank_transfer</span></h6>
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">1 hari yang lalu</p>
                            </div>
                        </div>

                        <div class="flex justify-end items-center space-x-4 w-3/12 pr-4">
                            <div class="flex justify-between items-center border-2 rounded-md bg-slate-200 dark:bg-slate-900 border-transparent">
                                <h6 class="w-full p-1.5 text-xs text-center font-semibold text-slate-800 dark:text-slate-200">Rp. 00.000</h6>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-else>
                    <div v-for="(topup, index) in state.topup.data" :key="index" class="flex justify-between items-center w-full py-1 rounded-md bg-slate-100 dark:bg-slate-900/50">
                        <div class="flex justify-center items-center">
                            <div class="px-5 text-xs text-center text-slate-700 dark:text-slate-300">
                                {{ (index + 1) + '.' }}
                            </div>

                            <div class="block space-y-0.5 w-9/12 py-3">
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">{{ topup.kode_external }}</p>
                                <h6 class="truncate text-xs font-semibold">{{ topup.bank_kode }} &middot; <span class="text-2xs text-slate-700 dark:text-slate-300">{{ topup.metode }}</span></h6>
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">{{ day(topup.updated_at).from() }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end items-center space-x-4 w-3/12 pr-4">
                            <div class="flex justify-between items-center border-2 rounded-md bg-slate-200 dark:bg-slate-900 border-transparent">
                                <h6 class="w-full p-1.5 text-xs text-center font-semibold text-slate-800 dark:text-slate-200">{{ 'Rp. ' + topup.jumlah.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.") }}</h6>
                            </div>
                        </div>
                    </div>

                    <div v-if="state.topup.data.length == 0" class="p-6 text-xs text-center">
                        Belum ada riwayat topup saldo untuk sekarang, silahkan lakukan isi ulang saldo lewat aplikasi.
                    </div>
                </template>
            </div>
        </div>

        <TransitionRoot appear :show="state.detailHistory.modal" as="template">
            <Dialog as="div" :open="state.detailHistory.modal" @close="state.detailHistory.modal = false">
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
                                    <h6 class="text-sm font-semibold">Detail Transaksi</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Detail transaksi yang telah dilakukan.</p>
                                </div>

                                <button @click="state.detailHistory.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="block space-y-3">
                                <div v-for="(history, index) in state.detailHistory.detail" :key="index" class="flex items-center w-full rounded-md bg-slate-100 dark:bg-slate-900/50">
                                    <div class="flex items-center space-x-3 w-9/12 px-4 py-3">
                                        <img :src="history.path" :alt="history.nama_item" class="w-16 aspect-square rounded-md object-cover">

                                        <div class="block space-y-0.5 overflow-hidden">
                                            <h6 class="truncate text-xs font-semibold">{{ history.nama_item }}</h6>
                                            <h6 class="text-xs font-semibold">Rp. {{ history.harga.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.") }}</h6>
                                        </div>
                                    </div>

                                    <div class="flex justify-end items-center space-x-4 w-3/12 pr-4">
                                        <div class="flex justify-between items-center w-[4.75rem] border-2 rounded-md bg-slate-200 dark:bg-slate-900 border-transparent">
                                            <input type="number" :value="history.jumlah" placeholder="qty" class="w-full px-1 py-1.5 text-xs text-center font-semibold text-slate-800 dark:text-slate-200 bg-transparent focus:outline-none" readonly />
                                        </div>
                                    </div>
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
    import { inject, onMounted, reactive } from '@vue/runtime-core'

    import axios from 'axios'

    import { TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const day     = inject('day')

            const state   = reactive({
                history: {
                    loading: true,
                    data: []
                },

                topup: {
                    loading: true,
                    data: []
                },

                detailHistory: {
                    modal: false,
                    detail: []
                }
            })

            const detailTransaction = (id) => {
                axios.get('/api/user/history/' + id).then(({ data }) => {
                    state.detailHistory = {
                        modal: true,
                        detail: data.results
                    }
                })
            }

            onMounted(() => {
                axios.get('/api/user/history').then(({ data }) => {
                    state.history = {
                        loading: false,
                        data: data.results
                    }
                })

                axios.get('/api/user/topup/history').then(({ data }) => {
                    state.topup = {
                        loading: false,
                        data: data.results
                    }
                })
            })

            return {
                day,
                state,
                detailTransaction
            }
        }
    }
</script>
