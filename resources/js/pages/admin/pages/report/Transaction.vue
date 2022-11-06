<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Laporan</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Transaksi</div>
            </nav>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end space-x-0 md:space-x-4 space-y-3 md:space-y-0 whitespace-nowrap">
                <div class="flex justify-between items-center w-full">
                    <div>
                        <h6 class="text-sm font-semibold">Laporan Transaksi.</h6>
                        <p class="text-xs text-slate-700 dark:text-slate-300">Daftar semua laporan transaksi yang terjadi.</p>
                    </div>

                    <div>
                        <button @click="printReport" class="flex items-center space-x-1.5 px-3 py-2 rounded-lg text-white bg-blue-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>

                            <h6 class="text-xs">Cetak</h6>
                        </button>
                    </div>
                </div>

                <div class="grid md:flex grid-cols-12 items-center space-x-3 w-full md:w-auto">
                    <div class="col-span-4 flex flex-col space-y-2">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Kurir</label>

                        <div class="relative flex w-full md:w-36 py-2.5 border rounded-md overscroll-contain border-transparent bg-slate-200/50 dark:bg-slate-800/50">
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

                    <div class="col-span-4 flex flex-col space-y-2">
                        <label for="early-period-filter" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Periode Awal</label>

                        <div :class="state.printReport.error.message.errors?.early_period ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200/50 dark:bg-slate-800/50">
                            <input v-model="state.filters.rules.earlyPeriod" type="date" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="early-period-filter" />
                        </div>
                    </div>

                    <div class="col-span-4 flex flex-col space-y-2">
                        <label for="end-period-filter" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Periode Akhir</label>

                        <div :class="state.printReport.error.message.errors?.end_period ? 'border-rose-500' : 'border-transparent'" class="flex px-3 py-2.5 border rounded-md bg-slate-200/50 dark:bg-slate-800/50">
                            <input v-model="state.filters.rules.endPeriod" type="date" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="end-period-filter" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-auto">
            <table class="min-w-full divide-y divide-slate-50 dark:divide-slate-800">
                <thead class="bg-white dark:bg-slate-800/50">
                    <tr>
                        <th class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">NO</th>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ID TXT</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">NAMA PRODUK</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">HARGA</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">QTY</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">TOTAL</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">FEE</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">PEMBELI</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ADMIN</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ALAMAT PEMBELI</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">DIBUAT</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">DIEDIT</td>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    <template v-if="state.loading">
                        <tr v-for="loading in 3" :key="loading" class="text-sm font-flow">
                            <th class="px-5 py-4 whitespace-nowrap text-slate-500">x.</th>
                            <td class="px-5 py-4 whitespace-nowrap">San-123456-1</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="text-xs text-slate-500">PD-123456</div>
                                <div>Lorem, ipsum dolor.</div>
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">Rp. 00.000</td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">00</td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">Rp. 00.000</td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">Rp. 00.000</td>
                            <td class="px-5 py-4 whitespace-nowrap">Lorem, ipsum.</td>
                            <td class="px-5 py-4 whitespace-nowrap">Admin</td>
                            <td class="px-5 py-4 whitespace-nowrap">Lorem ipsum dolor sit amet consectetur.</td>
                            <td class="px-5 py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td class="px-5 py-4 whitespace-nowrap">00 00 00 00:00</td>
                        </tr>
                    </template>

                    <template v-else>
                        <template v-if="state.pagination.listTransactions.length > 0">
                            <tr v-for="(transaction, index) in state.pagination.listTransactions" :key="index" class="text-sm">
                                <th class="px-5 py-4 whitespace-nowrap text-slate-500">{{ index + 1 + state.pagination.begin }}.</th>
                                <td class="px-5 py-4 whitespace-nowrap">{{ transaction.id_unique_tx }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="text-xs text-slate-500">{{ transaction.id_unique_pd }}</div>
                                    <div>{{ transaction.nama_item }}</div>
                                </td>
                                <td class="px-5 py-4 text-center whitespace-nowrap">Rp. {{ rupiah(transaction.harga) }}</td>
                                <td class="px-5 py-4 text-center whitespace-nowrap">{{ transaction.jumlah }}</td>
                                <td class="px-5 py-4 text-center whitespace-nowrap">Rp. {{ rupiah(transaction.total) }}</td>
                                <td class="px-5 py-4 text-center whitespace-nowrap">Rp. {{ rupiah(transaction.jumlah_fee) }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">{{ transaction.nama_depan_us + ' ' + (transaction.nama_belakang_us ?? '') }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">{{ transaction.nama_depan_ad }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">{{ transaction.alamat_lengkap }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">{{ day(transaction.created_at).format('DD MMM YYYY - HH:mm') }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">{{ day(transaction.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                            </tr>

                            <tr>
                                <td class="px-5 py-3 bg-white dark:bg-slate-700/50"></td>
                                <td colspan="3" class="px-5 py-3 text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700/50">Jumlah Total Keseluruhan</td>
                                <td class="px-5 py-3 text-center text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700/50">{{ state.pagination.listTransactions.map(v => parseInt(v.jumlah)).reduce((a, b) => a + b, 0) }}</td>
                                <td class="px-5 py-3 text-center text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700/50">Rp. {{ rupiah(state.pagination.listTransactions.map(v => parseInt(v.total)).reduce((a, b) => a + b, 0)) }}</td>
                                <td class="px-5 py-3 text-center text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700/50">Rp. {{ rupiah(state.pagination.listTransactions.map(v => parseInt(v.jumlah_fee)).reduce((a, b) => a + b, 0)) }}</td>
                                <td colspan="5" class="px-5 py-3 bg-white dark:bg-slate-700/50"></td>
                            </tr>
                        </template>

                        <tr v-if="state.pagination.listTransactions.length == 0">
                            <td colspan="12" class="py-4 text-center text-sm">
                                Laporan Transaksi Belum Ada.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan {{ state.pagination.listTransactions.length > 0 ? '1' : '0' }} sampai {{ state.pagination.listTransactions.length }} dari {{ (state.filters.status ? state.filters.listTransactions : state.transactions).length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= (state.filters.status ? state.filters.listTransactions : state.transactions).length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { inject, onMounted, reactive, watch } from '@vue/runtime-core'

    import axios from 'axios'
    import fileDownload from 'js-file-download'

    import SelectInput from '~/components/form/SelectInput'

    export default {
        components: {
            SelectInput
        },

        setup(){
            const day    = inject('day')
            const rupiah = inject('rupiah')

            const state  = reactive({
                transactions: [],
                loading: true,

                filters: {
                    status: false,
                    listTransactions: [],
                    rules: {
                        courier: {
                            data: [],
                            value: 'Semua'
                        },
                        earlyPeriod: null,
                        endPeriod: null,
                    }
                },

                printReport: {
                    error: {
                        status: false,
                        message: {
                            errors: null,
                            message: null
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

                if (state.filters.rules.earlyPeriod && ['', null].includes(state.filters.rules.endPeriod)) {
                    state.filters.rules.endPeriod = day().add(1, 'day').format('YYYY-MM-DD')
                }

                if (
                    (state.filters.rules.earlyPeriod == '' || state.filters.rules.endPeriod == '') &&
                    state.filters.rules.courier.value == 'Semua'
                ) {
                    state.filters.status = false
                    state.filters.listTransactions = []
                } else {
                    state.filters.status = true
                    state.filters.listTransactions = state.transactions.filter(v => {
                        return (
                                (
                                    day( day(v.created_at).format('YYYY-MM-DD') ).isBetween(
                                    day(state.filters.rules.earlyPeriod).format('YYYY-MM-DD'),
                                    day(state.filters.rules.endPeriod).format('YYYY-MM-DD'), 'day', '[)'
                                ) && (
                                    state.filters.rules.courier.value == 'Semua' ||
                                    state.filters.rules.courier.value == v.nama_depan_ad
                                )
                            ) || (
                                (
                                    ['', null].includes(state.filters.rules.earlyPeriod) ||
                                    ['', null].includes(state.filters.rules.endPeriod)
                                ) && (
                                    state.filters.rules.courier.value == 'Semua' ||
                                    state.filters.rules.courier.value == v.nama_depan_ad
                                )
                            )
                        )
                    })
                }

                pageControl()
            }

            watch(() => state.filters.rules.courier.value, periodFilter)
            watch(() => state.filters.rules.earlyPeriod, periodFilter)
            watch(() => state.filters.rules.endPeriod, periodFilter)

            const printReport = () => {
                let early_period = (
                    state.filters.rules.earlyPeriod ? day(state.filters.rules.earlyPeriod).format('YYYY-MM-DD') : null
                )

                let end_period = (
                    state.filters.rules.endPeriod ? day(state.filters.rules.endPeriod).format('YYYY-MM-DD') : null
                )

                axios.post('/api/admin/print/report/transaction', {
                    early_period, end_period, courier: (
                        state.filters.rules.courier.value != 'Semua' ? state.filters.rules.courier.value : null
                    ) 
                }, {
                    responseType: 'blob'
                }).then(({ data }) => {
                    fileDownload(
                        data, 'laporan-transaksi-' + early_period + '-' + end_period + '.pdf'
                    )

                    state.printReport.error = {
                        status: false,
                        message: {
                            errors: null,
                            message: null
                        }
                    }
                }).catch(async ({ response }) => {
                    state.printReport.error = {
                        status: true,
                        message: JSON.parse(
                            await response.data.text()
                        )
                    }
                })
            }

            const pageControl = (direction = null) => {
                if (direction === 'left') {
                    state.pagination.begin -= 10
                    state.pagination.end -= 10
                } else if (direction === 'right') {
                    state.pagination.begin += 10
                    state.pagination.end += 10
                }

                state.pagination.listTransactions = (
                    state.filters.status ? state.filters.listTransactions : state.transactions
                ).slice(
                    state.pagination.begin, state.pagination.end
                )
            }

            onMounted(() => {
                axios.get('/api/admin/member').then(({ data }) => {
                    state.filters.rules.courier.data = data.results
                })

                axios.get('/api/admin/report/transaction').then(({ data }) => {
                    state.loading = false
                    state.transactions = data.results

                    pageControl()
                })
            })

            return {
                day, rupiah,
                state,
                printReport, pageControl
            }
        }
    }
</script>
