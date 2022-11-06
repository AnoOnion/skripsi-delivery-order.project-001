<template>
    <div class="grid grid-cols-[repeat(16,minmax(0,1fr))] gap-3 w-full">
        <div class="col-span-6 flex flex-col space-y-1">
            <label for="balance" class="relative text-2xs text-slate-700 dark:text-slate-300">
                <h6>Saldo</h6>

                <button @click="state.topup.modal = true" class="absolute -top-1 left-8 p-0.5 rounded-md group bg-blue-500/60 dark:bg-blue-500/50 hover:bg-blue-500 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white dark:text-blue-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </button>
            </label>

            <h6 id="balance" class="truncate text-xs font-semibold">Rp. {{ state.nominal ? store.getters['buyer/asset'].saldo.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.") : '****' }}</h6>
        </div>

        <div class="col-span-5 flex flex-col space-y-1">
            <label for="coupon" class="text-2xs text-slate-700 dark:text-slate-300">Kupon</label>
            <h6 id="coupon" class="truncate text-xs font-semibold">{{ state.nominal ? store.getters['buyer/asset'].kupon : '**' }} Kupon</h6>
        </div>

        <div class="col-span-5 flex flex-col space-y-1">
            <label for="transaction" class="text-2xs text-slate-700 dark:text-slate-300">Jumlah Tx</label>
            <h6 id="transaction" class="truncate text-xs font-semibold">{{ state.nominal ? (store.getters['buyer/payment'].total_tx ?? 0) : '**' }} Transaksi</h6>
        </div>
    </div>

    <button @click="state.nominal = !state.nominal" class="focus:outline-none">
        <svg v-if="state.nominal" xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>

        <svg v-if="!state.nominal" xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        </svg>
    </button>

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
</template>

<script>
    import { useStore } from 'vuex'
    import { reactive } from '@vue/runtime-core'

    import axios from 'axios'

    import { TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const store  = useStore()
            const state  = reactive({
                nominal: true,

                topup: {
                    modal: false,
                    amount: 0
                }
            })

            const topup = () => {
                axios.post('/api/user/topup/create', {
                    jumlah_topup: state.topup.amount
                }).then(({ data }) => {
                    state.topup.modal  = false
                    openTopUpWindow(data.results.invoice_url, 'TopUp Saldo')
                })
            }

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

            return {
                store, state,
                topup
            }
        }
    }
</script>
