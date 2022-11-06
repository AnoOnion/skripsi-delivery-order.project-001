<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Transaksi</div>
            </nav>

            <div class="flex justify-between items-end whitespace-nowrap">
                <div>
                    <h6 class="text-sm font-semibold">{{ store.getters['auth/level'] == 'admin' ? 'Semua' : '' }} Transaksi Pada Hari Ini.</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar transaksi yang terjadi pada hari ini.</p>
                </div>

                <div v-if="store.getters['auth/level'] == 'admin'" class="flex flex-col space-y-2">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Kurir</label>

                    <div class="relative flex w-36 py-2.5 rounded-md overscroll-contain bg-slate-200/50 dark:bg-slate-800/50">
                        <SelectInput
                            :options="[{ nama_depan: 'Semua' }, ...state.filters.rules.courier.data]"
                            @update:modelValue="v => state.filters.rules.courier.value = v"
                            :value="state.filters.rules.courier.value"
                            key-prop="nama_depan"
                            label-prop="nama_depan"
                            class="w-full text-xs font-semibold"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-auto">
            <table class="min-w-full divide-y divide-slate-50 dark:divide-slate-800">
                <thead class="bg-white dark:bg-slate-800/50">
                    <tr>
                        <th rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">NO</th>
                        <td rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ID TXT</td>
                        <td colspan="5" class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">DAFTAR ITEM</td>
                        <td rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">FEE</td>
                        <td rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">PEMBELI</td>
                        <td v-if="store.getters['auth/level'] == 'admin'" rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">KURIR</td>
                        <td rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ALAMAT PEMBELI</td>
                        <td rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">DIBUAT</td>
                    </tr>
                    <tr>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ID ITEM</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">NAMA ITEM</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">HARGA</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">QTY</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">TOTAL</td>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    <template v-for="(transaction, index) in state.pagination.listTransactions" :key="index">
                        <tr>
                            <template v-if="index != state.pagination.listTransactions.findIndex(v => v.id == transaction.id)">
                                <td colspan="2"></td>
                                <td class="px-5 py-3 text-sm whitespace-nowrap">{{ transaction.id_unique_pd }}</td>
                                <td class="px-5 py-3 text-sm whitespace-nowrap">{{ transaction.nama_item }}</td>
                                <td class="px-5 py-3 text-sm whitespace-nowrap">Rp. {{ rupiah(transaction.harga) }}</td>
                                <td class="px-5 py-3 text-sm text-center bg-slate-50 dark:bg-slate-800/50">{{ transaction.jumlah_tx }}</td>
                                <td class="px-5 py-3 text-sm whitespace-nowrap bg-slate-50 dark:bg-slate-800/50">Rp. {{ rupiah(transaction.total) }}</td>
                            </template>

                            <template v-else>
                                <th class="px-5 py-4 text-sm whitespace-nowrap text-slate-500">{{ ([...new Set(state.pagination.listTransactions.map(v => v.id))]).indexOf(transaction.id) + 1 + state.pagination.begin }}.</th>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ transaction.id_unique_tx }}</td>

                                <td class="px-5 py-3 text-sm whitespace-nowrap">{{ transaction.id_unique_pd }}</td>
                                <td class="px-5 py-3 text-sm whitespace-nowrap">{{ transaction.nama_item }}</td>
                                <td class="px-5 py-3 text-sm whitespace-nowrap">Rp. {{ rupiah(transaction.harga) }}</td>
                                <td class="px-5 py-3 text-sm text-center bg-slate-50 dark:bg-slate-800/50">{{ transaction.jumlah_tx }}</td>
                                <td class="px-5 py-3 text-sm whitespace-nowrap bg-slate-50 dark:bg-slate-800/50">Rp. {{ rupiah(transaction.total) }}</td>

                                <td class="px-5 py-3 text-sm whitespace-nowrap">Rp. {{ rupiah(transaction.jumlah_fee) }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ transaction.nama_depan + ' ' + (transaction.nama_belakang ?? '') }}</td>
                                <td v-if="store.getters['auth/level'] == 'admin'" class="px-5 py-4 text-sm whitespace-nowrap">{{ transaction.nama_depan_kurir + ' ' + (transaction.nama_belakang_kurir ?? '') }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ transaction.alamat_lengkap }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ day(transaction.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                            </template>
                        </tr>

                        <tr v-if="index == state.pagination.listTransactions.map(v => v.id).lastIndexOf(transaction.id)">
                            <td colspan="2"></td>
                            <td colspan="3" class="px-5 py-3 text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700/50">Jumlah Total Keseluruhan</td>
                            <td class="px-5 py-3 text-sm text-center font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700/50">{{ transaction.total_qty }}</td>
                            <td class="px-5 py-3 text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700/50">Rp. {{ rupiah(transaction.jumlah_py) }}</td>
                        </tr>

                        <tr v-if="(index + 1) != state.pagination.listTransactions.length && index == state.pagination.listTransactions.map(v => v.id).lastIndexOf(transaction.id)">
                            <td colspan="11" class="px-5 py-3"></td>
                        </tr>
                    </template>

                    <tr v-if="state.pagination.listTransactions.length == 0">
                        <td colspan="12" class="py-4 text-center text-sm">
                            Transaksi Belum Ada.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan {{ ([...new Set(state.pagination.listTransactions.map(v => v.id))]).length > 0 ? '1' : '0' }} sampai {{ ([...new Set(state.pagination.listTransactions.map(v => v.id))]).length }} dari {{ (
                state.filters.status ? state.filters.listTransactions : state.transactions.reduce((a, b) => {
                    a[b.id] = [...a[b.id] || [], b]
                    return a
                }, []).filter(v => v != null)
            ).length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= (
                    state.filters.status ? state.filters.listTransactions : state.transactions.reduce((a, b) => {
                        a[b.id] = [...a[b.id] || [], b]
                        return a
                    }, []).filter(v => v != null)
                ).length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { useStore } from 'vuex'
    import { inject, onMounted, reactive, watch } from '@vue/runtime-core'

    import axios from 'axios'

    import SelectInput from '~/components/form/SelectInput'
    import { Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        components: {
            SelectInput,
            Listbox, ListboxButton, ListboxOptions, ListboxOption, TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            const day    = inject('day')
            const rupiah = inject('rupiah')

            const store  = useStore()
            const state  = reactive({
                transactions: [],

                filters: {
                    status: false,
                    listTransactions: [],
                    rules: {
                        courier: {
                            data: [],
                            value: 'Semua'
                        }
                    }
                },

                pagination: {
                    begin: 0,
                    end: 10,
                    listTransactions: []
                }
            })

            const periodFilter = () => {
                state.pagination.begin = 0
                state.pagination.end = 10

                if (state.filters.rules.courier.value == 'Semua') {
                    state.filters.status = false
                    state.filters.listTransactions = []
                } else {
                    let filterCourier = state.transactions.filter(v => {
                                            return (
                                                state.filters.rules.courier.value == 'Semua' ||
                                                v.nama_depan_kurir == state.filters.rules.courier.value
                                            )
                                        })

                    state.filters.status = true
                    state.filters.listTransactions = filterCourier.reduce((a, b) => {
                                                        a[b.id] = [...a[b.id] || [], b]
                                                        return a
                                                    }, []).filter(v => v != null)
                }

                pageControl()
            }

            watch(() => state.filters.rules.courier.value, periodFilter)

            const pageControl = (direction = null) => {
                if (direction === 'left') {
                    state.pagination.begin -= 10
                    state.pagination.end -= 10
                } else if (direction === 'right') {
                    state.pagination.begin += 10
                    state.pagination.end += 10
                }

                let groupTransactions = []

                if (state.filters.status) {
                    groupTransactions = state.filters.listTransactions
                } else {
                    groupTransactions = state.transactions.reduce((a, b) => {
                                            a[b.id] = [...a[b.id] || [], b]
                                            return a
                                        }, []).filter(v => v != null)
                }

                state.pagination.listTransactions = groupTransactions.slice(
                                                        state.pagination.begin, state.pagination.end
                                                    ).reduce((a, b) => {
                                                        return [ ...a, ...b ]
                                                    }, [])
            }

            onMounted(() => {
                if (store.getters['auth/level'] == 'admin') {
                    axios.get('/api/admin/member').then(({ data }) => {
                        state.filters.rules.courier.data = data.results
                    })
                }

                if (store.getters['search/search'].length > 0) {
                    state.transactions = store.getters['search/search']

                    store.dispatch('search/saveDataSearch', [])
                } else {
                    axios.get('/api/admin/transaction/history').then(({ data }) => {
                        state.transactions = data.results

                        pageControl()
                    })
                }
            })

            return {
                day, rupiah,
                store, state,
                pageControl
            }
        }
    }
</script>
