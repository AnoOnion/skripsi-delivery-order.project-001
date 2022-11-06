<template>
    <div :class="$route.meta.wide ? 'md:w-1/6' : 'md:w-2/6'" class="block space-y-3 md:space-y-4 w-full h-full md:h-[calc(100vh-74px)] p-0 md:p-4 z-10 bg-slate-100 md:bg-transparent dark:bg-slate-700">
        <div class="grid grid-cols-12 gap-3 md:gap-4 w-full text-black dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="hidden absolute top-0 left-0 w-full" viewBox="0 50 1440 320">
                <path fill="#3b82f6" fill-opacity="1" d="M0,256L48,250.7C96,245,192,235,288,213.3C384,192,480,160,576,165.3C672,171,768,213,864,197.3C960,181,1056,107,1152,80C1248,53,1344,75,1392,85.3L1440,96L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
            </svg>

            <div class="absolute top-6 w-full px-4 md:px-0 z-10">
                <div class="flex justify-between items-center w-full p-2 rounded-lg shadow-md bg-blue-400 dark:bg-slate-800">
                    <div class="flex items-center space-x-2">
                        <button @click="state.topup.modal = true" class="flex items-center space-x-2 px-2.5 py-2 text-left rounded-md bg-white dark:bg-slate-900/50 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>

                            <div>
                                <h6 class="text-2xs font-semibold text-slate-700 dark:text-slate-300">Saldo</h6>
                                <h4 class="text-xs font-semibold">Rp. {{ store.getters['buyer/asset'].saldo.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.") }}</h4>
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">Tap untuk top up</p>
                            </div>
                        </button>

                        <div class="flex items-center space-x-2 px-2.5 py-2 rounded-md bg-white dark:bg-slate-900/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>

                            <div>
                                <h6 class="text-2xs font-semibold text-slate-700 dark:text-slate-300">Kupon</h6>
                                <h4 class="text-xs font-semibold">{{ store.getters['buyer/asset'].kupon }} Item</h4>
                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">10 kupon / 1 galon</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center pl-1 pr-0.5">
                        <button @click="state.topup.modal = true" class="flex flex-col justify-center items-center space-y-1 p-2 group focus:outline-none">
                            <div class="p-1 rounded-md text-blue-400 dark:text-blue-200 group-hover:text-white bg-white dark:bg-blue-500/50 group-hover:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>

                            <h6 class="truncate text-xs font-semibold text-white">Top up</h6>
                        </button>

                        <router-link :to="{ name: 'dashboard.history' }" class="flex flex-col justify-center items-center space-y-1 p-2 group focus:outline-none">
                            <div class="p-1 rounded-md text-blue-400 dark:text-blue-200 group-hover:text-white bg-white dark:bg-blue-500/50 group-hover:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>

                            <h6 class="truncate text-xs font-semibold text-white">Riwayat</h6>
                        </router-link>
                    </div>
                </div>
            </div>

            <div class="col-span-5 md:col-span-4 hidden md:block relative">
                <div class="block space-y-2 absolute top-0 left-0 w-full h-20 p-4 rounded-lg rounded-b-none bg-white dark:bg-slate-800 before:absolute before:bottom-0 before:-left-2 before:w-2 before:h-2 before:bg-radial-gradient-l dark:before:bg-radial-gradient-dark-l">
                    <div class="flex flex-col space-y-1">
                        <label for="distance" class="text-2xs text-slate-700 dark:text-slate-300">Informasi</label>
                        <h6 id="distance" class="text-xs">Temukan Info Pemesanan Disini.</h6>
                    </div>
                </div>
            </div>

            <div class="col-span-12 block space-y-3 md:space-y-4 min-h-[calc(100vh-130px)] md:h-[calc(100vh-192px)] overflow-hidden md:overflow-auto">
                <div class="pt-10 mt-16 rounded-t-lg md:rounded-lg md:rounded-tr-none bg-white dark:bg-slate-800">
                    <Swiper
                        :modules="modulesSwiper"
                        :loop="true"
                        :spaceBetween="12"
                        :autoplay="{
                            delay: 5000,
                            disableOnInteraction: false
                        }"
                        :pagination="{ clickable: true }"
                        class="w-full !pl-6 !pr-6 !py-4"
                    >
                        <template v-if="state.informations.length > 0">
                            <SwiperSlide v-for="(info, index) in state.informations" :key="index">
                                <router-link :to="{ name: 'dashboard.article', params: { slug: info.slug } }">
                                    <img :src="info.gambar" class="w-full h-32 rounded-md object-cover drop-shadow-md" />
                                </router-link>
                            </SwiperSlide>
                        </template>

                        <template v-else>
                            <SwiperSlide v-for="loading in 3" :key="loading">
                                <div class="w-full h-32 rounded-md object-cover bg-slate-300 dark:bg-slate-700/50"></div>
                            </SwiperSlide>
                        </template>
                    </Swiper>
                </div>

                <div class="block space-y-3 h-full p-4 bg-white dark:bg-slate-800">
                    <div>
                        <h6 class="text-sm font-semibold">Berita Tentang Pemesanan !</h6>
                        <p class="text-2xs text-slate-700 dark:text-slate-300">Temukan berita informasi toko.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <template v-if="state.loading">
                            <div v-for="loading in 4" :key="loading" class="block space-y-3 font-flow">
                                <div class="w-full aspect-video rounded-md bg-slate-300 dark:bg-slate-700/50"></div>

                                <div class="block space-y-0.5 overflow-hidden">
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Admin &middot; 00 00 0000 00:00</p>
                                    <h6 class="truncate text-sm font-semibold">Lorem ipsum dolor sit.</h6>
                                    <p class="text-xs text-slate-700 dark:text-slate-300">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dignissimos, cumque?</p>
                                </div>
                            </div>
                        </template>

                        <template v-else>
                            <router-link v-for="(info, index) in state.informations" :key="index" :to="{ name: 'dashboard.article', params: { slug: info.slug } }" class="block space-y-3">
                                <img :src="info.gambar" :alt="info.judul" class="w-full aspect-video rounded-md object-cover drop-shadow-md">

                                <div class="block space-y-0.5 overflow-hidden">
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">{{ info.nama_depan + ' &middot; ' + day(info.created_at).format('DD MMM YYYY - HH:mm') }}</p>
                                    <h6 class="truncate text-sm font-semibold">{{ info.judul }}</h6>
                                    <p class="text-xs text-slate-700 dark:text-slate-300">{{ info.deskripsi }}</p>
                                </div>
                            </router-link>

                            <div v-if="state.informations.length == 0" class="text-sm text-center text-slate-700 dark:text-slate-300">
                                Informasi belum ada.
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <TransitionRoot appear :show="state.topup.modal" as="template">
            <Dialog as="div" @close="state.topup.modal = false">
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
                            <div class="flex flex-col space-y-2">
                                <label for="amount" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jumlah TopUp</label>

                                <div class="flex justify-between items-center px-3 py-2.5 border rounded-md bg-slate-200 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-50 border-transparent">
                                    <input v-model="state.topup.amount" @focus="state.topup.amount == 0 ? null : state.topup.amount" type="number" class="w-full text-xs font-semibold bg-transparent focus:outline-none" id="amount" placeholder="Ex. 50000">
                                </div>
                            </div>

                            <div class="block space-y-2 text-xs text-slate-700 dark:text-slate-300">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                    <p>Pastikan jumlah yang dimasukan benar.</p>
                                </div>

                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                    <p>Jika saldo belum masuk, hubungi kurir atau contact support kami.</p>
                                </div>
                            </div>

                            <button @click="topup" :disabled="state.topup.amount <= 500" class="px-3 py-2 text-xs rounded-md text-white bg-blue-500 focus:outline-none">Topup Saldo</button>
                        </div>
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

    import { Autoplay } from 'swiper'
    import { Swiper, SwiperSlide } from 'swiper/vue'

    import { TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            Swiper, SwiperSlide,
            TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const day    = inject('day')

            const store  = useStore()
            const state  = reactive({
                loading: true,

                informations: [],

                topup: {
                    modal: false,
                    amount: 0
                }
            })

            let previousUrl = null;
            let windowObjectReference = null;

            const openTopUpWindow = (url, name) => {
                const windowFeatures = 'toolbar=no, menubar=no, width=600, height=700, top=100, left=100';

                if (windowObjectReference === null || windowObjectReference.closed) {
                    windowObjectReference = window.open(url, name, windowFeatures)
                } else if (previousUrl !== url) {
                    windowObjectReference = window.open(url, name, windowFeatures)
                    windowObjectReference.focus()
                } else {
                    windowObjectReference.focus()
                }

                previousUrl = url
            }

            const topup = () => {
                axios.post('/api/user/topup/create', {
                    jumlah_topup: state.topup.amount
                }).then(({ data }) => {
                    state.topup.modal  = false
                    openTopUpWindow(data.results.invoice_url, 'TopUp Saldo')
                })
            }

            onMounted(() => {
                axios.get('/api/user/information').then(({ data }) => {
                    state.loading = false
                    state.informations = data.results
                })
            })

            return {
                day,
                store, state,
                modulesSwiper: [ Autoplay ],
                topup
            }
        }
    }
</script>
